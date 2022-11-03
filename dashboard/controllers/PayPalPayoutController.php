<?php
class PayPalPayoutController extends PayoutBaseController
{
    public const KEY_NAME = 'PayPalPayout';
    private $plugin;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->init();
    }
    
    private function init(): void
    {
        $this->plugin = LibHelper::callPlugin(self::KEY_NAME, [$this->siteLangId], $error, $this->siteLangId);
    }

    public static function reqFields()
    {
        $payoutPlugins = Plugin::getNamesWithCode(Plugin::TYPE_PAYOUTS, CommonHelper::getLangId());
        $payouts = [-1 => Labels::getLabel("LBL_BANK_PAYOUT")] + $payoutPlugins;
        $reqFields = [
            'payout' => [
                'type' => PluginSetting::TYPE_SELECT,
                'required' => false,
                'label' => "Select Payout",
                'options' => $payouts,
                'selectedValue' => self::KEY_NAME,
                'selectCaption' => '',
            ],
            'amount' => [
                'type' => PluginSetting::TYPE_FLOAT,
                'required' => true,
                'label' => "Amount",
            ]
        ];
        $formFields = self::formFields();
        return array_merge($reqFields, $formFields);
    }

    public static function formFields()
    {
        return (self::KEY_NAME)::formFields();
    }

    public function payoutInfoForm()
    {
        $frm = $this->getFormObj(static::formFields());

        $data = User::getUserMeta(UserAuthentication::getLoggedUserId());
        if (!empty($data)) {
            $frm->fill($data);
        }

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function getRequestForm()
    {
        $frm = $this->getFormObj(self::reqFields());

        $data = User::getUserMeta(UserAuthentication::getLoggedUserId());
        if (!empty($data)) {
            $frm->fill($data);
        }
        $this->set('frm', $frm);
        $this->set('walletBalance', User::getUserBalance(UserAuthentication::getLoggedUserId(true)));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function saveWithdrawalSpecifics($withdrawalId, $data, $elements)
    {
        if (empty($withdrawalId) || empty($data) || empty($elements)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }

        foreach ($data as $key => $val) {
            if (!in_array($key, $elements)) {
                continue;
            }
            $updateData = [
                'uwrs_withdrawal_id' => $withdrawalId,
                'uwrs_key' => $key,
                'uwrs_value' => is_array($val) ? serialize($val) : $val,
            ];

            if (!FatApp::getDb()->insertFromArray(User::DB_TBL_USR_WITHDRAWAL_REQ_SPEC, $updateData, true, array(), $updateData)) {
                $message = Labels::getLabel('LBL_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId);
                FatUtility::dieJsonError($message);
            }
        }
        return true;
    }

    public function setupAccountForm()
    {
        $frm = $this->getFormObj(self::formFields());

        $post = array_filter($frm->getFormDataFromArray(FatApp::getPostedData()));
        unset($post['keyName'], $post['plugin_id']);
        $this->updateUserInfo($post);
    }

    public function setup()
    {
        $this->validateWithdrawalRequest();

        $frm = PluginSetting::getForm(self::reqFields(), $this->siteLangId);

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $post['withdrawal_amount'] = $post['amount'];
        if (empty($post['email']) && empty($post['paypal_id'])) {
            $post['email'] = UserAuthentication::getLoggedUserAttribute('user_email');
        }

        if (false === $post) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $userObj = new User($userId);
        $withdrawal_payment_method = FatApp::getPostedData('plugin_id', FatUtility::VAR_INT, 0);
        if (1 > $withdrawal_payment_method) {
            $withdrawal_payment_method = Plugin::getAttributesByCode(self::KEY_NAME, 'plugin_id');
        }

        $post['withdrawal_payment_method'] = $withdrawal_payment_method;

        if (!$withdrawRequestId = $userObj->addWithdrawalRequest(array_merge($post, array("ub_user_id" => $userId)), $this->siteLangId)) {
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $this->saveWithdrawalSpecifics($withdrawRequestId, $post, array_keys(self::reqFields()));

        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendWithdrawRequestNotification($withdrawRequestId, $this->siteLangId, "A")) {
            $message = Labels::getLabel($emailNotificationObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        //send notification to admin
        $notificationData = array(
            'notification_record_type' => Notification::TYPE_WITHDRAWAL_REQUEST,
            'notification_record_id' => $withdrawRequestId,
            'notification_user_id' => UserAuthentication::getLoggedUserId(),
            'notification_label_key' => Notification::WITHDRAWL_REQUEST_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s'),
        );

        if (!Notification::saveNotifications($notificationData)) {
            $message = Labels::getLabel("MSG_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $this->set('msg', Labels::getLabel('MSG_Withdraw_request_placed_successfully', $this->siteLangId));

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }
}
