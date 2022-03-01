<?php

class AccountController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
        if (!isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'])) {
            $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = '';
            if (User::isBuyer() || User::isSigningUpBuyer()) {
                $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'B';
            } elseif (User::isSeller() || User::isSigningUpForSeller()) {
                $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'S';
            } elseif (User::isAdvertiser() || User::isSigningUpAdvertiser()) {
                $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'Ad';
            } elseif (User::isAffiliate() || User::isSigningUpAffiliate()) {
                $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'AFFILIATE';
            }
        }
        $this->set('bodyClass', 'is--dashboard');
    }

    public function index()
    {
        if (UserAuthentication::isGuestUserLogged()) {
            FatApp::redirectUser(UrlHelper::generateUrl('home'));
        }

        switch ($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) {
            case 'B':
                FatApp::redirectUser(UrlHelper::generateUrl('buyer'));
                break;
            case 'S':
                FatApp::redirectUser(UrlHelper::generateUrl('seller'));
                break;
            case 'Ad':
                FatApp::redirectUser(UrlHelper::generateUrl('advertiser'));
                break;
            case 'AFFILIATE':
                FatApp::redirectUser(UrlHelper::generateUrl('affiliate'));
                break;
            default:
                FatApp::redirectUser(UrlHelper::generateUrl(''));
                break;
        }

        /* $user = new User(UserAuthentication::getLoggedUserId());
        $this->set('data', $user->getProfileData());
        $this->_template->render(true,false); */
    }

    public function viewSupplierRequest($requestId)
    {
        $userId = UserAuthentication::getLoggedUserId();
        $requestId = FatUtility::int($requestId);

        if ($userId < 1 || $requestId < 1) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'SupplierApprovalForm'));
        }

        $userObj = new User($userId);
        $srch = $userObj->getUserSupplierRequestsObj($requestId);
        $srch->addFld('tusr.*');

        $rs = $srch->getResultSet();

        $supplierRequest = FatApp::getDb()->fetch($rs);

        if (!$supplierRequest || $supplierRequest['usuprequest_id'] != $requestId) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'SupplierApprovalForm'));
        }
        $maxAttempts = FatApp::getConfig('CONF_MAX_SUPPLIER_REQUEST_ATTEMPT', FatUtility::VAR_INT, 3);
        if ($supplierRequest && $supplierRequest['usuprequest_attempts'] >= $maxAttempts) {
            $this->set('maxAttemptsReached', true);
        }


        $this->set('supplierRequest', $supplierRequest);
        $this->_template->render();
    }

    public function supplierApprovalForm($p = '')
    {
        if (!User::canViewSupplierTab()) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST_FOR_SUPPLIER_DASHBOARD', $this->siteLangId));
            if (User::isBuyer()) {
                FatApp::redirectUser(UrlHelper::generateUrl('buyer'));
            } elseif (User::isAdvertiser()) {
                FatApp::redirectUser(UrlHelper::generateUrl('advertiser'));
            } elseif (User::isAffiliate()) {
                FatApp::redirectUser(UrlHelper::generateUrl('affiliate'));
            } else {
                FatApp::redirectUser(UrlHelper::generateUrl('Account', 'ProfileInfo'));
            }
        }
        $userId = UserAuthentication::getLoggedUserId();

        $userObj = new User($userId);
        $srch = $userObj->getUserSupplierRequestsObj();
        $srch->addFld(array('usuprequest_attempts', 'usuprequest_id'));

        $rs = $srch->getResultSet();
        if (!$rs) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $supplierRequest = FatApp::getDb()->fetch($rs);
        $maxAttempts = FatApp::getConfig('CONF_MAX_SUPPLIER_REQUEST_ATTEMPT', FatUtility::VAR_INT, 3);
        if ($supplierRequest && $supplierRequest['usuprequest_attempts'] >= $maxAttempts) {
            Message::addErrorMessage(Labels::getLabel('ERR_YOU_HAVE_ALREADY_CONSUMED_MAX_ATTEMPTS', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('account', 'viewSupplierRequest', array($supplierRequest["usuprequest_id"])));
        }

        if ($supplierRequest && ($p != "reopen")) {
            FatApp::redirectUser(UrlHelper::generateUrl('account', 'viewSupplierRequest', array($supplierRequest["usuprequest_id"])));
        }

        $data = array('id' => isset($supplierRequest['usuprequest_id']) ? $supplierRequest['usuprequest_id'] : 0);
        $approvalFrm = $this->getSupplierForm();
        $approvalFrm->fill($data);
        $approvalFrm->addSecurityToken();

        $this->set('approvalFrm', $approvalFrm);
        $this->_template->render();
    }

    public function setupSupplierApproval()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $error_messages = array();
        $fieldIdsArr = array();
        /* check if maximum attempts reached [ */
        $userObj = new User($userId);
        $srch = $userObj->getUserSupplierRequestsObj();
        $srch->addFld(array('usuprequest_attempts', 'usuprequest_id'));

        $rs = $srch->getResultSet();
        if (!$rs) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $supplierRequest = FatApp::getDb()->fetch($rs);
        $maxAttempts = FatApp::getConfig('CONF_MAX_SUPPLIER_REQUEST_ATTEMPT', FatUtility::VAR_INT, 3);
        if ($supplierRequest && $supplierRequest['usuprequest_attempts'] >= $maxAttempts) {
            Message::addErrorMessage(Labels::getLabel('ERR_YOU_HAVE_ALREADY_CONSUMED_MAX_ATTEMPTS', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        /* ] */

        $frm = $this->getSupplierForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData(), [], true);

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $frm->expireSecurityToken(FatApp::getPostedData());

        $supplier_form_fields = $userObj->getSupplierFormFields($this->siteLangId);

        foreach ($supplier_form_fields as $field) {
            $fieldIdsArr[] = $field['sformfield_id'];
            //$fieldCaptionsArr[] = $field['sformfield_caption'];
            if ($field['sformfield_required'] && empty($post["sformfield_" . $field['sformfield_id']])) {
                $error_messages[] = sprintf(Labels::getLabel('ERR_LABEL_REQUIRED', $this->siteLangId), $field['sformfield_caption']);
            }
        }

        if (!empty($error_messages)) {
            Message::addErrorMessage($error_messages);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $reference_number = $userId . '-' . time();
        $data = array_merge($post, array("user_id" => $userId, "reference" => $reference_number, 'fieldIdsArr' => $fieldIdsArr));

        $db = FatApp::getDb();
        $db->startTransaction();

        if (!$supplier_request_id = $userObj->addSupplierRequestData($data, $this->siteLangId)) {
            $db->rollbackTransaction();
            Message::addErrorMessage(Labels::getLabel('ERR_DETAILS_NOT_SAVED', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        if (FatApp::getConfig("CONF_ADMIN_APPROVAL_SUPPLIER_REGISTRATION", FatUtility::VAR_INT, 1)) {
            $approval_request = 1;
            $msg = Labels::getLabel('SUC_YOUR_SELLER_APPROVAL_FORM_REQUEST_SENT', $this->siteLangId);
        } else {
            $approval_request = 0;
            $msg = Labels::getLabel('SUC_YOUR_APPLICATION_IS_APPROVED', $this->siteLangId);
        }

        if (!$this->notifyAdminSupplierApproval($userObj, $data, $approval_request)) {
            $db->rollbackTransaction();
            Message::addErrorMessage(Labels::getLabel("ERR_SELLER_APPROVAL_EMAIL_COULD_NOT_BE_SENT", $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        //send notification to admin
        $notificationData = array(
            'notification_record_type' => Notification::TYPE_USER,
            'notification_record_id' => $userObj->getMainTableRecordId(),
            'notification_user_id' => $userId,
            'notification_label_key' => ($approval_request) ? Notification::NEW_SUPPLIER_APPROVAL_NOTIFICATION : Notification::NEW_SELLER_APPROVED_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s'),
        );

        if (!Notification::saveNotifications($notificationData)) {
            $db->rollbackTransaction();
            Message::addErrorMessage(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $db->commitTransaction();
        $this->set('supplier_request_id', $supplier_request_id);
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function uploadSupplierFormImages()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $post = FatApp::getPostedData();

        if (empty($post)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST_OR_FILE_NOT_SUPPORTED', $this->siteLangId));
        }
        $field_id = $post['field_id'];

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->isUploadedFile($_FILES['file']['tmp_name'])) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $fileHandlerObj->deleteFile($fileHandlerObj::FILETYPE_SELLER_APPROVAL_FILE, $userId, 0, $field_id);

        if (!$res = $fileHandlerObj->saveAttachment(
            $_FILES['file']['tmp_name'],
            $fileHandlerObj::FILETYPE_SELLER_APPROVAL_FILE,
            $userId,
            $field_id,
            $_FILES['file']['name'],
            -1,
            $unique_record = false
        )) {
            /* Message::addErrorMessage($fileHandlerObj->getError()); */
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('file', $_FILES['file']['name']);
        $this->set('msg', /* $_FILES['file']['name'].' '. */ Labels::getLabel('SUC_FILE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changeEmailPassword()
    {
        $this->set('siteLangId', $this->siteLangId);
        $this->set('canSendSms', SmsArchive::canSendSms(SmsTemplate::LOGIN));
        $this->_template->render();
    }

    public function changePasswordForm()
    {
        $frm = $this->getChangePasswordForm();

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function updatePassword()
    {
        $pwdFrm = $this->getChangePasswordForm();
        $post = $pwdFrm->getFormDataFromArray(FatApp::getPostedData());

        if ($post === false) {
            $message = Labels::getLabel(current($pwdFrm->getValidationErrors()), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $userId = UserAuthentication::getLoggedUserId();
        /* Restrict to change password for demo user on demo URL. */
        if (CommonHelper::demoUrl() && 4 == $userId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_YOU_ARE_NOT_ALLOWED_TO_CHANGE_PASSWORD_FOR_DEMO', $this->siteLangId));
        }

        $userObj = new User($userId);
        $srch = $userObj->getUserSearchObj(array('user_id', 'credential_password'));
        $rs = $srch->getResultSet();

        $data = FatApp::getDb()->fetch($rs, 'user_id');

        if ($data === false) {
            $message = Labels::getLabel('ERR_INVALID_USER', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if ($data['credential_password'] != UserAuthentication::encryptPassword($post['current_password'])) {
            $message = Labels::getLabel('ERR_YOUR_CURRENT_PASSWORD_MIS_MATCHED', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if (!$userObj->setLoginPassword($post['new_password'])) {
            $message = Labels::getLabel('ERR_PASSWORD_COULD_NOT_BE_SET', $this->siteLangId) . $userObj->getError();
            FatUtility::dieJsonError($message);
        }

        $this->set('msg', Labels::getLabel('SUC_PASSWORD_CHANGED_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function setPrefferedDashboard($dasboardType)
    {
        $dasboardType = FatUtility::int($dasboardType);

        switch ($dasboardType) {
            case User::USER_BUYER_DASHBOARD:
                if (!User::canViewBuyerTab()) {
                    Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
                    FatUtility::dieJsonError(Message::getHtml());
                }
                break;
            case User::USER_SELLER_DASHBOARD:
                if (!User::canViewSupplierTab()) {
                    Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
                    FatUtility::dieJsonError(Message::getHtml());
                }
                break;
            case User::USER_ADVERTISER_DASHBOARD:
                if (!User::canViewAdvertiserTab()) {
                    Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
                    FatUtility::dieJsonError(Message::getHtml());
                }
                break;
            case User::USER_AFFILIATE_DASHBOARD:
                if (!User::canViewAffiliateTab()) {
                    Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
                    FatUtility::dieJsonError(Message::getHtml());
                }
                break;
            default:
                Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
                FatUtility::dieJsonError(Message::getHtml());
                break;
        }

        $arr = array('user_preferred_dashboard' => $dasboardType);

        $userId = UserAuthentication::getLoggedUserId();
        $userId = FatUtility::int($userId);
        if (1 > $userId) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $userObj = new User($userId);
        $userObj->assignValues($arr);
        if (!$userObj->save()) {
            Message::addErrorMessage($userObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('SUC_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function credits()
    {
        $frm = $this->getCreditsSearchForm($this->siteLangId);

        $userId = UserAuthentication::getLoggedUserId();

        $canAddMoneyToWallet = true;
        if (User::isAffiliate()) {
            $canAddMoneyToWallet = false;
        }
        $codMinWalletBalance = -1;
        if (User::isSeller() && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] == 'S') {
            $shop_cod_min_wallet_balance = Shop::getAttributesByUserId($userId, 'shop_cod_min_wallet_balance');
            if ($shop_cod_min_wallet_balance > -1) {
                $codMinWalletBalance = $shop_cod_min_wallet_balance;
            } elseif (FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1) > -1) {
                $codMinWalletBalance = FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1);
            }
        }
        $txnObj = new Transactions();

        $payoutPlugins = Plugin::getNamesWithCode(Plugin::TYPE_PAYOUTS, $this->siteLangId);
        $accountSummary = $txnObj->getTransactionSummary($userId);
        $payouts = [-1 => Labels::getLabel("MSG_BANK_PAYOUT", $this->siteLangId)] + $payoutPlugins;
        $this->set('payouts', $payouts);
        $this->set('userWalletBalance', User::getUserBalance(UserAuthentication::getLoggedUserId()));
        $this->set('codMinWalletBalance', $codMinWalletBalance);
        $this->set('frmSrch', $frm);
        $this->set('accountSummary', $accountSummary);
        $this->set('frmRechargeWallet', $this->getRechargeWalletForm($this->siteLangId));
        $this->set('canAddMoneyToWallet', $canAddMoneyToWallet);
        $this->_template->render();
    }

    public function payouts()
    {
        $payoutPlugins = Plugin::getDataByType(Plugin::TYPE_PAYOUTS, $this->siteLangId);
        $data = [
            'isBankPayoutEnabled' => applicationConstants::YES,
            'payoutPlugins' => array_values($payoutPlugins)
        ];
        $this->set('data', $data);
        $this->_template->render();
    }

    public function creditsInfo()
    {
        $this->set('userWalletBalance', User::getUserBalance(UserAuthentication::getLoggedUserId()));
        $this->set('userTotalWalletBalance', User::getUserBalance(UserAuthentication::getLoggedUserId(), false, false));
        $this->set('promotionWalletToBeCharged', Promotion::getPromotionWalleToBeCharged(UserAuthentication::getLoggedUserId()));
        $this->set('withdrawlRequestAmount', User::getUserWithdrawnRequestAmount(UserAuthentication::getLoggedUserId()));

        if (false === MOBILE_APP_API_CALL) {
            $this->_template->render(false, false);
        }
    }

    public function setUpWalletRecharge()
    {
        $minimumRechargeAmount = 1;
        $frm = $this->getRechargeWalletForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $order_net_amount = $post['amount'];
        if ($order_net_amount < $minimumRechargeAmount) {

            $str = Labels::getLabel("ERR_RECHARGE_AMOUNT_MUST_BE_GREATER_THAN_{minimumrechargeamount}", $this->siteLangId);
            $str = str_replace("{minimumrechargeamount}", CommonHelper::displayMoneyFormat($minimumRechargeAmount, true, true), $str);
            LibHelper::dieJsonError($str);
        }
        $orderData = array();
        $order_id = isset($_SESSION['wallet_recharge_cart']["order_id"]) ? $_SESSION['wallet_recharge_cart']["order_id"] : false;
        $orderData['order_type'] = Orders::ORDER_WALLET_RECHARGE;

        $orderData['userAddresses'] = array(); //No Need of it
        $orderData['order_id'] = $order_id;
        $orderData['order_user_id'] = $loggedUserId;
        $orderData['order_payment_status'] = Orders::ORDER_PAYMENT_PENDING;
        $orderData['order_date_added'] = date('Y-m-d H:i:s');

        /* order extras[ */
        $orderData['extra'] = array(
            'oextra_order_id' => $order_id,
            'order_ip_address' => $_SERVER['REMOTE_ADDR']
        );

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $orderData['extra']['order_forwarded_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $orderData['extra']['order_forwarded_ip'] = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $orderData['extra']['order_forwarded_ip'] = '';
        }

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $orderData['extra']['order_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $orderData['extra']['order_user_agent'] = '';
        }

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $orderData['extra']['order_accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        } else {
            $orderData['extra']['order_accept_language'] = '';
        }
        /* ] */

        $languageRow = Language::getAttributesById($this->siteLangId);
        $orderData['order_language_id'] = $languageRow['language_id'];
        $orderData['order_language_code'] = $languageRow['language_code'];

        $currencyRow = Currency::getAttributesById($this->siteCurrencyId);
        $orderData['order_currency_id'] = $currencyRow['currency_id'];
        $orderData['order_currency_code'] = $currencyRow['currency_code'];
        $orderData['order_currency_value'] = $currencyRow['currency_value'];

        $orderData['order_user_comments'] = '';
        $orderData['order_admin_comments'] = '';

        $orderData['order_shippingapi_id'] = 0;
        $orderData['order_shippingapi_code'] = '';
        $orderData['order_tax_charged'] = 0;
        $orderData['order_site_commission'] = 0;
        $orderData['order_net_amount'] = $order_net_amount;
        $orderData['order_wallet_amount_charge'] = 0;

        $orderData['orderLangData'] = array();
        $orderObj = new Orders();
        if ($orderObj->addUpdateOrder($orderData, $this->siteLangId)) {
            $order_id = $orderObj->getOrderId();
        } else {
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError($orderObj->getError());
            }
            Message::addErrorMessage($orderObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        if (true === MOBILE_APP_API_CALL) {
            /* Payment Methods[ */
            $pmSrch = PaymentMethods::getSearchObject($this->siteLangId);
            $pmSrch->doNotCalculateRecords();
            $pmSrch->doNotLimitRecords();
            $pmSrch->addMultipleFields(Plugin::ATTRS);
            $pmSrch->addCondition('plugin_code', '!=', 'CashOnDelivery');

            $pmRs = $pmSrch->getResultSet();
            $paymentMethods = FatApp::getDb()->fetchAll($pmRs);
            $excludePaymentGatewaysArr = applicationConstants::getExcludePaymentGatewayArr();
            /* ] */
            $this->set('paymentMethods', $paymentMethods);
            $this->set('excludePaymentGatewaysArr', $excludePaymentGatewaysArr);
            $this->set('order_id', $order_id);
            $this->set('orderType', Orders::ORDER_WALLET_RECHARGE);
            $this->_template->render();
        }
        $this->set('redirectUrl', UrlHelper::generateUrl('WalletPay', 'Recharge', array($order_id)));
        $this->set('msg', Labels::getLabel('SUC_REDIRECTING', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function creditSearch()
    {
        $frm = $this->getCreditsSearchForm($this->siteLangId);

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        //$page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);


        $userId = UserAuthentication::getLoggedUserId();
        $debit_credit_type = FatApp::getPostedData('debit_credit_type', FatUtility::VAR_INT, -1);
        $dateOrder = FatApp::getPostedData('date_order', FatUtility::VAR_STRING, "DESC");

        $srch = Transactions::getUserTransactionsObj($userId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->addOrder('utxn.utxn_date', $dateOrder);

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cond = $srch->addCondition('utxn.utxn_order_id', 'like', '%' . $keyword . '%');
            $cond->attachCondition('utxn.utxn_op_id', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('utxn.utxn_comments', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('concat("TN-" ,lpad( utxn.`utxn_id`,7,0))', 'like', '%' . $keyword . '%', 'OR', true);
        }

        $fromDate = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($fromDate)) {
            $cond = $srch->addCondition('utxn.utxn_date', '>=', $fromDate);
        }

        $toDate = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($toDate)) {
            $cond = $srch->addCondition('cast( utxn.`utxn_date` as date)', '<=', $toDate, 'and', true);
        }
        if ($debit_credit_type > 0) {
            switch ($debit_credit_type) {
                case Transactions::CREDIT_TYPE:
                    $srch->addCondition('utxn.utxn_credit', '>', '0');
                    $srch->addCondition('utxn.utxn_debit', '=', '0');
                    break;

                case Transactions::DEBIT_TYPE:
                    $srch->addCondition('utxn.utxn_debit', '>', '0');
                    $srch->addCondition('utxn.utxn_credit', '=', '0');
                    break;
            }
        }
        $records = array();

        $rs = $srch->getResultSet();

        $records = FatApp::getDb()->fetchAll($rs, 'utxn_id');
        $this->set('arrListing', $records);
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('statusArr', Transactions::getStatusArr($this->siteLangId));
        $this->set('statusClassArr', Transactions::getStatusClassArr());
        if (true === MOBILE_APP_API_CALL) {
            $this->creditsInfo();
            $this->_template->render();
        }
        $this->_template->render(false, false);
    }

    public function requestWithdrawal()
    {
        $frm = $this->getWithdrawalForm($this->siteLangId);

        if (User::isAffiliate()) {
            $fld = $frm->getField('ub_ifsc_swift_code');
            $fld->requirements()->setRegularExpressionToValidate(ValidateElement::USERNAME_REGEX);
        }

        $userId = UserAuthentication::getLoggedUserId();
        $balance = User::getUserBalance($userId);
        $lastWithdrawal = User::getUserLastWithdrawalRequest($userId);

        if ($lastWithdrawal && (strtotime($lastWithdrawal["withdrawal_request_date"] . "+" . FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS", FatUtility::VAR_INT, 0) . " days") - time()) > 0) {
            $nextWithdrawalDate = date('d M,Y', strtotime($lastWithdrawal["withdrawal_request_date"] . "+" . FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS", FatUtility::VAR_INT, 0) . " days"));
            Message::addErrorMessage(sprintf(Labels::getLabel('ERR_WITHDRAWAL_REQUEST_DATE', $this->siteLangId), FatDate::format($lastWithdrawal["withdrawal_request_date"]), FatDate::format($nextWithdrawalDate), FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS")));
            FatUtility::dieWithError(Message::getHtml());
        }

        $minimumWithdrawLimit = FatApp::getConfig("CONF_MIN_WITHDRAW_LIMIT", FatUtility::VAR_INT, 0);
        if ($balance < $minimumWithdrawLimit) {
            Message::addErrorMessage(sprintf(Labels::getLabel('ERR_WITHDRAWAL_REQUEST_MINIMUM_BALANCE_LESS', $this->siteLangId), CommonHelper::displayMoneyFormat($minimumWithdrawLimit)));
            FatUtility::dieWithError(Message::getHtml());
        }

        $userObj = new User($userId);
        $data = $userObj->getUserBankInfo();
        $data['uextra_payment_method'] = User::AFFILIATE_PAYMENT_METHOD_CHEQUE;

        if (User::isAffiliate()) {
            $userExtraData = User::getUserExtraData($userId, array('uextra_payment_method', 'uextra_cheque_payee_name', 'uextra_paypal_email_id'));
            $uextra_payment_method = isset($userExtraData['uextra_payment_method']) ? $userExtraData['uextra_payment_method'] : User::AFFILIATE_PAYMENT_METHOD_CHEQUE;
            $data = array_merge($data, $userExtraData);
            $data['uextra_payment_method'] = $uextra_payment_method;
            $this->set('uextra_payment_method', $uextra_payment_method);
        }

        $frm->fill($data);

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setupRequestWithdrawal()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $balance = User::getUserBalance($userId);
        $lastWithdrawal = User::getUserLastWithdrawalRequest($userId);

        if ($lastWithdrawal && (strtotime($lastWithdrawal["withdrawal_request_date"] . "+" . FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS", FatUtility::VAR_INT, 0) . " days") - time()) > 0) {
            $nextWithdrawalDate = date('d M,Y', strtotime($lastWithdrawal["withdrawal_request_date"] . "+" . FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS") . " days"));

            $message = sprintf(Labels::getLabel('ERR_WITHDRAWAL_REQUEST_DATE', $this->siteLangId), FatDate::format($lastWithdrawal["withdrawal_request_date"]), FatDate::format($nextWithdrawalDate), FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS"));
            FatUtility::dieJsonError($message);
        }

        $minimumWithdrawLimit = FatApp::getConfig("CONF_MIN_WITHDRAW_LIMIT", FatUtility::VAR_INT, 0);
        if ($balance < $minimumWithdrawLimit) {
            $message = sprintf(Labels::getLabel('ERR_WITHDRAWAL_REQUEST_MINIMUM_BALANCE_LESS', $this->siteLangId), CommonHelper::displayMoneyFormat($minimumWithdrawLimit));
            FatUtility::dieJsonError($message);
        }

        $frm = $this->getWithdrawalForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }

        if (($minimumWithdrawLimit > $post["withdrawal_amount"])) {
            $message = sprintf(Labels::getLabel('ERR_YOUR_WITHDRAWAL_REQUEST_AMOUNT_IS_LESS_THAN_THE_MINIMUM_ALLOWED_AMOUNT_OF_%S', $this->siteLangId), CommonHelper::displayMoneyFormat($minimumWithdrawLimit));
            FatUtility::dieJsonError($message);
        }

        $maximumWithdrawLimit = FatApp::getConfig("CONF_MAX_WITHDRAW_LIMIT", FatUtility::VAR_INT, 0);
        if (($maximumWithdrawLimit < $post["withdrawal_amount"])) {
            $message = sprintf(Labels::getLabel('ERR_YOUR_WITHDRAWAL_REQUEST_AMOUNT_IS_GREATER_THAN_THE_MAXIMUM_ALLOWED_AMOUNT_OF_%S', $this->siteLangId), CommonHelper::displayMoneyFormat($maximumWithdrawLimit));
            FatUtility::dieJsonError($message);
        }

        if (($post["withdrawal_amount"] > $balance)) {
            $message = Labels::getLabel('ERR_WITHDRAWAL_REQUEST_GREATER', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $accountNumber = FatApp::getPostedData('ub_account_number', FatUtility::VAR_STRING, 0);

        if ((string) $accountNumber != $post['ub_account_number']) {
            $message = Labels::getLabel('ERR_INVALID_ACCOUNT_NUMBER', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }


        $userObj = new User($userId);
        if (!$userObj->updateBankInfo($post)) {
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $withdrawal_payment_method = FatApp::getPostedData('uextra_payment_method', FatUtility::VAR_INT, 0);

        $withdrawal_payment_method = ($withdrawal_payment_method > 0 && array_key_exists($withdrawal_payment_method, User::getAffiliatePaymentMethodArr($this->siteLangId))) ? $withdrawal_payment_method : User::AFFILIATE_PAYMENT_METHOD_BANK;
        $withdrawal_cheque_payee_name = '';
        $withdrawal_paypal_email_id = '';
        $withdrawal_bank = '';
        $withdrawal_account_holder_name = '';
        $withdrawal_account_number = '';
        $withdrawal_ifc_swift_code = '';
        $withdrawal_bank_address = '';
        $withdrawal_instructions = $post['withdrawal_instructions'];

        switch ($withdrawal_payment_method) {
            case User::AFFILIATE_PAYMENT_METHOD_CHEQUE:
                $withdrawal_cheque_payee_name = $post['uextra_cheque_payee_name'];
                break;
            case User::AFFILIATE_PAYMENT_METHOD_BANK:
                $withdrawal_bank = $post['ub_bank_name'];
                $withdrawal_account_holder_name = $post['ub_account_holder_name'];
                $withdrawal_account_number = $post['ub_account_number'];
                $withdrawal_ifc_swift_code = $post['ub_ifsc_swift_code'];
                $withdrawal_bank_address = $post['ub_bank_address'];
                break;
            case User::AFFILIATE_PAYMENT_METHOD_PAYPAL:
                $withdrawal_paypal_email_id = $post['uextra_paypal_email_id'];
                break;
        }


        $post['withdrawal_payment_method'] = $withdrawal_payment_method;
        $post['withdrawal_cheque_payee_name'] = $withdrawal_cheque_payee_name;
        $post['withdrawal_paypal_email_id'] = $withdrawal_paypal_email_id;

        $post['ub_bank_name'] = $withdrawal_bank;
        $post['ub_account_holder_name'] = $withdrawal_account_holder_name;
        $post['ub_account_number'] = $withdrawal_account_number;
        $post['ub_ifsc_swift_code'] = $withdrawal_ifc_swift_code;
        $post['ub_bank_address'] = $withdrawal_bank_address;

        $post['withdrawal_instructions'] = $withdrawal_instructions;

        if (!$withdrawRequestId = $userObj->addWithdrawalRequest(array_merge($post, array("ub_user_id" => $userId)), $this->siteLangId)) {
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

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
            $message = Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $this->set('msg', Labels::getLabel('SUC_WITHDRAW_REQUEST_PLACED_SUCCESSFULLY', $this->siteLangId));

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeProfileImage()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $userId = FatUtility::int($userId);
        if (1 > $userId) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage();
            FatUtility::dieJsonError(Message::getHtml());
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $userId)) {
            $message = Labels::getLabel($fileHandlerObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_USER_PROFILE_CROPED_IMAGE, $userId)) {
            $message = Labels::getLabel($fileHandlerObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $this->set('msg', Labels::getLabel('SUC_PROFILE_IMAGE_REMOVED_SUCCESSFULLY', $this->siteLangId));
        if (true ===  MOBILE_APP_API_CALL) {
            $userImgUpdatedOn = User::getAttributesById($userId, 'user_updated_on');
            $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);
            $userImage = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'user', array($userId, ImageDimension::VIEW_THUMB, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

            $data = array('userImage' => $userImage);

            $this->set('data', $data);
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function userProfileImage($userId, $sizeType = '', $cropedImage = false)
    {
        $default_image = 'user_deafult_image.jpg';
        $userId = UserAuthentication::getLoggedUserId();
        $recordId = FatUtility::int($userId);

        $file_row = false;
        if ($cropedImage == true) {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_USER_PROFILE_CROPED_IMAGE, $recordId);
        }

        if ($file_row == false) {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $recordId);
        }

        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';

        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);

        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_USER_PROFILE_IMAGE, $sizeType);

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }

    public function profileInfo()
    {
        if (true === MOBILE_APP_API_CALL) {
            $userId = UserAuthentication::getLoggedUserId(true);
            $userImgUpdatedOn = User::getAttributesById($userId, 'user_updated_on');
            $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);

            $hasDigitalProducts = 0;

            $srch = Product::getSearchObject();
            $srch->addMultipleFields(['product_id']);
            $srch->addCondition('product_type', '=', Product::PRODUCT_TYPE_DIGITAL);
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $row = $this->db->fetch($rs);
            if (!empty($row) && 0 < count($row)) {
                $hasDigitalProducts = 1;
            }
            $splitPaymentMethods = Plugin::getDataByType(Plugin::TYPE_SPLIT_PAYMENT_METHOD, $this->siteLangId);
            $bankInfo = $this->bankInfo();
            $personalInfo = $this->personalInfo();
            $personalInfo['userImage'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'user', array($userId, ImageDimension::VIEW_SMALL, true)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $this->set('personalInfo', empty($personalInfo) ? (object) array() : $personalInfo);
            $this->set('bankInfo', empty($bankInfo) ? (object) array() : $bankInfo);
            $this->set('privacyPolicyLink', FatApp::getConfig('CONF_PRIVACY_POLICY_PAGE', FatUtility::VAR_STRING, ''));
            $this->set('hasDigitalProducts', $hasDigitalProducts);
            $this->set('splitPaymentMethods', $splitPaymentMethods);
            $this->_template->render();
        }

        $this->_template->addJs('js/jquery.form.js');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->includeDateTimeFiles();

        $userId = UserAuthentication::getLoggedUserId();

        $data = User::getAttributesById($userId, array('user_preferred_dashboard', 'user_registered_initially_for', 'user_parent'));
        if ($data === false) {
            FatUtility::dieWithError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $showSellerActivateButton = false;
        if (!User::canAccessSupplierDashboard() && $data['user_registered_initially_for'] == User::USER_TYPE_SELLER) {
            $showSellerActivateButton = true;
        }

        $payoutPlugins = Plugin::getNamesWithCode(Plugin::TYPE_PAYOUTS, $this->siteLangId);

        $this->set('userParentId', $data['user_parent']);
        $this->set('payouts', $payoutPlugins);
        $this->set('showSellerActivateButton', $showSellerActivateButton);
        $this->set('userPreferredDashboard', $data['user_preferred_dashboard']);
        $this->_template->render();
    }

    public function personalInfo()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $userObj = new User($userId);
        $srch = $userObj->getUserSearchObj();
        $srch->addMultipleFields(array('u.*', 'country_name', 'state_name'));
        $srch->joinTable('tbl_countries_lang', 'LEFT JOIN', 'countrylang_country_id = user_country_id and countrylang_lang_id = ' . $this->siteLangId);
        $srch->joinTable('tbl_states_lang', 'LEFT JOIN', 'statelang_state_id = user_state_id and statelang_lang_id = ' . $this->siteLangId);
        $rs = $srch->getResultSet();
        $data = FatApp::getDb()->fetch($rs, 'user_id');
        if (true === MOBILE_APP_API_CALL) {
            return $data;
        }
        $this->set('info', $data);
        $this->_template->render(false, false);
    }

    public function bankInfo()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $userObj = new User($userId);
        $data = $userObj->getUserBankInfo();
        if (true === MOBILE_APP_API_CALL) {
            return $data;
        }
        $this->set('info', $data);
        $this->_template->render(false, false);
    }

    public function profileInfoForm()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $frm = $this->getProfileInfoForm();
        $imgFrm = $this->getProfileImageForm();
        $stateId = 0;

        $userObj = new User($userId);
        $srch = $userObj->getUserSearchObj();
        $srch->addMultipleFields(array('u.*'));
        $rs = $srch->getResultSet();
        $data = FatApp::getDb()->fetch($rs, 'user_id');

        if (User::isAffiliate()) {
            $userExtraData = User::getUserExtraData($userId, array('uextra_company_name', 'uextra_website'));
            $userExtraData = ($userExtraData) ? $userExtraData : array();
            $data = array_merge($userExtraData, $data);
        }

        if ($data['user_dob'] == "0000-00-00") {
            $dobFld = $frm->getField('user_dob');
            $dobFld->requirements()->setRequired(true);
        }

        $frm->fill($data);
        $stateId = $data['user_state_id'];

        $mode = 'Add';
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $userId);
        if ($file_row != false) {
            $mode = 'Edit';
        }

        $countryIso = Countries::getCountryById($data['user_country_id'], $this->siteLangId, 'country_code');
        $this->set('countryIso', $countryIso);
        $this->set('data', $data);
        $this->set('frm', $frm);
        $this->set('imgFrm', $imgFrm);
        $this->set('mode', $mode);
        $this->set('stateId', $stateId);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function imgCropper()
    {
        $userId = UserAuthentication::getLoggedUserId(true);
        $userImgUpdatedOn = User::getAttributesById($userId, 'user_updated_on');
        $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);
        $fileRow = AttachedFile::getAttachment(AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $userId);
        $userImage = "";
        if (0 < $fileRow['afile_id']) {
            $userImage = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'user', array($userId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        }

        $this->set('image', $userImage);
        $this->_template->render(false, false, 'cropper/index.php');
    }

    public function profileImageForm()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $imgFrm = $this->getProfileImageForm();
        $mode = 'Add';
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $userId);
        if ($file_row != false) {
            $mode = 'Edit';
        }
        $this->set('mode', $mode);
        $this->set('imgFrm', $imgFrm);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function uploadProfileImage()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST_OR_FILE_NOT_SUPPORTED', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }
        $updatedAt = date('Y-m-d H:i:s');
        $uploadedTime = AttachedFile::setTimeParam($updatedAt);

        if (isset($_FILES['org_image']['tmp_name'])) {
            $fileHandlerObj = new AttachedFile();
            if (!$fileHandlerObj->isUploadedFile($_FILES['org_image']['tmp_name'])) {
                FatUtility::dieJsonError($fileHandlerObj->getError());
            }

            if (!$res = $fileHandlerObj->saveImage($_FILES['org_image']['tmp_name'], AttachedFile::FILETYPE_USER_PROFILE_IMAGE, $userId, 0, $_FILES['org_image']['name'], -1, true)) {
                $message = Labels::getLabel($fileHandlerObj->getError(), $this->siteLangId);
                FatUtility::dieJsonError($message);
            }
        }

        if (isset($_FILES['cropped_image']['tmp_name'])) {
            $fileHandlerObj = new AttachedFile();
            if (!$fileHandlerObj->isUploadedFile($_FILES['cropped_image']['tmp_name'])) {
                FatUtility::dieJsonError($fileHandlerObj->getError());
            }

            if (!$res = $fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], AttachedFile::FILETYPE_USER_PROFILE_CROPED_IMAGE, $userId, 0, $_FILES['cropped_image']['name'], -1, true)) {
                $message = Labels::getLabel($fileHandlerObj->getError(), $this->siteLangId);
                FatUtility::dieJsonError($message);
            }
        }

        if (false === MOBILE_APP_API_CALL) {
            $profileImg = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Account', 'userProfileImage', array($userId, ImageDimension::VIEW_CROPED, 1)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $this->set('file', $profileImg);
        } else {
            $profileImg = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'user', array($userId, ImageDimension::VIEW_MINI, 1)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $this->set('file', $profileImg);
        }
        $this->set('file', $profileImg);

        User::setImageUpdatedOn($userId, $updatedAt);
        $this->set('msg', Labels::getLabel('SUC_FILE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateProfileInfo()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $frm = $this->getProfileInfoForm();

        $post = FatApp::getPostedData();

        if (1 > count($post) && true === MOBILE_APP_API_CALL) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        /* CommonHelper::printArray($post);  */
        $user_state_id = FatApp::getPostedData('user_state_id', FatUtility::VAR_INT, 0);
        $post = $frm->getFormDataFromArray($post);

        if (false === $post) {
            $message = Labels::getLabel(current($frm->getValidationErrors()), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if (strtotime($post['user_dob']) > time()) {
            $message = Labels::getLabel("ERR_INVALID_DATE_OF_BIRTH", $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $post['user_state_id'] = $user_state_id;

        if (isset($post['user_id'])) {
            unset($post['user_id']);
        }


        $post['user_phone_dcode'] = FatApp::getPostedData('user_phone_dcode', FatUtility::VAR_STRING, '');

        if (isset($post['user_phone']) && true == SmsArchive::canSendSms()) {
            unset($post['user_phone'], $post['user_phone_dcode']);
        }

        if ($post['user_dob'] == "0000-00-00" || $post['user_dob'] == "" || strtotime($post['user_dob']) == 0) {
            unset($post['user_dob']);
        }

        unset($post['credential_username'], $post['credential_email']);

        /* saving user extras[ */
        if (User::isAffiliate()) {
            $dataToSave = array(
                'uextra_user_id' => $userId,
                'uextra_company_name' => $post['uextra_company_name'],
                'uextra_website' => CommonHelper::processUrlString($post['uextra_website'])
            );
            $dataToUpdateOnDuplicate = $dataToSave;
            unset($dataToUpdateOnDuplicate['uextra_user_id']);
            if (!FatApp::getDb()->insertFromArray(User::DB_TBL_USR_EXTRAS, $dataToSave, false, array(), $dataToUpdateOnDuplicate)) {
                $message = Labels::getLabel("ERR_DETAILS_COULD_NOT_BE_SAVED!", $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }

                Message::addErrorMessage($message);
                if (FatUtility::isAjaxCall()) {
                    FatUtility::dieWithError(Message::getHtml());
                }
                FatApp::redirectUser(UrlHelper::generateUrl('Account', 'ProfileInfo'));
            }
        }
        /* ] */

        $userObj = new User($userId);
        $userObj->assignValues($post);
        if (!$userObj->save()) {
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $postUserName = isset($post['user_name']) ? $post['user_name'] : '';
        $sessionUserName = isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_name']) ? $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_name'] : '';
        if (!empty($postUserName) && !empty($sessionUserName) && $postUserName != $sessionUserName) {
            $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['user_name'] = $postUserName;
        }

        $this->set('msg', Labels::getLabel('SUC_UPDATED_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function bankInfoForm()
    {
        $userId = UserAuthentication::getLoggedUserId();

        if (User::isAffiliate()) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $userObj = new User($userId);
        $data = $userObj->getUserBankInfo();

        if (true === MOBILE_APP_API_CALL) {
            $this->set('data', ['bankInfo' => (object) $data]);
            $this->_template->render();
        }

        $frm = $this->getBankInfoForm();
        if ($data != false) {
            $frm->fill($data);
        }

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function settingsInfo()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $frm = $this->getSettingsForm();

        $userObj = new User($userId);
        $srch = $userObj->getUserSearchObj();
        $srch->addMultipleFields(array('u.*'));
        $rs = $srch->getResultSet();
        $data = FatApp::getDb()->fetch($rs, 'user_id');
        if ($data != false) {
            $frm->fill($data);
        }

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function updateBankInfo()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $post = FatApp::getPostedData();
        if (1 > count($post) && true === MOBILE_APP_API_CALL) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        $frm = $this->getBankInfoForm();
        $post = $frm->getFormDataFromArray($post);

        if (false === $post) {
            $message = Labels::getLabel(current($frm->getValidationErrors()), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }
        $accountNumber = FatApp::getPostedData('ub_account_number', FatUtility::VAR_STRING, 0);

        if ((string) $accountNumber != $post['ub_account_number']) {
            $message = Labels::getLabel('ERR_INVALID_ACCOUNT_NUMBER', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }


        $userObj = new User($userId);
        if (!$userObj->updateBankInfo($post)) {
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $this->set('msg', Labels::getLabel('SUC_UPDATED_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateSettingsInfo()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $frm = $this->getSettingsForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $userObj = new User($userId);
        if (!$userObj->updateSettingsInfo($post)) {
            Message::addErrorMessage(Labels::getLabel($userObj->getError(), $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('SUC_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changeEmailForm()
    {
        $frm = $this->getChangeEmailForm();

        $this->set('frm', $frm);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function updateEmail()
    {
        $emailFrm = $this->getChangeEmailForm();
        $post = $emailFrm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            $message = $emailFrm->getValidationErrors();
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError(current($message));
            }
            Message::addErrorMessage($message);
            FatUtility::dieJsonError(Message::getHtml());
        }

        if ($post['new_email'] != $post['conf_new_email']) {
            $message = Labels::getLabel('ERR_NEW_EMAIL_CONFIRM_EMAIL_DOES_NOT_MATCH', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $userObj = new User(UserAuthentication::getLoggedUserId());
        $srch = $userObj->getUserSearchObj(array('user_id', 'credential_password', 'credential_email', 'user_name', 'user_phone_dcode', 'user_phone'));
        $rs = $srch->getResultSet();

        if (!$rs) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $data = FatApp::getDb()->fetch($rs, 'user_id');

        if ($data === false) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if ($data['credential_password'] != UserAuthentication::encryptPassword($post['current_password'])) {
            $message = Labels::getLabel('ERR_YOUR_CURRENT_PASSWORD_MIS_MATCHED', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $phone = array_key_exists('user_phone', $data) ? $data['user_phone'] : '';
        $dialCode = array_key_exists('user_phone_dcode', $data) ? ValidateElement::formatDialCode($data['user_phone_dcode']) : '';
        $arr = array(
            'user_name' => $data['user_name'],
            'user_phone_dcode' => $dialCode,
            'user_phone' => $phone,
            'user_email' => $data['credential_email'],
            'user_new_email' => $post['new_email']
        );

        if (!$this->userEmailVerifications($userObj, $arr)) {
            $message = Labels::getLabel('ERR_ERROR_IN_SENDING_VERFICATION_EMAIL', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }


        $this->set('msg', Labels::getLabel('SUC_CHANGE_EMAIL_REQUEST_SENT_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function moveToWishList($selProdId)
    {
        $wishList = new UserWishList();
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $defaultWishListId = $wishList->getWishListId($loggedUserId, UserWishList::TYPE_DEFAULT_WISHLIST);
        $this->addRemoveWishListProduct($selProdId, $defaultWishListId);
    }

    public function moveToSaveForLater($selProdId)
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $wishList = new UserWishList();
        $wishListId = $wishList->getWishListId($loggedUserId, UserWishList::TYPE_SAVE_FOR_LATER);
        if (!$wishList->addUpdateListProducts($wishListId, $selProdId)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        $cartObj = new Cart($loggedUserId, $this->siteLangId, $this->app_user['temp_user_id']);
        $key = md5(base64_encode(json_encode(Cart::CART_KEY_PREFIX_PRODUCT . $selProdId)));
        if (!$cartObj->remove($key)) {
            LibHelper::dieJsonError($cartObj->getError());
        }

        if (true === MOBILE_APP_API_CALL) {
            $fulfilmentType = FatApp::getPostedData('fulfilmentType', FatUtility::VAR_INT, Shipping::FULFILMENT_SHIP);
            $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
            $cartObj->setFulfilmentType($fulfilmentType);
            $cartObj->setCartCheckoutType($fulfilmentType);
            $productsArr = $cartObj->getProducts($this->siteLangId);
            $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
            $this->set('products', $productsArr);
            $this->set('cartSummary', $cartSummary);
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    /* called from products listing page */
    public function viewWishList($selprod_id, $excludeWishList = 0)
    {
        $excludeWishList = FatUtility::int($excludeWishList);
        $loggedUserId = UserAuthentication::getLoggedUserId();

        $wishLists = UserWishList::getUserWishLists($loggedUserId, true, $excludeWishList);
        $frm = $this->getCreateWishListForm();
        $frm->fill(array('selprod_id' => $selprod_id));
        $this->set('frm', $frm);
        $this->set('wishLists', $wishLists);
        $this->set('selprod_id', $selprod_id);
        $this->_template->render(false, false);
    }

    public function setupWishList()
    {
        $frm = $this->getCreateWishListForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $selprod_id = FatUtility::int($post['selprod_id']);
        if (false === $post) {
            $message = current($frm->getValidationErrors());
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $wListObj = new UserWishList();
        $data_to_save_arr = $post;
        $data_to_save_arr['uwlist_added_on'] = date('Y-m-d H:i:s');
        $data_to_save_arr['uwlist_user_id'] = UserAuthentication::getLoggedUserId();
        $wListObj->assignValues($data_to_save_arr);

        /* create new List[ */
        if (!$wListObj->save()) {
            $message = $wListObj->getError();
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        $uwlp_uwlist_id = $wListObj->getMainTableRecordId();
        /* ] */

        $successMsg = Labels::getLabel('SUC_WISHLIST_CREATED_SUCCESSFULLY', $this->siteLangId);
        /* Assign current product to newly created list[ */
        if ($uwlp_uwlist_id && $selprod_id) {
            if (!$wListObj->addUpdateListProducts($uwlp_uwlist_id, $selprod_id)) {
                Message::addMessage($successMsg);
                $msg = Labels::getLabel('ERR_ERROR_WHILE_ASSIGNING_PRODUCT_UNDER_SELECTED_LIST.', $this->siteLangId);

                if (true === MOBILE_APP_API_CALL) {
                    LibHelper::dieJsonError($msg);
                }
                Message::addErrorMessage($msg);
                FatUtility::dieWithError(Message::getHtml());
            }
        }
        /* ] */

        //UserWishList
        $srch = UserWishList::getSearchObject($loggedUserId);
        $srch->joinTable(UserWishList::DB_TBL_LIST_PRODUCTS, 'LEFT OUTER JOIN', 'uwlist_id = uwlp_uwlist_id');
        $srch->addCondition('uwlp_selprod_id', '=', $selprod_id);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('uwlist_id'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        $productIsInAnyList = false;
        if ($row) {
            $productIsInAnyList = true;
        }

        $this->set('productIsInAnyList', $productIsInAnyList);
        $this->set('wish_list_id', $uwlp_uwlist_id);
        $this->set('msg', $successMsg);
        if (true === MOBILE_APP_API_CALL) {
            $this->set('data', ['wish_list_id' => $uwlp_uwlist_id]);
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function addRemoveWishListProductArr()
    {
        $selprod_id_arr = FatApp::getPostedData('selprod_id');
        $selprod_id_arr = !empty($selprod_id_arr) ? array_filter($selprod_id_arr) : array();

        $uwlist_id = FatApp::getPostedData('uwlist_id', FatUtility::VAR_INT, 0);

        if (empty($selprod_id_arr) || empty($uwlist_id)) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        foreach ($selprod_id_arr as $selprod_id) {
            $action = $this->updateWishList($selprod_id, $uwlist_id);
        }

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateRemoveWishListProduct($selprodId, $wishListId)
    {
        $selprodIdArr = FatApp::getPostedData('selprod_id');
        $oldWishlistId = FatApp::getPostedData('uwlist_id', FatUtility::VAR_INT, 0);

        if (empty($selprodIdArr) || empty($oldWishlistId)) {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        foreach ($selprodIdArr as $selprodId) {
            $this->updateWishList($selprodId, $oldWishlistId);
            $isExists = UserWishList::getListProductsByListId($wishListId, $selprodId);
            if (empty($isExists)) {
                $this->updateWishList($selprodId, $wishListId);
            }
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function addRemoveWishListProduct($selprod_id, $wish_list_id, $rowAction = '', $removeFromCart = 0)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $wish_list_id = FatUtility::int($wish_list_id);
        $rowAction = ('' == $rowAction ? -1 : $rowAction);

        $loggedUserId = UserAuthentication::getLoggedUserId();

        if (1 > $wish_list_id) {
            $wishList = new UserWishList();
            $wish_list_id = $wishList->getWishListId($loggedUserId, UserWishList::TYPE_DEFAULT_WISHLIST);
        }

        if (1 > $selprod_id) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $action = $this->updateWishList($selprod_id, $wish_list_id, $rowAction);

        //UserWishList
        $srch = UserWishList::getSearchObject($loggedUserId);
        $srch->joinTable(UserWishList::DB_TBL_LIST_PRODUCTS, 'LEFT OUTER JOIN', 'uwlist_id = uwlp_uwlist_id');
        $srch->addCondition('uwlp_selprod_id', '=', $selprod_id);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('uwlist_id'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        $productIsInAnyList = false;
        if ($row) {
            $productIsInAnyList = true;
        }

        if (0 < $removeFromCart) {
            $cartObj = new Cart($loggedUserId, $this->siteLangId, $this->app_user['temp_user_id']);
            $key = md5(base64_encode(json_encode(Cart::CART_KEY_PREFIX_PRODUCT . $selprod_id)));
            if (!$cartObj->remove($key)) {
                LibHelper::dieJsonError($cartObj->getError());
            }

            if (true === MOBILE_APP_API_CALL) {
                $fulfilmentType = FatApp::getPostedData('fulfilmentType', FatUtility::VAR_INT, Shipping::FULFILMENT_SHIP);
                $cartObj = new Cart(UserAuthentication::getLoggedUserId(true), $this->siteLangId, $this->app_user['temp_user_id'], Cart::PAGE_TYPE_CART);
                $cartObj->setFulfilmentType($fulfilmentType);
                $cartObj->setCartCheckoutType($fulfilmentType);
                $productsArr = $cartObj->getProducts($this->siteLangId);
                $cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
                $this->set('products', $productsArr);
                $this->set('cartSummary', $cartSummary);
            }
        }

        $this->set('productIsInAnyList', $productIsInAnyList);
        $this->set('action', $action);
        $this->set('wish_list_id', $wish_list_id);
        $this->set('totalWishListItems', Common::countWishList());

        $this->updateFavConfTime();

        if (true === MOBILE_APP_API_CALL) {
            $this->set('removeFromCart', $removeFromCart);
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateWishList($selprod_id, $wish_list_id, $rowAction = -1)
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();

        $row = false;

        $db = FatApp::getDb();
        $wListObj = new UserWishList();
        if (0 > $rowAction) {
            $srch = UserWishList::getSearchObject($loggedUserId);
            $wListObj->joinWishListProducts($srch);
            $srch->addMultipleFields(array('uwlist_id'));
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addCondition('uwlp_selprod_id', '=', $selprod_id);
            // $srch->addCondition('uwlp_uwlist_id', '=', $wish_list_id);

            $rs = $srch->getResultSet();
            $row = $db->fetchAll($rs);
            if (is_array($row)) {
                foreach ($row as $key => $wishlistRow) {
                    /* In case user wants to remove from wishlist. */
                    if ($wishlistRow['uwlist_id'] == $wish_list_id) {
                        continue;
                    }

                    /* In case user wants to add item in wishlist but remove from others as one item can be added in one wishlist only. */
                    if (!$db->deleteRecords(UserWishList::DB_TBL_LIST_PRODUCTS, array('smt' => 'uwlp_uwlist_id = ? AND uwlp_selprod_id = ?', 'vals' => array($wishlistRow['uwlist_id'], $selprod_id)))) {
                        continue;
                    }
                    unset($row[$key]);
                }
                $row = empty($row) ? false : $row;
            }
        }

        $action = 'N'; //nothing happened
        if (!$row && (0 < $rowAction || 0 > $rowAction)) {
            if (!$wListObj->addUpdateListProducts($wish_list_id, $selprod_id)) {
                $message = Labels::getLabel('ERR_SOME_PROBLEM_OCCURRED,_PLEASE_CONTACT_WEBMASTER', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                Message::addErrorMessage($message);
                FatUtility::dieWithError(Message::getHtml());
            }
            $action = 'A'; //Added to wishlist
            $this->set('msg', Labels::getLabel('SUC_PRODUCT_ADDED_IN_LIST_SUCCESSFULLY', $this->siteLangId));
        } else {
            $uwlistIds = array();
            if (true === MOBILE_APP_API_CALL) {
                $srch = UserWishList::getSearchObject($loggedUserId);
                $srch->addMultipleFields(array('uwlist_id'));
                $rs = $srch->getResultSet();
                $row = $db->fetchAll($rs, 'uwlist_id');
                $uwlistIds = array_keys($row);
            } else {
                $uwlistIds[] = $wish_list_id;
            }
            $err = true;
            foreach ($uwlistIds as $uwlistId) {
                $err = false;
                if (!$db->deleteRecords(UserWishList::DB_TBL_LIST_PRODUCTS, array('smt' => 'uwlp_uwlist_id = ? AND uwlp_selprod_id = ?', 'vals' => array($uwlistId, $selprod_id)))) {
                    $err = true;
                    break;
                }
            }

            if (true == $err) {
                $message = Labels::getLabel('ERR_SOME_PROBLEM_OCCURRED,_PLEASE_CONTACT_WEBMASTER', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                Message::addErrorMessage($message);
                FatUtility::dieWithError(Message::getHtml());
            }

            $action = 'R'; //Removed from wishlist
            $this->set('msg', Labels::getLabel('SUC_PRODUCT_REMOVED_FROM_LIST_SUCCESSFULLY', $this->siteLangId));
        }
        return $action;
    }

    public function wishlist()
    {
        $this->_template->addJs('js/slick.js');
        $this->_template->render();
    }

    public function wishListSearch()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();

        if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
            $wishLists[] = Product::getUserFavouriteProducts($loggedUserId, $this->siteLangId);
        } else {
            $wishLists = UserWishList::getUserWishLists($loggedUserId, false);
            if ($wishLists) {
                $srchObj = new UserWishListProductSearch($this->siteLangId);
                $db = FatApp::getDb();
                foreach ($wishLists as &$wishlist) {
                    $srch = clone $srchObj;
                    $srch->joinSellerProducts();
                    $srch->joinProducts();
                    $srch->joinBrands();
                    $srch->joinSellers();
                    $srch->joinShops();
                    $srch->joinProductToCategory();
                    $srch->joinSellerSubscription($this->siteLangId, true);
                    $srch->addSubscriptionValidCondition();
                    $srch->joinSellerProductSpecialPrice();
                    $srch->joinFavouriteProducts($loggedUserId);
                    $srch->addCondition('uwlp_uwlist_id', '=', $wishlist['uwlist_id']);
                    $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
                    $srch->addCondition('selprod_active', '=', applicationConstants::YES);
                    $srch->setPageNumber(1);
                    $srch->setPageSize(4);
                    $srch->addMultipleFields(array('selprod_id', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'product_id', 'IFNULL(product_name, product_identifier) as product_name', 'IF(selprod_stock > 0, 1, 0) AS in_stock'));
                    $srch->addOrder('uwlp_added_on');
                    $srch->addGroupBy('selprod_id');
                    $rs = $srch->getResultSet();
                    $products = $db->fetchAll($rs);
                    $wishlist['products'] = $products;
                    $wishlist['totalProducts'] = $srch->recordCount();
                }
            }
        }
        /* $wishLists = array_merge($favouriteProducts,$wishLists); */

        $this->set('wishLists', $wishLists);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $frm = $this->getCreateWishListForm();
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function viewFavouriteItems()
    {
        $db = FatApp::getDb();
        $loggedUserId = UserAuthentication::getLoggedUserId();

        $favouriteListRow = Product::getUserFavouriteProducts($loggedUserId, $this->siteLangId);

        if (!$favouriteListRow) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $this->set('wishListRow', $favouriteListRow);
        $this->_template->render(false, false, 'account/favourite-list-items.php');
        // $this->_template->render(false, false, 'account/wish-list-items.php');
    }

    public function searchWishListItems()
    {
        $post = FatApp::getPostedData();
        $db = FatApp::getDb();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $uwlist_id = empty($post['uwlist_id']) ? 0 : FatUtility::int($post['uwlist_id']);
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }

        if (false === MOBILE_APP_API_CALL) {
            $wishListRow = UserWishList::getAttributesById($uwlist_id, array('uwlist_id'));
            if (!$wishListRow) {
                $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                Message::addErrorMessage($message);
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $srch = new UserWishListProductSearch($this->siteLangId);
        $srch->joinSellerProducts();
        $srch->joinProducts();
        $srch->joinBrands();
        $srch->joinSellers();
        $srch->setGeoAddress();
        $srch->joinShops();
        $srch->validateAndJoinDeliveryLocation();
        $srch->joinProductToCategory();
        $srch->joinSellerSubscription($this->siteLangId, true);
        $srch->addSubscriptionValidCondition();
        $srch->joinSellerProductSpecialPrice();
        $srch->joinFavouriteProducts($loggedUserId);
        if (true === MOBILE_APP_API_CALL && 0 >= $uwlist_id) {
            $srch->joinWishLists();
            $srch->addCondition('uwlist_user_id', '=', $loggedUserId);
        } else {
            $srch->addCondition('uwlp_uwlist_id', '=', $uwlist_id);
        }
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_active', '=', applicationConstants::YES);
        $selProdReviewObj = new SelProdReviewSearch();
        $selProdReviewObj->joinSellerProducts();
        $selProdReviewObj->joinSelProdRating();
        $selProdReviewObj->addCondition('sprating_rating_type', '=', SelProdRating::TYPE_PRODUCT);
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->doNotLimitRecords();
        $selProdReviewObj->addGroupBy('spr.spreview_product_id');
        $selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id', "ROUND(AVG(sprating_rating),2) as prod_rating"));
        $selProdRviewSubQuery = $selProdReviewObj->getQuery();
        $srch->joinTable('(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_selprod_id = selprod_id', 'sq_sprating');

        /* $favProductObj = new UserWishListProductSearch();
        $favProductObj->joinFavouriteProducts(); */


        // echo $srch->getQuery(); die;

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        /* groupby added, beacouse if same product is linked with multiple categories, then showing in repeat for each category[ */
        $srch->addGroupBy('selprod_id');
        /* ] */

        $srch->addMultipleFields(
            array(
                'selprod_id', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
                'product_id', 'prodcat_id', 'ufp_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'product_updated_on',
                'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand.brand_id', 'product_model',
                'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(splprice_price, selprod_price) AS theprice', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
                'CASE WHEN splprice_selprod_id IS NULL THEN 0 ELSE 1 END AS special_price_found', 'selprod_price', 'selprod_user_id', 'selprod_code', 'selprod_sold_count', 'selprod_condition', 'IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist', 'IFNULL(uwlp.uwlp_uwlist_id, 0) as uwlp_uwlist_id', 'ifnull(prod_rating,0) prod_rating', 'selprod_min_order_qty', 'selprod_available_from', 'selprod_stock'
            )
        );


        $srch->addOrder('uwlp_added_on', 'DESC');
        $rs = $srch->getResultSet();
        /* echo $srch->getQuery(); die; */
        $products = $db->fetchAll($rs);
        if (count($products)) {
            foreach ($products as &$arr) {
                $arr['options'] = SellerProduct::getSellerProductOptions($arr['selprod_id'], true, $this->siteLangId);
            }
        }
        /* $prodSrchObj = new ProductSearch();
        if( $products ){
        foreach($products as &$product){
        $moreSellerSrch = clone $prodSrchObj;
        $moreSellerSrch->addMoreSellerCriteria( $product['selprod_code'], $product['selprod_user_id'] );
        $moreSellerSrch->addMultipleFields(array('count(selprod_id) as totalSellersCount','MIN(theprice) as theprice'));
        $moreSellerSrch->addGroupBy('selprod_code');
        $moreSellerRs = $moreSellerSrch->getResultSet();
        $moreSellerRow = $db->fetch($moreSellerRs);
        $product['moreSellerData'] =  ($moreSellerRow) ? $moreSellerRow : array();
        }
        }
        */
        $this->set('products', $products);
        $this->set('showProductShortDescription', false);
        $this->set('showProductReturnPolicy', false);
        $this->set('colMdVal', 5);
        $this->set('page', $page);
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', $post);

        $startRecord = ($page - 1) * $pageSize + 1;
        $endRecord = $page * $pageSize;
        $totalRecords = $srch->recordCount();
        if ($totalRecords < $endRecord) {
            $endRecord = $totalRecords;
        }
        $this->set('totalRecords', $totalRecords);
        $this->set('startRecord', $startRecord);
        $this->set('endRecord', $endRecord);
        $this->set('showActionBtns', true);
        $this->set('isWishList', true);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        if ($totalRecords > 0) {
            $this->set('html', $this->_template->render(false, false, 'products/products-list.php', true, false));
        } else {
            $this->set('html', $this->_template->render(false, false, '_partial/no-record-found.php', true, false));
        }
        $this->set('loadMoreBtnHtml', $this->_template->render(false, false, 'products/products-list-load-more-btn.php', true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
        //$this->_template->render(false, false, 'products/products-list.php');
    }

    public function searchFavouriteListItems()
    {
        $post = FatApp::getPostedData();
        $db = FatApp::getDb();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $loggedUserId = UserAuthentication::getLoggedUserId();

        $wishListRow = Product::getUserFavouriteProducts($loggedUserId, $this->siteLangId);

        if (!$wishListRow) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $srch = new UserFavoriteProductSearch($this->siteLangId);
        $srch->setDefinedCriteria($this->siteLangId);
        $srch->joinBrands();
        $srch->joinSellers();
        $srch->joinShops();
        $srch->joinProductToCategory();
        $srch->joinSellerProductSpecialPrice();
        $srch->joinSellerSubscription($this->siteLangId, true);
        $srch->addSubscriptionValidCondition();
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $wislistPSrchObj = new UserWishListProductSearch();
        $wislistPSrchObj->joinWishLists();
        $wislistPSrchObj->doNotCalculateRecords();
        $wislistPSrchObj->addCondition('uwlist_user_id', '=', $loggedUserId);
        $wishListSubQuery = $wislistPSrchObj->getQuery();
        $srch->joinTable('(' . $wishListSubQuery . ')', 'LEFT OUTER JOIN', 'uwlp.uwlp_selprod_id = selprod_id', 'uwlp');


        $selProdReviewObj = new SelProdReviewSearch();
        $selProdReviewObj->joinSellerProducts();
        $selProdReviewObj->joinSelProdRating();
        $selProdReviewObj->addCondition('sprating_rating_type', '=', SelProdRating::TYPE_PRODUCT);
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->doNotLimitRecords();
        $selProdReviewObj->addGroupBy('spr.spreview_product_id');
        $selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id', "ROUND(AVG(sprating_rating),2) as prod_rating"));
        $selProdRviewSubQuery = $selProdReviewObj->getQuery();
        $srch->joinTable('(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_selprod_id = selprod_id', 'sq_sprating');


        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        /* groupby added, beacouse if same product is linked with multiple categories, then showing in repeat for each category[ */
        $srch->addGroupBy('selprod_id');
        /* ] */

        $srch->addMultipleFields(
            array(
                'selprod_id', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
                'product_id', 'prodcat_id', 'ufp_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'product_updated_on',
                'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand.brand_id', 'product_model',
                'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(splprice_price, selprod_price) AS theprice', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
                'CASE WHEN splprice_selprod_id IS NULL THEN 0 ELSE 1 END AS special_price_found', 'selprod_price', 'selprod_user_id', 'selprod_code', 'selprod_condition', 'IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist', 'ifnull(prod_rating,0) prod_rating', 'selprod_sold_count', 'selprod_min_order_qty', 'selprod_available_from', 'selprod_stock'
            )
        );

        $srch->addOrder('ufp_id', 'desc');
        $srch->addCondition('ufp_user_id', '=', $loggedUserId);
        $rs = $srch->getResultSet();

        $products = $db->fetchAll($rs);

        /* $prodSrchObj = new ProductSearch();
        if( $products ){
        foreach($products as &$product){
        $moreSellerSrch = clone $prodSrchObj;
        $moreSellerSrch->addMoreSellerCriteria( $product['selprod_code'], $product['selprod_user_id'] );
        $moreSellerSrch->addMultipleFields(array('count(selprod_id) as totalSellersCount','MIN(theprice) as theprice'));
        $moreSellerSrch->addGroupBy('selprod_code');
        $moreSellerRs = $moreSellerSrch->getResultSet();
        $moreSellerRow = $db->fetch($moreSellerRs);
        $product['moreSellerData'] =  ($moreSellerRow) ? $moreSellerRow : array();
        }
        } */
        $this->set('products', $products);
        $this->set('showProductShortDescription', false);
        $this->set('showProductReturnPolicy', false);
        $this->set('colMdVal', 5);
        $this->set('page', $page);
        $this->set('pagingFunc', 'goToFavouriteListingSearchPage');
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', $post);
        $this->set('showActionBtns', true);
        $startRecord = ($page - 1) * $pageSize + 1;
        $endRecord = $page * $pageSize;
        $totalRecords = $srch->recordCount();
        if ($totalRecords < $endRecord) {
            $endRecord = $totalRecords;
        }

        $this->set('totalRecords', $totalRecords);
        $this->set('startRecord', $startRecord);
        $this->set('endRecord', $endRecord);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        if ($totalRecords > 0) {
            $this->set('html', $this->_template->render(false, false, 'products/products-list.php', true, false));
        } else {
            $this->set('html', $this->_template->render(false, false, '_partial/no-record-found.php', true, false));
        }
        $this->set('loadMoreBtnHtml', $this->_template->render(false, false, 'products/products-list-load-more-btn.php', true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
        //$this->_template->render(false, false, 'products/products-list.php');
    }

    public function deleteWishList()
    {
        $uwlist_id = FatApp::getPostedData('uwlist_id', FatUtility::VAR_INT, 0);
        if (0 >= $uwlist_id) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $srch = UserWishList::getSearchObject(UserAuthentication::getLoggedUserId());
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('uwlist_id', '=', $uwlist_id);
        $srch->addCondition('uwlist_type', '!=', UserWishList::TYPE_DEFAULT_WISHLIST);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!$row) {
            $message = Labels::getLabel('ERR_NO_RECORD_FOUND', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $obj = new UserWishList();
        $obj->deleteWishList($row['uwlist_id']);
        $this->set('msg', Labels::getLabel('SUC_RECORD_DELETED_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function viewWishListItems()
    {
        $post = FatApp::getPostedData();
        $uwlist_id = FatUtility::int($post['uwlist_id']);

        $db = FatApp::getDb();
        $loggedUserId = UserAuthentication::getLoggedUserId();

        $srch = UserWishList::getSearchObject($loggedUserId);
        $srch->addMultipleFields(array('uwlist_id', 'uwlist_title', 'uwlist_type'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('uwlist_id', '=', $uwlist_id);
        $rs = $srch->getResultSet();
        $wishListRow = $db->fetch($rs);
        if (!$wishListRow) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $this->set('wishListRow', $wishListRow);
        $this->_template->render(false, false, 'account/wish-list-items.php');
    }

    public function updateSearchdate()
    {
        $post = FatApp::getPostedData();
        $pssearch_id = FatUtility::int($post['pssearch_id']);

        $srch = new SearchBase(SavedSearchProduct::DB_TBL);
        $srch->addCondition('pssearch_id', '=', $pssearch_id);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!$row) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $updateArray = array('pssearch_updated_on' => date('Y-m-d H:i:s'));
        $whr = array('smt' => 'pssearch_id = ?', 'vals' => array($pssearch_id));

        if (!FatApp::getDb()->updateFromArray(SavedSearchProduct::DB_TBL, $updateArray, $whr)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('SUC_RECORD_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleShopFavorite()
    {
        $shop_id = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $db = FatApp::getDb();

        $srch = new ShopSearch($this->siteLangId);
        $srch->setDefinedCriteria($this->siteLangId);
        $srch->joinSellerSubscription();
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(
            array(
                'shop_id', 'shop_user_id', 'shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description',
                'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city'
            )
        );
        $srch->addCondition('shop_id', '=', $shop_id);
        //echo $srch->getQuery();
        $shopRs = $srch->getResultSet();
        $shop = $db->fetch($shopRs);

        if (!$shop) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $action = 'N'; //nothing happened
        $srch = new UserFavoriteShopSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('ufs_user_id', '=', $loggedUserId);
        $srch->addCondition('ufs_shop_id', '=', $shop_id);
        $rs = $srch->getResultSet();
        if (!$row = $db->fetch($rs)) {
            $shopObj = new Shop($shop_id);
            if (!$shopObj->setFavorite($loggedUserId)) {
                $message = Labels::getLabel('ERR_SOME_PROBLEM_OCCURRED,_PLEASE_CONTACT_WEBMASTER', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                Message::addErrorMessage($message);
                FatUtility::dieWithError(Message::getHtml());
            }
            $action = 'A'; //Added to favorite
            $this->set('msg', Labels::getLabel('SUC_SHOP_IS_MARKED_AS_FAVOUTITE', $this->siteLangId));
        } else {
            if (!$db->deleteRecords(Shop::DB_TBL_SHOP_FAVORITE, array('smt' => 'ufs_user_id = ? AND ufs_shop_id = ?', 'vals' => array($loggedUserId, $shop_id)))) {
                $message = Labels::getLabel('ERR_SOME_PROBLEM_OCCURRED,_PLEASE_CONTACT_WEBMASTER', $this->siteLangId);
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($message);
                }
                Message::addErrorMessage($message);
                FatUtility::dieWithError(Message::getHtml());
            }
            $action = 'R'; //Removed from favorite
            $this->set('msg', Labels::getLabel('SUC_SHOP_HAS_BEEN_REMOVED_FROM_YOUR_FAVOURITE_LIST', $this->siteLangId));
        }

        $this->set('action', $action);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function favoriteShopSearch()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $db = FatApp::getDb();
        $srch = new UserFavoriteShopSearch($this->siteLangId);
        $srch->setDefinedCriteria();
        $srch->joinSellerOrder();
        $srch->joinSellerOrderSubscription($this->siteLangId);
        $srch->addCondition('ufs_user_id', '=', $loggedUserId);
        $srch->addMultipleFields(
            array(
                's.shop_id', 'shop_user_id', 'shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description',
                'shop_country_l.country_name as country_name', 'shop_state_l.state_name as state_name', 'shop_city',
                'IFNULL(ufs.ufs_id, 0) as is_favorite'
            )
        );
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $shops = $db->fetchAll($rs);

        $totalProductsToShow = 4;
        if ($shops) {
            foreach ($shops as &$shop) {
                $shop['shopRating'] = SelProdRating::getSellerRating($shop['shop_user_id']);
            }
        }
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('postedData', $post);
        $this->set('shops', $shops);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false);
    }

    private function isValidSelProd($selprodId)
    {
        $db = FatApp::getDb();

        $srch = new ProductSearch($this->siteLangId);
        $srch->setDefinedCriteria(0, 0, array(), false);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(['selprod_id']);
        $srch->addCondition('selprod_id', '=', $selprodId);
        $srch->joinProductToCategory();
        $srch->joinShops();
        $srch->joinSellerSubscription();
        $srch->addSubscriptionValidCondition();
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);

        $productRs = $srch->getResultSet();
        $product = $db->fetch($productRs);

        if (!$product) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        return true;
    }

    public function toggleProductStatus(int $selprodId, int $status)
    {
        $this->isValidSelProd($selprodId);

        switch ($status) {
            case applicationConstants::ACTIVE:
                $this->markAsFavorite($selprodId, false);
                $this->set('msg', Labels::getLabel('SUC_PRODUCT_HAS_BEEN_MARKED_AS_FAVOURITE_SUCCESSFULLY', $this->siteLangId));
                break;
            case applicationConstants::INACTIVE:
                $this->removeFromFavorite($selprodId, false);
                $this->set('msg', Labels::getLabel('SUC_PRODUCT_HAS_BEEN_REMOVED_FROM_FAVOURITE_LIST', $this->siteLangId));
                break;
            default:
                FatUtility::dieJsonError(Labels::getLabel('ERR_UNKNOWN_ACTION', $this->siteLangId));
                break;
        }

        $this->_template->render();
    }

    public function markAsFavorite($selprodId, $renderView = true)
    {
        $this->isValidSelProd($selprodId);
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $prodObj = new Product();
        if (!$prodObj->addUpdateUserFavoriteProduct($loggedUserId, $selprodId)) {
            $message = Labels::getLabel('ERR_SOME_PROBLEM_OCCURRED,_PLEASE_CONTACT_WEBMASTER', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->updateFavConfTime();

        if (false === $renderView) {
            return true;
        }

        $this->set('msg', Labels::getLabel('SUC_PRODUCT_HAS_BEEN_MARKED_AS_FAVOURITE_SUCCESSFULLY', $this->siteLangId));

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeFromFavorite($selprodId, $renderView = true)
    {
        $this->isValidSelProd($selprodId);
        $db = FatApp::getDb();
        $loggedUserId = UserAuthentication::getLoggedUserId();
        if (!$db->deleteRecords(Product::DB_TBL_PRODUCT_FAVORITE, array('smt' => 'ufp_user_id = ? AND ufp_selprod_id = ?', 'vals' => array($loggedUserId, $selprodId)))) {
            $message = Labels::getLabel('ERR_SOME_PROBLEM_OCCURRED,_PLEASE_CONTACT_WEBMASTER', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->updateFavConfTime();

        if (false === $renderView) {
            return true;
        }

        $this->set('msg', Labels::getLabel('SUC_PRODUCT_HAS_BEEN_REMOVED_FROM_FAVOURITE_LIST', $this->siteLangId));

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeFromFavoriteArr()
    {
        $selprodIdsArr = (array) FatApp::getPostedData('selprod_id', FatUtility::VAR_INT);
        if (empty($selprodIdsArr)) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        foreach ($selprodIdsArr as $selprodId) {
            $this->removeFromFavorite($selprodId, false);
        }

        $this->set('msg', Labels::getLabel('SUC_PRODUCT_HAS_BEEN_REMOVED_FROM_FAVOURITE_LIST', $this->siteLangId));

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function messages()
    {
        $this->userPrivilege->canViewMessages(UserAuthentication::getLoggedUserId());
        $frm = $this->getMessageSearchForm($this->siteLangId);
        $this->set('frmSrch', $frm);
        $this->_template->render();
    }

    public function messageSearch()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $userImgUpdatedOn = User::getAttributesById($userId, 'user_updated_on');
        $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);

        $frm = $this->getMessageSearchForm($this->siteLangId);

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $parentAndTheirChildIds = User::getParentAndTheirChildIds($this->userParentId, false, true);

        $srch = new MessageSearch();
        $srch->joinThreadLastMessage();
        $srch->joinMessagePostedFromUser(true, $this->siteLangId);
        $srch->joinMessagePostedToUser(true, $this->siteLangId);
        $srch->joinThreadStartedByUser();
        $srch->addMultipleFields(array(
            'tth.*',
            'ttm.message_id', 'ttm.message_text', 'ttm.message_date', 'ttm.message_is_unread',
            'ttm.message_to', 'IFNULL(tfrs_l.shop_name, tfrs.shop_identifier) as message_from_shop_name',
            'tfrs.shop_id as message_from_shop_id', 'tftos.shop_id as message_to_shop_id',
            'IFNULL(tftos_l.shop_name, tftos.shop_identifier) as message_to_shop_name'
        ));
        $srch->addCondition('ttm.message_deleted', '=', 0);
        $cnd = $srch->addCondition('ttm.message_from', 'IN', $parentAndTheirChildIds);
        $cnd->attachCondition('ttm.message_to', 'IN', $parentAndTheirChildIds, 'OR');
        $srch->addOrder('message_id', 'DESC');
        $srch->addGroupBy('ttm.message_thread_id');

        if ($post['keyword'] != '') {
            $cnd = $srch->addCondition('tth.thread_subject', 'like', "%" . $post['keyword'] . "%");
            $cnd->attachCondition('tfr.user_name', 'like', "%" . $post['keyword'] . "%", 'OR');
            $cnd->attachCondition('tfr_c.credential_username', 'like', "%" . $post['keyword'] . "%", 'OR');
        }
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        if (true === MOBILE_APP_API_CALL) {
            $message_records = array();
            foreach ($records as $mkey => $mval) {
                $profile_images_arr = array(
                    "message_from_profile_url" => UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'user', array($mval['message_from_user_id'], ImageDimension::VIEW_THUMB, 1)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                    "message_to_profile_url" => UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'user', array($mval['message_to_user_id'], ImageDimension::VIEW_THUMB, 1)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                    "message_timestamp" => strtotime($mval['message_date'])
                );
                $message_records[] = array_merge($mval, $profile_images_arr);
            }
            $records = $message_records;
        }

        /*CommonHelper::printArray($records); die;*/
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('loggedUserId', $userId);
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('parentAndTheirChildIds', $parentAndTheirChildIds);
        $this->set('postedData', $post);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false);
    }

    public function viewMessages($threadId, $messageId = 0)
    {
        $this->userPrivilege->canViewMessages(UserAuthentication::getLoggedUserId());
        $threadId = FatUtility::int($threadId);
        $messageId = FatUtility::int($messageId);
        $userId = UserAuthentication::getLoggedUserId();
        if (1 > $threadId) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            CommonHelper::redirectUserReferer();
        }

        $threadData = Thread::getAttributesById($messageId, array('thread_id,thread_type'));
        if ($threadData == false) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            CommonHelper::redirectUserReferer();
        }

        $attr = array(
            'IFNULL(shop_name, shop_identifier) as shop_name',
            'shop_id',
            'shop_updated_on',
        );
        $shopDetails = Shop::getAttributesByUserId($userId, $attr, false, $this->siteLangId);
        $srch = new MessageSearch();

        $srch->joinThreadMessage();
        $srch->joinMessagePostedFromUser();
        $srch->joinMessagePostedToUser();
        $srch->joinThreadStartedByUser();
        if ($threadData['thread_type'] == Thread::THREAD_TYPE_SHOP) {
            $srch->joinShops($this->siteLangId);
        } elseif ($threadData['thread_type'] == Thread::THREAD_TYPE_PRODUCT) {
            $srch->joinProducts($this->siteLangId);
        }

        $parentAndThierChildIds = User::getParentAndTheirChildIds($this->userParentId, false, true);

        $srch->joinOrderProducts();
        $srch->joinOrderProductStatus();
        $srch->addMultipleFields(array('tth.*', 'top.op_invoice_number'));
        $srch->addCondition('ttm.message_deleted', '=', 0);
        $srch->addCondition('tth.thread_id', '=', $threadId);
        if ($messageId) {
            $srch->addCondition('ttm.message_id', '=', $messageId);
        }

        $cnd = $srch->addCondition('ttm.message_from', 'IN', $parentAndThierChildIds);
        $cnd->attachCondition('ttm.message_to', 'IN', $parentAndThierChildIds, 'OR');
        $rs = $srch->getResultSet();
        $threadDetails = FatApp::getDb()->fetch($rs);

        if ($threadDetails == false) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            CommonHelper::redirectUserReferer();
        }

        if (false === MOBILE_APP_API_CALL) {
            $frmSrch = $this->getMsgSearchForm($this->siteLangId);
            $frmSrch->fill(array('thread_id' => $threadId));
            $frm = $this->sendMessageForm($this->siteLangId);
            $frm->fill(array('message_thread_id' => $threadId, 'message_id' => $messageId));
        }

        $threadObj = new Thread($threadId);
        if (!$threadObj->markMessageReadFromUserArr($threadId, $parentAndThierChildIds)) {
            if (true === MOBILE_APP_API_CALL) {
                Message::addErrorMessage(strip_tags(current($threadObj->getError())));
            }
            Message::addErrorMessage($threadObj->getError());
            CommonHelper::redirectUserReferer();
        }

        if (false === MOBILE_APP_API_CALL) {
            $this->set('frmSrch', $frmSrch);
            $this->set('frm', $frm);
        }
        $this->set('canEditMessages', $this->userPrivilege->canEditMessages(UserAuthentication::getLoggedUserId(), true));
        $this->set('threadDetails', $threadDetails);
        $this->set('threadTypeArr', Thread::getThreadTypeArr($this->siteLangId));
        $this->set('loggedUserId', $userId);
        $this->set('loggedUserName', ucfirst(UserAuthentication::getLoggedUserAttribute('user_name')));
        $this->set('shopDetails', $shopDetails);
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render();
    }

    public function threadMessageSearch()
    {
        $this->userPrivilege->canViewMessages(UserAuthentication::getLoggedUserId());
        $post = FatApp::getPostedData();
        $threadId = empty($post['thread_id']) ? 0 : FatUtility::int($post['thread_id']);

        if (1 > $threadId) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if (true === MOBILE_APP_API_CALL) {
            $threadObj = new Thread($threadId);
            if (!$threadObj->markUserMessageRead($threadId, UserAuthentication::getLoggedUserId())) {
                $msg = is_string($threadObj->getError()) ? $threadObj->getError() : current($threadObj->getError());
                LibHelper::dieJsonError(strip_tags($msg));
            }
        }

        $allowedUserIds = User::getParentAndTheirChildIds($this->userParentId, false, true);
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $srch = new MessageSearch();
        $srch->joinThreadMessage();
        $srch->joinMessagePostedFromUser(true, $this->siteLangId);
        $srch->joinMessagePostedToUser(true, $this->siteLangId);
        $srch->joinThreadStartedByUser();
        $srch->addMultipleFields(array(
            'tth.*', 'ttm.message_id', 'ttm.message_text', 'ttm.message_date', 'ttm.message_is_unread',
            'IFNULL(tfrs_l.shop_name, tfrs.shop_identifier) as message_from_shop_name', 'tfrs.shop_id as message_from_shop_id',
            'tftos.shop_id as message_to_shop_id', 'IFNULL(tftos_l.shop_name, tftos.shop_identifier) as message_to_shop_name'
        ));
        $srch->addCondition('ttm.message_deleted', '=', 0);
        $srch->addCondition('tth.thread_id', '=', $threadId);
        $cnd = $srch->addCondition('ttm.message_from', 'in', $allowedUserIds);
        $cnd->attachCondition('ttm.message_to', 'in', $allowedUserIds, 'OR');
        $srch->addOrder('message_id', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs, 'message_id');

        ksort($records);

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);

        $startRecord = ($page - 1) * $pagesize + 1;
        $endRecord = $pagesize;
        $totalRecords = $srch->recordCount();
        if ($totalRecords < $endRecord) {
            $endRecord = $totalRecords;
        }

        $this->set('totalRecords', $totalRecords);
        $this->set('startRecord', $startRecord);
        $this->set('endRecord', $endRecord);
        $this->set('records', $records);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->set('loadMoreBtnHtml', $this->_template->render(false, false, '_partial/load-previous-btn.php', true));
        $this->set('html', $this->_template->render(false, false, 'account/thread-message-search.php', true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function sendMessage()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $frm = $this->sendMessageForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError(current($frm->getValidationErrors()));
            }
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }

        $threadId = FatUtility::int($post['message_thread_id']);
        $messageId = FatUtility::int($post['message_id']);

        if (1 > $threadId || 1 > $messageId) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $allowedUserIds = User::getParentAndTheirChildIds($this->userParentId, false, true);

        $srch = new MessageSearch();
        $srch->joinThreadMessage();
        $srch->joinMessagePostedFromUser();
        $srch->joinMessagePostedToUser();
        $srch->joinThreadStartedByUser();
        $srch->addMultipleFields(array('tth.*'));
        $srch->addCondition('ttm.message_deleted', '=', 0);
        $srch->addCondition('tth.thread_id', '=', $threadId);
        $srch->addCondition('ttm.message_id', '=', $messageId);
        $cnd = $srch->addCondition('ttm.message_from', 'in', $allowedUserIds);
        $cnd->attachCondition('ttm.message_to', 'in', $allowedUserIds, 'OR');
        $rs = $srch->getResultSet();

        $threadDetails = FatApp::getDb()->fetch($rs);
        if (empty($threadDetails)) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        $messageSendTo = ($threadDetails['message_from_user_id'] == $userId || $threadDetails['message_from_user_id'] == $this->userParentId) ? $threadDetails['message_to_user_id'] : $threadDetails['message_from_user_id'];

        $data = array(
            'message_thread_id' => $threadId,
            'message_from' => $userId,
            'message_to' => $messageSendTo,
            'message_text' => $post['message_text'],
            'message_date' => date('Y-m-d H:i:s'),
            'message_is_unread' => 1
        );

        $tObj = new Thread();

        if (!$insertId = $tObj->addThreadMessages($data)) {
            $message = Labels::getLabel($tObj->getError(), $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }

        if ($insertId) {
            $emailObj = new EmailHandler();
            $emailObj->SendMessageNotification($insertId, $this->siteLangId);
        }

        $this->set('threadId', $threadId);
        $this->set('messageId', $insertId);
        $this->set('msg', Labels::getLabel('SUC_MESSAGE_SUBMITTED_SUCCESSFULLY!', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->set('messageDetail', $data);
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getMessageSearchForm($langId)
    {
        $frm = new Form('frmMessageSrch');
        $frm->addTextBox('', 'keyword');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $langId));
        $frm->addButton("", "btn_clear", Labels::getLabel("BTN_CLEAR", $langId), array('onclick' => 'clearSearch();'));
        $frm->addHiddenField('', 'page');
        return $frm;
    }

    private function getWithdrawalForm($langId)
    {
        $frm = new Form('frmWithdrawal');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_AMOUNT_TO_BE_WITHDRAWN', $langId) . ' [' . commonHelper::getDefaultCurrencySymbol() . ']', 'withdrawal_amount');
        $fld->requirement->setFloat(true);
        $walletBalance = User::getUserBalance(UserAuthentication::getLoggedUserId());
        $fld->htmlAfterField = Labels::getLabel("FRM_CURRENT_WALLET_BALANCE", $langId) . ' ' . CommonHelper::displayMoneyFormat($walletBalance, true, true);

        if (User::isAffiliate()) {
            $PayMethodFld = $frm->addRadioButtons(Labels::getLabel('FRM_PAYMENT_METHOD', $langId), 'uextra_payment_method', User::getAffiliatePaymentMethodArr($langId));

            /* [ */
            $frm->addTextBox(Labels::getLabel('FRM_CHEQUE_PAYEE_NAME', $langId), 'uextra_cheque_payee_name');
            $chequePayeeNameUnReqFld = new FormFieldRequirement('uextra_cheque_payee_name', Labels::getLabel('FRM_CHEQUE_PAYEE_NAME', $langId));
            $chequePayeeNameUnReqFld->setRequired(false);

            $chequePayeeNameReqFld = new FormFieldRequirement('uextra_cheque_payee_name', Labels::getLabel('FRM_CHEQUE_PAYEE_NAME', $langId));
            $chequePayeeNameReqFld->setRequired(true);

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'uextra_cheque_payee_name', $chequePayeeNameReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'uextra_cheque_payee_name', $chequePayeeNameUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'uextra_cheque_payee_name', $chequePayeeNameUnReqFld);
            /* ] */

            /* [ */
            $frm->addTextBox(Labels::getLabel('FRM_BANK_NAME', $langId), 'ub_bank_name');
            $bankNameUnReqFld = new FormFieldRequirement('ub_bank_name', Labels::getLabel('FRM_BANK_NAME', $langId));
            $bankNameUnReqFld->setRequired(false);

            $bankNameReqFld = new FormFieldRequirement('ub_bank_name', Labels::getLabel('FRM_BANK_NAME', $langId));
            $bankNameReqFld->setRequired(true);

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'ub_bank_name', $bankNameUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'ub_bank_name', $bankNameReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'ub_bank_name', $bankNameUnReqFld);
            /* ] */

            /* [ */
            $frm->addTextBox(Labels::getLabel('FRM_ACCOUNT_HOLDER_NAME', $langId), 'ub_account_holder_name');
            $bankAccHolderNameUnReqFld = new FormFieldRequirement('ub_account_holder_name', Labels::getLabel('FRM_ACCOUNT_HOLDER_NAME', $langId));
            $bankAccHolderNameUnReqFld->setRequired(false);

            $bankAccHolderNameReqFld = new FormFieldRequirement('ub_account_holder_name', Labels::getLabel('FRM_ACCOUNT_HOLDER_NAME', $langId));
            $bankAccHolderNameReqFld->setRequired(true);

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'ub_account_holder_name', $bankAccHolderNameUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'ub_account_holder_name', $bankAccHolderNameReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'ub_account_holder_name', $bankAccHolderNameUnReqFld);
            /* ] */

            /* [ */
            $frm->addTextBox(Labels::getLabel('FRM_BANK_ACCOUNT_NUMBER', $langId), 'ub_account_number');
            $bankAccNumberUnReqFld = new FormFieldRequirement('ub_account_number', Labels::getLabel('FRM_BANK_ACCOUNT_NUMBER', $langId));
            $bankAccNumberUnReqFld->setRequired(false);

            $bankAccNumberReqFld = new FormFieldRequirement('ub_account_number', Labels::getLabel('FRM_BANK_ACCOUNT_NUMBER', $langId));
            $bankAccNumberReqFld->setRequired(true);

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'ub_account_number', $bankAccNumberUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'ub_account_number', $bankAccNumberReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'ub_account_number', $bankAccNumberUnReqFld);
            /* ] */

            /* [ */
            $frm->addTextBox(Labels::getLabel('FRM_SWIFT_CODE', $langId), 'ub_ifsc_swift_code');
            $bankIfscUnReqFld = new FormFieldRequirement('ub_ifsc_swift_code', Labels::getLabel('FRM_SWIFT_CODE', $langId));
            $bankIfscUnReqFld->setRequired(false);

            $bankIfscReqFld = new FormFieldRequirement('ub_ifsc_swift_code', Labels::getLabel('FRM_SWIFT_CODE', $langId));
            $bankIfscReqFld->setRequired(true);

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'ub_ifsc_swift_code', $bankIfscUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'ub_ifsc_swift_code', $bankIfscReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'ub_ifsc_swift_code', $bankIfscUnReqFld);
            /* ] */

            /* [ */
            $frm->addTextArea(Labels::getLabel('FRM_BANK_ADDRESS', $langId), 'ub_bank_address');
            $bankBankAddressUnReqFld = new FormFieldRequirement('ub_bank_address', Labels::getLabel('FRM_BANK_ADDRESS', $langId));
            $bankBankAddressUnReqFld->setRequired(false);

            $bankBankAddressReqFld = new FormFieldRequirement('ub_bank_address', Labels::getLabel('FRM_BANK_ADDRESS', $langId));
            $bankBankAddressReqFld->setRequired(true);

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'ub_bank_address', $bankBankAddressUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'ub_bank_address', $bankBankAddressReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'ub_bank_address', $bankBankAddressUnReqFld);
            /* ] */

            /* [ */
            $fld = $frm->addTextBox(Labels::getLabel('FRM_PAYPAL_EMAIL_ACCOUNT', $langId), 'uextra_paypal_email_id');
            $PPEmailIdUnReqFld = new FormFieldRequirement('uextra_paypal_email_id', Labels::getLabel('FRM_PAYPAL_EMAIL_ACCOUNT', $langId));
            $PPEmailIdUnReqFld->setRequired(false);

            $PPEmailIdReqFld = new FormFieldRequirement('uextra_paypal_email_id', Labels::getLabel('FRM_PAYPAL_EMAIL_ACCOUNT', $langId));
            $PPEmailIdReqFld->setRequired(true);
            $PPEmailIdReqFld->setEmail();

            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_CHEQUE, 'eq', 'uextra_paypal_email_id', $PPEmailIdUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_BANK, 'eq', 'uextra_paypal_email_id', $PPEmailIdUnReqFld);
            $PayMethodFld->requirements()->addOnChangerequirementUpdate(User::AFFILIATE_PAYMENT_METHOD_PAYPAL, 'eq', 'uextra_paypal_email_id', $PPEmailIdReqFld);
            /* ] */
        } else {
            $frm->addRequiredField(Labels::getLabel('FRM_BANK_NAME', $langId), 'ub_bank_name');
            $frm->addRequiredField(Labels::getLabel('FRM_ACCOUNT_HOLDER_NAME', $langId), 'ub_account_holder_name');
            $frm->addRequiredField(Labels::getLabel('FRM_ACCOUNT_NUMBER', $langId), 'ub_account_number');
            $ifsc = $frm->addRequiredField(Labels::getLabel('FRM_IFSC_SWIFT_CODE', $langId), 'ub_ifsc_swift_code');
            $ifsc->requirements()->setRegularExpressionToValidate(ValidateElement::USERNAME_REGEX);
            $frm->addTextArea(Labels::getLabel('FRM_BANK_ADDRESS', $langId), 'ub_bank_address');
        }
        $frm->addTextArea(Labels::getLabel('FRM_OTHER_INFO_INSTRUCTIONS', $langId), 'withdrawal_instructions');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_REQUEST', $langId));
        $frm->addButton("", "btn_cancel", Labels::getLabel("BTN_CANCEL", $langId));
        return $frm;
    }

    private function getCreateWishListForm()
    {
        $frm = new Form('frmCreateWishList');
        $frm->setRequiredStarWith('NONE');
        $frm->addRequiredField('', 'uwlist_title');
        $frm->addHiddenField('', 'selprod_id');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_ADD', $this->siteLangId));
        $frm->setJsErrorDisplay('afterfield');
        return $frm;
    }

    private function getProfileInfoForm()
    {
        $frm = new Form('frmProfileInfo');
        $frm->addTextBox(Labels::getLabel('FRM_USERNAME', $this->siteLangId), 'credential_username', '');
        $frm->addTextBox(Labels::getLabel('FRM_EMAIL', $this->siteLangId), 'credential_email', '');
        $frm->addRequiredField(Labels::getLabel('FRM_CUSTOMER_NAME', $this->siteLangId), 'user_name');
        $frm->addDateField(Labels::getLabel('FRM_DATE_OF_BIRTH', $this->siteLangId), 'user_dob', '', array('readonly' => 'readonly'));
        $frm->addHiddenField('', 'user_phone_dcode');
        $phoneFld = $frm->addTextBox(Labels::getLabel('FRM_PHONE', $this->siteLangId), 'user_phone', '', array('class' => 'phone-js ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phoneFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $phoneFld->requirements()->setCustomErrorMessage(Labels::getLabel('ERR_PLEASE_ENTER_VALID_PHONE_NUMBER_FORMAT.', $this->siteLangId));
        $phoneFld->htmlAfterField = '<span class="note">' . Labels::getLabel('FRM_E.G.', $this->siteLangId) . ': ' . implode(', ', ValidateElement::PHONE_FORMATS) . '</span>';

        if (User::isAffiliate()) {
            $frm->addTextBox(Labels::getLabel('FRM_COMPANY', $this->siteLangId), 'uextra_company_name');
            $frm->addTextBox(Labels::getLabel('FRM_WEBSITE', $this->siteLangId), 'uextra_website');
            $frm->addTextBox(Labels::getLabel('FRM_ADDRESS_LINE1', $this->siteLangId), 'user_address1')->requirements()->setRequired();
            $frm->addTextBox(Labels::getLabel('FRM_ADDRESS_LINE2', $this->siteLangId), 'user_address2');
        }

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_COUNTRY', $this->siteLangId), 'user_country_id', $countriesArr, FatApp::getConfig('CONF_COUNTRY', FatUtility::VAR_INT, 0), array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('FRM_STATE', $this->siteLangId), 'user_state_id', array(), '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirement->setRequired(true);
        $frm->addTextBox(Labels::getLabel('FRM_CITY', $this->siteLangId), 'user_city');

        if (User::isAffiliate()) {
            $frm->addRequiredField(Labels::getLabel('FRM_POSTALCODE', $this->siteLangId), 'user_zip');
        }
        $parent = User::getAttributesById(UserAuthentication::getLoggedUserId(true), 'user_parent');
        if (User::isAdvertiser() && $parent == 0) {
            $fld = $frm->addTextBox(Labels::getLabel('FRM_COMPANY', $this->siteLangId), 'user_company');
            $fld = $frm->addTextArea(Labels::getLabel('FRM_BRIEF_PROFILE', $this->siteLangId), 'user_profile_info');
            $fld->html_after_field = '<small>' . Labels::getLabel('FRM_PLEASE_TELL_US_SOMETHING_ABOUT_YOURSELF', $this->siteLangId) . '</small>';
            $frm->addTextArea(Labels::getLabel('FRM_WHAT_KIND_PRODUCTS_SERVICES_ADVERTISE', $this->siteLangId), 'user_products_services');
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getProfileImageForm()
    {
        $frm = new Form('frmProfile', array('id' => 'frmProfile'));
        $frm->addFileUpload(Labels::getLabel('FRM_PROFILE_PICTURE', $this->siteLangId), 'user_profile_image', array('id' => 'user_profile_image', 'onClick' => 'popupImage(this)', 'accept' => 'image/*', 'data-frm' => 'frmProfile'));
        return $frm;
    }

    private function getBankInfoForm()
    {
        $frm = new Form('frmBankInfo');
        $frm->addRequiredField(Labels::getLabel('FRM_BANK_NAME', $this->siteLangId), 'ub_bank_name', '');
        $frm->addRequiredField(Labels::getLabel('FRM_ACCOUNT_HOLDER_NAME', $this->siteLangId), 'ub_account_holder_name', '');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_ACCOUNT_NUMBER', $this->siteLangId), 'ub_account_number', '');
        $fld->requirement->setRequired(true);

        $ifsc = $frm->addRequiredField(Labels::getLabel('FRM_IFSC_SWIFT_CODE', $this->siteLangId), 'ub_ifsc_swift_code', '');
        $ifsc->requirements()->setRegularExpressionToValidate(ValidateElement::USERNAME_REGEX);

        $frm->addTextArea(Labels::getLabel('FRM_BANK_ADDRESS', $this->siteLangId), 'ub_bank_address', '');
        $htm = '<div class="info p-3">
                    <span>
                        <svg class="svg">
                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.svg#info" href="' . CONF_WEBROOT_URL . 'images/retina/sprite.svg#info">
                            </use>
                        </svg>' . Labels::getLabel('FRM_YOUR_BANK/CARD_INFO_IS_SAFE_WITH_US', $this->siteLangId) . '
                    </span>
                </div>';
        $frm->addHtml('bank_info_safety_text', 'bank_info_safety_text', $htm);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getChangePasswordForm()
    {
        $frm = new Form('changePwdFrm');
        $curPwd = $frm->addPasswordField(
            Labels::getLabel('FRM_CURRENT_PASSWORD', $this->siteLangId),
            'current_password'
        );
        $curPwd->requirements()->setRequired();

        $newPwd = $frm->addPasswordField(
            Labels::getLabel('FRM_NEW_PASSWORD', $this->siteLangId),
            'new_password'
        );
        $newPwd->htmlAfterField = '<span class="text--small">' . sprintf(Labels::getLabel('FRM_EXAMPLE_PASSWORD', $this->siteLangId), 'User@123') . '</span>';
        $newPwd->requirements()->setRequired();
        $newPwd->requirements()->setRegularExpressionToValidate(ValidateElement::PASSWORD_REGEX);
        $newPwd->requirements()->setCustomErrorMessage(Labels::getLabel('ERR_PASSWORD_MUST_BE_ATLEAST_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->siteLangId));
        $conNewPwd = $frm->addPasswordField(
            Labels::getLabel('FRM_CONFIRM_NEW_PASSWORD', $this->siteLangId),
            'conf_new_password'
        );
        $conNewPwdReq = $conNewPwd->requirements();
        $conNewPwdReq->setRequired();
        $conNewPwdReq->setCompareWith('new_password', 'eq');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE', $this->siteLangId));
        return $frm;
    }

    private function notifyAdminSupplierApproval($userObj, $data, $approval_request = 1)
    {
        $attr = array('user_name', 'credential_username', 'credential_email');
        $userData = $userObj->getUserInfo($attr);

        if ($userData === false) {
            return false;
        }

        $data = array(
            'user_name' => $userData['user_name'],
            'username' => $userData['credential_username'],
            'user_email' => $userData['credential_email'],
            'reference_number' => $data['reference'],
        );

        $email = new EmailHandler();

        if (!$email->sendSupplierApprovalNotification(CommonHelper::getLangId(), $data, $approval_request)) {
            Message::addMessage(
                Labels::getLabel(
                    "ERR_ERROR_IN_SENDING_SUPPLIER_APPROVAL_EMAIL",
                    CommonHelper::getLangId()
                )
            );
            return false;
        }

        return true;
    }

    private function getSupplierForm()
    {
        $frm = new Form('frmSupplierForm');
        $frm->addHiddenField('', 'id', 0);

        $userObj = new User();
        $supplier_form_fields = $userObj->getSupplierFormFields($this->siteLangId);

        foreach ($supplier_form_fields as $field) {
            $fieldName = 'sformfield_' . $field['sformfield_id'];

            switch ($field['sformfield_type']) {
                case User::USER_FIELD_TYPE_TEXT:
                    $fld = $frm->addTextBox($field['sformfield_caption'], $fieldName);
                    break;

                case User::USER_FIELD_TYPE_TEXTAREA:
                    $fld = $frm->addTextArea($field['sformfield_caption'], $fieldName);
                    break;

                case User::USER_FIELD_TYPE_FILE:
                    $fld1 = $frm->addButton(
                        $field['sformfield_caption'],
                        'button[' . $field['sformfield_id'] . ']',
                        Labels::getLabel('BTN_UPLOAD_FILE', $this->siteLangId),
                        array('class' => 'fileType-Js', 'id' => 'button-upload' . $field['sformfield_id'], 'data-field_id' => $field['sformfield_id'])
                    );
                    $fld1->htmlAfterField = '<span id="input-sformfield' . $field['sformfield_id'] . '"></span>';
                    if ($field['sformfield_required'] == 1) {
                        $fld1->captionWrapper = array('<div class="astrick">', '</div>');
                    }
                    $fld = $frm->addTextBox('', $fieldName, '', array('id' => $fieldName, 'hidden' => 'hidden', 'title' => $field['sformfield_caption']));
                    $fld->setRequiredStarWith(Form::FORM_REQUIRED_STAR_WITH_NONE);
                    $fld1->attachField($fld);
                    break;

                case User::USER_FIELD_TYPE_DATE:
                    $fld = $frm->addDateField($field['sformfield_caption'], $fieldName, '', array('readonly' => 'readonly'));
                    break;

                case User::USER_FIELD_TYPE_DATETIME:
                    $fld = $frm->addDateTimeField($field['sformfield_caption'], $fieldName, '', array('readonly' => 'readonly'));
                    break;

                case User::USER_FIELD_TYPE_TIME:
                    $fld = $frm->addTextBox($field['sformfield_caption'], $fieldName);
                    $fld->requirements()->setRegularExpressionToValidate(ValidateElement::TIME_REGEX);
                    $fld->htmlAfterField = Labels::getLabel('FRM_HH:MM', $this->siteLangId);
                    $fld->requirements()->setCustomErrorMessage(Labels::getLabel('ERR_PLEASE_ENTER_VALID_TIME_FORMAT.', $this->siteLangId));
                    break;

                case User::USER_FIELD_TYPE_PHONE:
                    $fld = $frm->addTextBox($field['sformfield_caption'], $fieldName, '', array('class' => 'phone-js ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
                    $fld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
                    break;
            }

            if ($field['sformfield_required'] == 1) {
                $fld->requirements()->setRequired();
            }
            if ($field['sformfield_comment']) {
                $fld->htmlAfterField = '<p class="note">' . $field['sformfield_comment'] . '</p>';
            }
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function updatePhoto()
    {
        if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $attachment = new AttachedFile();
            if ($attachment->saveImage(
                $_FILES['photo']['tmp_name'],
                AttachedFile::FILETYPE_USER_IMAGE,
                UserAuthentication::getLoggedUserId(),
                0,
                $_FILES['photo']['name'],
                0,
                false
            )) {
                Message::addMessage(Labels::getLabel('SUC_PROFILE_PICTURE_UPDATED', $this->siteLangId));
            } else {
                Message::addErrorMessage($attachment->getError());
            }
        } else {
            Message::addErrorMessage(Labels::getLabel('ERR_NO_FILE_UPLOADED', $this->siteLangId));
        }
        FatApp::redirectUser(UrlHelper::generateUrl('member', 'account'));
    }

    public function escalateOrderReturnRequest($orrequest_id)
    {
        $orrequest_id = FatUtility::int($orrequest_id);
        if (!$orrequest_id) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }
        $user_id = UserAuthentication::getLoggedUserId();
        $srch = new OrderReturnRequestSearch();
        $srch->joinOrderProducts();
        $srch->addCondition('orrequest_id', '=', $orrequest_id);
        $srch->addCondition('orrequest_status', '=', OrderReturnRequest::RETURN_REQUEST_STATUS_PENDING);

        /* $cnd = $srch->addCondition( 'orrequest_user_id', '=', $user_id );
        $cnd->attachCondition('op_selprod_user_id', '=', $user_id ); */
        $srch->addCondition('op_selprod_user_id', '=', $user_id);

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('orrequest_id', 'orrequest_user_id'));
        $rs = $srch->getResultSet();
        $request = FatApp::getDb()->fetch($rs);

        if (!$request || $request['orrequest_id'] != $orrequest_id) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }

        /* buyer cannot escalate request[ */
        // if( $user_id == $request['orrequest_user_id'] ){
        if (!User::isSeller()) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }
        /* ] */


        $orrObj = new OrderReturnRequest();
        if (!$orrObj->escalateRequest($request['orrequest_id'], $user_id, $this->siteLangId)) {
            Message::addErrorMessage(Labels::getLabel($orrObj->getError(), $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }

        /* email notification handling[ */
        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendOrderReturnRequestStatusChangeNotification($orrequest_id, $this->siteLangId)) {
            Message::addErrorMessage(Labels::getLabel($emailNotificationObj->getError(), $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }
        /* ] */
        Message::addMessage(Labels::getLabel('SUC_YOUR_REQUEST_SENT', $this->siteLangId));
        CommonHelper::redirectUserReferer();
    }

    public function orderReturnRequestMessageSearch()
    {
        $frm = $this->getOrderReturnRequestMessageSearchForm($this->siteLangId);
        $postedData = FatApp::getPostedData();
        $post = $frm->getFormDataFromArray($postedData);
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $user_id = UserAuthentication::getLoggedUserId();

        $orrequest_id = isset($post['orrequest_id']) ? FatUtility::int($post['orrequest_id']) : 0;
        $isSeller = isset($postedData['isSeller']) ? FatUtility::int($postedData['isSeller']) : 0;

        $parentAndTheirChildIds = User::getParentAndTheirChildIds($this->userParentId, false, true);
        $srch = new OrderReturnRequestMessageSearch($this->siteLangId);
        $srch->joinOrderReturnRequests();
        $srch->joinMessageUser($this->siteLangId);
        $srch->joinMessageAdmin();
        $srch->joinOrderProducts();
        $srch->addCondition('orrmsg_orrequest_id', '=', $orrequest_id);
        if (0 < $isSeller) {
            $srch->addCondition('op_selprod_user_id', 'in', $parentAndTheirChildIds);
        } else {
            $srch->addCondition('orrequest_user_id', 'in', $parentAndTheirChildIds);
        }
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder('orrmsg_id', 'DESC');
        $srch->addMultipleFields(
            array(
                'orrmsg_id', 'orrmsg_from_user_id', 'orrmsg_msg',
                'orrmsg_date', 'msg_user.user_name as msg_user_name', 'orrequest_status',
                'orrmsg_from_admin_id', 'admin_name', 'ifnull(s_l.shop_name, s.shop_identifier) as shop_name', 's.shop_id', 'op_selprod_user_id', 'op_rounding_off'
            )
        );

        $rs = $srch->getResultSet();
        $messagesList = FatApp::getDb()->fetchAll($rs, 'orrmsg_id');
        ksort($messagesList);

        $this->set('messagesList', (!empty($messagesList) ? $messagesList : array()));
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', $post);

        $startRecord = ($page - 1) * $pageSize + 1;
        $endRecord = $page * $pageSize;
        $totalRecords = $srch->recordCount();
        if ($totalRecords < $endRecord) {
            $endRecord = $totalRecords;
        }
        $this->set('totalRecords', $totalRecords);
        $this->set('startRecord', $startRecord);
        $this->set('endRecord', $endRecord);
        $this->set('parentAndTheirChildIds', $parentAndTheirChildIds);

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->set('loadMoreBtnHtml', $this->_template->render(false, false, '_partial/load-previous-btn.php', true));
        $this->set('html', $this->_template->render(false, false, 'account/order-return-request-messages-list.php', true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function shareWithTag()
    {
        $userId = UserAuthentication::getLoggedUserId();

        if (!FatApp::getConfig("CONF_ENABLE_REFERRER_MODULE", FatUtility::VAR_INT, 1)) {
            Message::addErrorMessage(Labels::getLabel("ERR_REFFERAL_MODULE_NO_LONGER_ACTIVE", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $post = FatApp::getPostedData();
        //print_r($post); exit;
        $selprod_id = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $friendlist = FatApp::getPostedData('friendlist');
        $friendlist = rtrim($friendlist, ',');

        if (1 > $selprod_id && $friendlist == '') {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $returnDataArr = array();
        $prodSrchObj = new ProductSearch($this->siteLangId);
        $prodSrchObj->setDefinedCriteria();
        $prodSrchObj->joinSellerSubscription();
        $prodSrchObj->addSubscriptionValidCondition();
        $prodSrchObj->doNotCalculateRecords();
        $prodSrchObj->doNotLimitRecords();
        $prodSrchObj->addCondition('selprod_id', '=', $selprod_id);
        $prodSrchObj->addMultipleFields(array('selprod_id'));
        $rs = $prodSrchObj->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!$row) {
            Message::addErrorMessage(Labels::getLabel("ERR_PRODUCT_NOT_FOUND_OR_NO_LONGER_AVAILABLE.", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $user_referral_code = User::getAttributesById($userId, "user_referral_code");
        if ($user_referral_code == '') {
            Message::addErrorMessage(Labels::getLabel("ERR_YOUR_REFERRAL_CODE_IS_NOT_GENERATED,_PLEASE_CONTACT_ADMIN.", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $productUrl = UrlHelper::generateUrl('products', 'view', array($selprod_id));
        $productUrl = base64_encode(ltrim($productUrl, '/'));

        $productSharingUrl = UrlHelper::generateFullUrl("custom", "referral", array($user_referral_code, $productUrl));

        $userInfo = User::getAttributesById($userId, array('user_fb_access_token'));
        if ($userInfo['user_fb_access_token'] == '') {
            Message::addErrorMessage(Labels::getLabel('ERR_AUTHENTICATE_YOUR_ACCOUNT', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        include_once CONF_INSTALLATION_PATH . 'library/Fbapi.php';
        $config = array(
            'app_id' => FatApp::getConfig('CONF_FACEBOOK_APP_ID', FatUtility::VAR_STRING, ''),
            'app_secret' => FatApp::getConfig('CONF_FACEBOOK_APP_SECRET', FatUtility::VAR_STRING, ''),
        );
        $fb = new Fbapi($config);
        $fbObj = $fb->getInstance();

        $linkData = array(
            'link' => $productSharingUrl,
            'message' => Labels::getLabel('MSG_SHARE_AND_EARN_MESAGE', $this->siteLangId),
        );

        if ($friendlist != '') {
            $linkData['tags'] = $friendlist;
        }

        $fbAccessToken = $userInfo['user_fb_access_token'];

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fbObj->post('/me/feed', $linkData, $fbAccessToken);
        } catch (FacebookResponseException $e) {
            Message::addErrorMessage($e->getMessage());
            FatUtility::dieJsonError(Message::getHtml());
        } catch (FacebookSDKException $e) {
            Message::addErrorMessage($e->getMessage());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $graphNode = $response->getGraphNode();

        $this->set('msg', Labels::getLabel('SUC_SHARED_SUCCESSFULLY!', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function shareSocialReferEarn()
    {
        $userId = UserAuthentication::getLoggedUserId();

        if (!FatApp::getConfig("CONF_ENABLE_REFERRER_MODULE", FatUtility::VAR_INT, 1)) {
            Message::addErrorMessage(Labels::getLabel("ERR_REFFERAL_MODULE_NO_LONGER_ACTIVE", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $post = FatApp::getPostedData();
        $selprod_id = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $socialMediaName = FatApp::getPostedData('socialMediaName', FatUtility::VAR_STRING, 0);

        if ($selprod_id <= 0 || $socialMediaName == '') {
            Message::addErrorMessage(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['redirect_user'] = UrlHelper::generateUrl('products', 'view', array($selprod_id));

        /*FB API to share [*/
        include_once CONF_INSTALLATION_PATH . 'library/Fbapi.php';
        $config = array(
            'app_id' => FatApp::getConfig('CONF_FACEBOOK_APP_ID', FatUtility::VAR_STRING, ''),
            'app_secret' => FatApp::getConfig('CONF_FACEBOOK_APP_SECRET', FatUtility::VAR_STRING, ''),
        );
        $fb = new Fbapi($config);

        $userInfo = User::getAttributesById($userId, array('user_fb_access_token'));

        $fbLoginUrl = '';
        $friendList = array();
        if ($userInfo['user_fb_access_token'] == '') {
            $redirectUrl = UrlHelper::generateFullUrl('Buyer', 'getFbToken', array(), '', false);
            $fbLoginUrl = $fb->getLoginUrl($redirectUrl);
        } else {
            $fbAccessToken = $userInfo['user_fb_access_token'];
            $fbObj = $fb->getInstance();

            try {
                $response = $fbObj->get('/me/friends?fields=id,name', $fbAccessToken);
                $graphEdge = $response->getGraphEdge();
                foreach ($graphEdge as $graphNode) {
                    $friendList[] = $graphNode->asArray();
                }
            } catch (FacebookResponseException $e) {
                Message::addErrorMessage($e->getMessage());
                FatUtility::dieWithError(Message::getHtml());
            } catch (FacebookSDKException $e) {
                Message::addErrorMessage($e->getMessage());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $this->set('fbLoginUrl', $fbLoginUrl);
        $this->set('friendList', $friendList);
        $this->set('selprod_id', $selprod_id);
        $this->_template->render(false, false);
    }

    private function getCreditsSearchForm($langId)
    {
        $frm = new Form('frmCreditSrch');
        $frm->addTextBox('', 'keyword', '');
        $frm->addSelectBox('', 'debit_credit_type', array(-1 => Labels::getLabel('FRM_BOTH-DEBIT/CREDIT', $langId)) + Transactions::getCreditDebitTypeArr($langId), -1, array(), '');
        $frm->addDateField('', 'date_from', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField('', 'date_to', '', array('readonly' => 'readonly', 'class' => 'field--calender'));

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $langId));
        $frm->addButton("", "btn_clear", Labels::getLabel("BTN_CLEAR", $langId), array('onclick' => 'clearSearch();'));
        $frm->addHiddenField('', 'page');
        return $frm;
    }

    private function sendMessageForm($langId)
    {
        $frm = new Form('frmSendMessage');
        $frm->addTextarea(Labels::getLabel('FRM_COMMENTS', $langId), 'message_text', '')->requirements()->setRequired(true);
        $frm->addHiddenField('', 'message_thread_id');
        $frm->addHiddenField('', 'message_id');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEND', $langId));
        return $frm;
    }

    private function getMsgSearchForm($langId)
    {
        $frm = new Form('frmMessageSrch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'thread_id');
        return $frm;
    }

    private function getSettingsForm()
    {
        $frm = new Form('frmBankInfo');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_AUTO_RENEW_SUBSCRIPTION', $this->siteLangId), 'user_autorenew_subscription', $activeInactiveArr, '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getRechargeWalletForm($langId)
    {
        $frm = new Form('frmRechargeWallet');
        $frm->addFloatField('', 'amount');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_ADD_CREDITS', $langId));
        return $frm;
    }

    public function myAddresses()
    {
        $this->_template->render();
    }

    public function searchAddresses()
    {
        $address = new Address(0, $this->siteLangId);
        $addresses = $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId());

        if ($addresses) {
            $this->set('addresses', $addresses);
        } else {
            if (true === MOBILE_APP_API_CALL) {
                $this->set('addresses', array());
            }
            $this->set('noRecordsHtml', $this->_template->render(false, false, '_partial/no-record-found.php', true));
        }
        if (true === MOBILE_APP_API_CALL) {
            $cartObj = new Cart(UserAuthentication::getLoggedUserId());
            $shipping_address_id = $cartObj->getCartShippingAddress();
            $this->set('shippingAddressId', $shipping_address_id);
            $this->_template->render();
        }
        $this->_template->render(false, false);
    }

    public function addAddressForm($addr_id)
    {
        $addr_id = FatUtility::int($addr_id);
        $addressFrm = $this->getUserAddressForm($this->siteLangId);

        $stateId = 0;

        if ($addr_id > 0) {
            $address = new Address($addr_id, $this->siteLangId);
            $data = $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId());
            if (empty($data)) {
                Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                FatUtility::dieJsonError(Message::getHtml());
            }
            $stateId = $data['addr_state_id'];
            $addressFrm->fill($data);
        }

        $this->set('addr_id', $addr_id);
        $this->set('stateId', $stateId);
        $this->set('addressFrm', $addressFrm);
        $this->_template->render(false, false);
    }

    public function truncateDataRequestPopup()
    {
        $this->_template->render(false, false);
    }

    public function sendTruncateRequest()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $db = FatApp::getDb();

        $srch = new UserGdprRequestSearch();
        $srch->addCondition('ureq_user_id', '=', $userId);
        $srch->addCondition('ureq_type', '=', UserGdprRequest::TYPE_TRUNCATE);
        $srch->addCondition('ureq_status', '=', UserGdprRequest::STATUS_PENDING);
        $srch->addCondition('ureq_deleted', '=', applicationConstants::NO);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if ($row) {
            Message::addErrorMessage(Labels::getLabel('ERR_YOU_HAVE_ALRADY_SUBMITTED_THE_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $assignValues = array(
            'ureq_user_id' => $userId,
            'ureq_type' => UserGdprRequest::TYPE_TRUNCATE,
            'ureq_date' => date('Y-m-d H:i:s'),
        );

        $userReqObj = new UserGdprRequest();
        $userReqObj->assignValues($assignValues);
        if (!$userReqObj->save()) {
            Message::addErrorMessage($userReqObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        Message::addMessage(Labels::getLabel('SUC_REQUEST_SENT_SUCCESSFULLY', $this->siteLangId));
        FatUtility::dieJsonSuccess(Message::getHtml());
    }

    private function getRequestDataForm()
    {
        $frm = new Form('frmRequestdata');
        $frm->addTextBox(Labels::getLabel('FRM_EMAIL', $this->siteLangId), 'credential_email', '', array('readonly' => 'readonly'));
        $frm->addTextBox(Labels::getLabel('FRM_NAME', $this->siteLangId), 'user_name', '', array('readonly' => 'readonly'));
        $purposeFld = $frm->addTextArea(Labels::getLabel('FRM_PURPOSE_OF_REQUEST_DATA', $this->siteLangId), 'ureq_purpose');
        $purposeFld->requirements()->setRequired();
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEND_REQUEST', $this->siteLangId));
        return $frm;
    }

    public function requestDataForm()
    {
        $userObj = new User(UserAuthentication::getLoggedUserId());
        $srch = $userObj->getUserSearchObj(array('credential_username', 'credential_email', 'user_name'));
        $rs = $srch->getResultSet();

        if (!$rs) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $data = FatApp::getDb()->fetch($rs, 'user_id');

        if ($data === false) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $cPageSrch = ContentPage::getSearchObject($this->siteLangId);
        $cPageSrch->addCondition('cpage_id', '=', FatApp::getConfig('CONF_GDPR_POLICY_PAGE', FatUtility::VAR_INT, 0));
        $cpage = FatApp::getDb()->fetch($cPageSrch->getResultSet());
        $gdprPolicyLinkHref = '';
        if (!empty($cpage) && is_array($cpage)) {
            $gdprPolicyLinkHref = UrlHelper::generateUrl('Cms', 'view', array($cpage['cpage_id']));
        }

        $frm = $this->getRequestDataForm();
        $frm->fill($data);
        $this->set('frm', $frm);
        $this->set('gdprPolicyLinkHref', $gdprPolicyLinkHref);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function setupRequestData()
    {
        $frm = $this->getRequestDataForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $userId = UserAuthentication::getLoggedUserId();

        $srch = new UserGdprRequestSearch();
        $srch->addCondition('ureq_user_id', '=', $userId);
        $srch->addCondition('ureq_type', '=', UserGdprRequest::TYPE_DATA_REQUEST);
        $srch->addCondition('ureq_status', '=', UserGdprRequest::STATUS_PENDING);
        $srch->addCondition('ureq_deleted', '=', applicationConstants::NO);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if ($row) {
            Message::addErrorMessage(Labels::getLabel('ERR_YOU_HAVE_ALRADY_SUBMITTED_THE_DATA_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $assignValues = array(
            'ureq_user_id' => $userId,
            'ureq_type' => UserGdprRequest::TYPE_DATA_REQUEST,
            'ureq_date' => date('Y-m-d H:i:s'),
            'ureq_purpose' => $post['ureq_purpose'],
        );

        $userReqObj = new UserGdprRequest();
        $userReqObj->assignValues($assignValues);
        if (!$userReqObj->save()) {
            Message::addErrorMessage($userReqObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $post['user_id'] = $userId;
        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendDataRequestNotification($post, $this->siteLangId)) {
            Message::addErrorMessage(Labels::getLabel($emailNotificationObj->getError(), $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('SUC_REQUEST_SENT_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    //Valid for 10 Minutes only
    public function getTempToken()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $uObj = new User($userId);
        $tempToken = substr(md5(rand(1, 99999) . microtime()), 0, UserAuthentication::TOKEN_LENGTH);

        if (!$uObj->createUserTempToken($tempToken)) {
            FatUtility::dieJsonError($uObj->getError());
        }
        $this->set('data', array('tempToken' => $tempToken));
        $this->_template->render();
    }

    public function notifications()
    {
        $userId = UserAuthentication::getLoggedUserId();

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $defaultPageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $pageSize = FatApp::getPostedData('pagesize', FatUtility::VAR_INT, $defaultPageSize);
        $srch = Notifications::getSearchObject();
        $srch->addCondition('unt.unotification_user_id', '=', $userId);
        $srch->addOrder('unt.unotification_id', 'DESC');
        $srch->addMultipleFields(array('unt.*'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('notifications', $records);
        $this->set('total_pages', $srch->pages());
        $this->set('total_records', $srch->recordCount());
        $this->_template->render();
    }

    public function readAllNotifications()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $smt = array(
            'smt' => Notifications::DB_TBL_PREFIX . 'is_read = ? AND ' . Notifications::DB_TBL_PREFIX . 'user_id = ?',
            'vals' => array(applicationConstants::NO, (int) $userId)
        );
        $db = FatApp::getDb();
        if (!$db->updateFromArray(Notifications::DB_TBL, array(Notifications::DB_TBL_PREFIX . 'is_read' => 1), $smt)) {
            FatUtility::dieJsonError($db->getError());
        }
        $this->set('msg', Labels::getLabel('SUC_SUCCESSFULLY_UPDATED', $this->siteLangId));
        $this->_template->render();
    }

    public function markNotificationRead($notificationId)
    {
        $notificationId = FatUtility::int($notificationId);
        if (1 > $notificationId) {
            FatUtility::dieJSONError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $userId = UserAuthentication::getLoggedUserId();

        $srch = Notifications::getSearchObject();
        $srch->addCondition('unt.unotification_user_id', '=', $userId);
        $srch->addCondition('unt.unotification_id', '=', $notificationId);
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $notification = FatApp::getDb()->fetch($rs);
        if (!($notification)) {
            FatUtility::dieJSONError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $nObj = new Notifications();
        if (!$nObj->readUserNotification($notificationId, $userId)) {
            FatUtility::dieJsonError($nObj->getError());
        }
        $this->set('msg', Labels::getLabel('SUC_SUCCESSFULLY_UPDATED', $this->siteLangId));
        $this->_template->render();
    }

    public function changePhoneForm($updatePhnFrm = 0)
    {
        $userId = UserAuthentication::getLoggedUserId();
        $phData = User::getAttributesById($userId, ['user_phone_dcode', 'user_phone', 'user_country_id']);
        $updatePhnFrm = empty($updatePhnFrm) ? (empty($phData['user_phone']) ? 1 : 0) : $updatePhnFrm;

        $frm = $this->getPhoneNumberForm();
        if (1 > $updatePhnFrm && !empty($phData['user_phone'])) {
            $frm->fill($phData);
            $phnFld = $frm->getField('user_phone');
            $phnFld->setFieldTagAttribute('readonly', 'readonly');
        }

        $countryIso = Countries::getCountryById($phData['user_country_id'], $this->siteLangId, 'country_code');
        $this->set('countryIso', $countryIso);
        $this->set('frm', $frm);
        $this->set('updatePhnFrm', $updatePhnFrm);
        $this->set('siteLangId', $this->siteLangId);
        $json['html'] = $this->_template->render(false, false, 'account/change-phone-form.php', true, false);
        FatUtility::dieJsonSuccess($json);
    }

    private function sendOtp(int $userId, string $dialCode, int $phone)
    {
        $userObj = new User($userId);
        $dialCode = ValidateElement::formatDialCode(trim($dialCode));
        $otp = $userObj->prepareUserPhoneOtp($dialCode, $phone);
        if (false == $otp) {
            LibHelper::dieJsonError($userObj->getError());
        }

        $userData = $userObj->getUserInfo('user_name', false, false);
        $obj = clone $userObj;
        if (false === $obj->sendOtp($dialCode . $phone, $userData['user_name'], $otp, $this->siteLangId)) {
            LibHelper::dieJsonError($obj->getError());
        }
        return true;
    }

    public function getOtp($updatePhnFrm = 0)
    {
        $frm = $this->getPhoneNumberForm();

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }

        $phoneNumber = FatApp::getPostedData('user_phone', FatUtility::VAR_INT, '');
        $dialCode = FatApp::getPostedData('user_phone_dcode', FatUtility::VAR_STRING, '');
        if (empty($phoneNumber) || empty($dialCode)) {
            $message = Labels::getLabel("ERR_INVALID_PHONE_NUMBER_FORMAT", $this->siteLangId);
            LibHelper::dieJsonError($message);
        }

        $userId = UserAuthentication::getLoggedUserId();
        if (1 > $updatePhnFrm && false === UserAuthentication::validateUserPhone($userId, $phoneNumber)) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_PHONE_NUMBER', $this->siteLangId));
        }

        if (0 < $updatePhnFrm) {
            $db = FatApp::getDb();
            $srch = User::getSearchObject(false, 0, false);
            $srch->addCondition('user_phone', '=', $phoneNumber);
            $srch->addCondition('user_id', '!=', $userId);
            $rs = $srch->getResultSet();
            $row = $db->fetch($rs);
            if (!empty($row)) {
                LibHelper::dieJsonError(Labels::getLabel('ERR_THIS_PHONE_NUMBER_IS_ALREADY_EXISTS.', $this->siteLangId));
            }
        }

        $this->sendOtp($userId, $dialCode,  $phoneNumber);

        $this->set('msg', Labels::getLabel('SUC_OTP_SENT!_PLEASE_CHECK_YOUR_PHONE.', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $otpFrm = $this->getOtpForm();
        $otpFrm->fill(['user_id' => $userId]);
        $this->set('frm', $otpFrm);
        $json['html'] = $this->_template->render(false, false, 'guest-user/otp-form.php', true, false);
        FatUtility::dieJsonSuccess($json);
    }

    public function validateOtp($updatePhnFrm = 0)
    {
        $updateToDb = (1 > $updatePhnFrm ? 1 : 0);
        $this->validateOtpApi($updateToDb);

        if (0 < $updatePhnFrm) {
            $this->changePhoneForm($updatePhnFrm);
            exit;
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function resendOtp()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $dialCode = FatApp::getPostedData('user_phone_dcode', FatUtility::VAR_STRING, '');
        $phone = FatApp::getPostedData('user_phone', FatUtility::VAR_INT, 0);

        if (!empty($phone)) {
            $this->sendOtp($userId, $dialCode, $phone);
        } else {
            $userObj = new User($userId);
            if (false == $userObj->resendOtp()) {
                FatUtility::dieJsonError($userObj->getError());
            }
        }

        $this->set('msg', Labels::getLabel('SUC_OTP_SENT!_PLEASE_CHECK_YOUR_PHONE.', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function pushNotifications()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $defaultPageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $pageSize = FatApp::getPostedData('pagesize', FatUtility::VAR_INT, $defaultPageSize);

        $srch = User::getSearchObject();
        $srch->joinTable(UserAuthentication::DB_TBL_USER_AUTH, 'INNER JOIN', 'ua.uauth_user_id = u.user_id', 'ua');
        $srch->addMultipleFields(['uauth_device_os', 'user_regdate']);
        $srch->addCondition('uauth_user_id', '=', $userId);
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $uData = FatApp::getDb()->fetch($rs);

        $srch = PushNotification::getSearchObject(true);
        $srch->addMultipleFields([
            'pnotification_id',
            'pnotification_title',
            'pnotification_description',
            'pnotification_url',
            'pntu_user_id'
        ]);
        $cond = $srch->addCondition('pnotification_status', '=', PushNotification::STATUS_COMPLETED, 'AND');
        $cond->attachCondition('pnotification_status', '=', PushNotification::STATUS_PROCESSING, 'OR');
        $srch->addCondition('pnotification_user_auth_type', '=', User::AUTH_TYPE_REGISTERED);
        $srch->addCondition('pnotification_added_on', '>=', $uData['user_regdate']);
        $cond = $srch->addCondition('pntu_user_id', 'IS', 'mysql_func_NULL', 'AND', true);
        $cond->attachCondition('pntu_user_id', '=', $userId, 'OR');
        $cond = $srch->addCondition('pnotification_device_os', '=', User::DEVICE_OS_BOTH, 'AND');
        $cond->attachCondition('pnotification_device_os', '=', $uData['uauth_device_os'], 'OR');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder('pnotification_added_on', 'DESC');
        $srch->addOrder('pnotification_id', 'DESC');
        $rs = $srch->getResultSet();
        $pnotificationsArr = FatApp::getDb()->fetchAll($rs);

        $this->set('pnotifications', $pnotificationsArr);
        $this->set('total_pages', $srch->pages());
        $this->set('total_records', $srch->recordCount());
        $this->_template->render();
    }

    /* Cards Management */
    private function setErrorAndRedirect(string $msg, bool $json = false, $redirect = true)
    {
        $json = FatUtility::isAjaxCall() ? true : $json;
        LibHelper::exitWithError($msg, $json, $redirect);
        CommonHelper::redirectUserReferer();
    }

    public function cards()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $paymentCard = new PaymentCard($this->siteLangId, $userId);
        if (false === $paymentCard->fetchAll()) {
            $this->setErrorAndRedirect($paymentCard->getError());
        }
        $this->set('savedCards', $paymentCard->getResponse());

        if (false === $paymentCard->getDefault()) {
            $this->setErrorAndRedirect($paymentCard->getError());
        }
        $this->set('defaultSource', $paymentCard->getResponse());
        $this->_template->render();
    }

    /**
     * removeCard
     *
     * @param  string $cardId
     * @return void
     */
    public function removeCard(string $cardId)
    {
        if (empty($cardId)) {
            $this->setErrorAndRedirect(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $userId = UserAuthentication::getLoggedUserId();
        $paymentCard = new PaymentCard($this->siteLangId, $userId);
        if (false === $paymentCard->delete($cardId)) {
            $this->setErrorAndRedirect($paymentCard->getError());
        }

        $msg = Labels::getLabel("SUC_REMOVED_SUCCESSFULLY", $this->siteLangId);
        FatUtility::dieJsonSuccess($msg);
    }

    /**
     * addCardForm
     *
     * @return void
     */
    public function addCardForm()
    {
        $frm = PaymentCard::getCardForm($this->siteLangId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }


    /**
     * bindCustomer
     *
     * @return void
     */
    public function bindCustomer()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $paymentCard = new PaymentCard($this->siteLangId, $userId);
        if (false === $paymentCard->bindCustomer()) {
            $this->setErrorAndRedirect($paymentCard->getError());
        }

        $customer = $paymentCard->getResponse();
        $json['customerId'] = $customer->id;
        $json['msg'] = Labels::getLabel('SUC_SUCCESS', $this->siteLangId);
        FatUtility::dieJsonSuccess($json);
    }

    /**
     * setupNewCard
     *
     * @return void
     */
    public function setupNewCard()
    {
        $cardFrm = PaymentCard::getCardForm($this->siteLangId);
        $cardData = $cardFrm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $cardData) {
            $this->setErrorAndRedirect(current($cardFrm->getValidationErrors()));
        }
        unset($cardData['btn_submit']);

        $userId = UserAuthentication::getLoggedUserId();
        $paymentCard = new PaymentCard($this->siteLangId, $userId);
        if (false === $paymentCard->create($cardData)) {
            $this->setErrorAndRedirect($paymentCard->getError());
        }

        $cardTokenResponse = $paymentCard->getResponse();
        $json['cardId'] = $cardTokenResponse->id;
        $json['msg'] = Labels::getLabel('SUC_SUCCESS', $this->siteLangId);
        FatUtility::dieJsonSuccess($json);
    }

    /**
     * markAsDefault
     *
     * @param  string $cardId
     * @return void
     */
    public function markAsDefault(string $cardId)
    {
        if (empty($cardId)) {
            $this->setErrorAndRedirect(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $paymentCard = new PaymentCard($this->siteLangId, $userId);
        if (false === $paymentCard->markAsDefault($cardId)) {
            $this->setErrorAndRedirect($paymentCard->getError());
        }

        $json['msg'] = Labels::getLabel('SUC_SUCESS', $this->siteLangId);
        FatUtility::dieJsonSuccess($json);
    }
    /* Cards Management */

    public function viewBuyerOrderInvoice($orderId, $opId = 0)
    {
        if (!$orderId) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            CommonHelper::redirectUserReferer();
        }

        $opId = FatUtility::int($opId);
        $userId = UserAuthentication::getLoggedUserId();

        $srch = new OrderProductSearch($this->siteLangId, true, true);
        $srch->joinPaymentMethod();
        $srch->joinSellerProducts();
        $srch->joinShop();
        $srch->joinShopSpecifics();
        $srch->joinShopCountry();
        $srch->joinShopState();
        $srch->addOrderProductCharges();
        $srch->addCondition('order_id', '=', $orderId);
        if (0 < $opId) {
            $srch->addCondition('op_id', '=', $opId);
        }
        $srch->addDirectCondition("((op_selprod_user_id = $userId and op.op_status_id IN (" . implode(",", unserialize(FatApp::getConfig("CONF_VENDOR_ORDER_STATUS"))) . ")) or (order_user_id=$userId and op.op_status_id IN (" . implode(",", unserialize(FatApp::getConfig("CONF_BUYER_ORDER_STATUS"))) . ") ) )");

        $srch->addMultipleFields(array('*', 'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city'));

        $childOrderDetail = FatApp::getDb()->fetchAll($srch->getResultSet(), 'op_id');

        if (1 > count($childOrderDetail)) {
            $message = Labels::getLabel('ERR_INVALID_ORDER', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            CommonHelper::redirectUserReferer();
        }

        $orderObj = new Orders();
        $orderDetail = $orderObj->getOrderById($orderId, $this->siteLangId);
        $orderDetail['charges'] = $orderObj->getOrderProductChargesByOrderId($orderDetail['order_id']);

        if (count($childOrderDetail)) {
            foreach ($childOrderDetail as &$arr) {
                $arr['options'] = SellerProduct::getSellerProductOptions($arr['op_selprod_id'], true, $this->siteLangId);
            }
        }

        foreach ($childOrderDetail as $op_id => $val) {
            $childOrderDetail[$op_id]['charges'] = $orderDetail['charges'][$op_id];

            $opChargesLog = new OrderProductChargeLog($op_id);
            $taxOptions = $opChargesLog->getData($this->siteLangId);
            $childOrderDetail[$op_id]['taxOptions'] = $taxOptions;
        }

        $address = $orderObj->getOrderAddresses($orderDetail['order_id']);
        $orderDetail['billingAddress'] = $address[Orders::BILLING_ADDRESS_TYPE];
        $orderDetail['shippingAddress'] = (!empty($address[Orders::SHIPPING_ADDRESS_TYPE])) ? $address[Orders::SHIPPING_ADDRESS_TYPE] : array();

        $pickUpAddress = $orderObj->getOrderAddresses($orderDetail['order_id'], $opId);
        $orderDetail['pickupAddress'] = (!empty($pickUpAddress[Orders::PICKUP_ADDRESS_TYPE])) ? $pickUpAddress[Orders::PICKUP_ADDRESS_TYPE] : array();

        $template = new FatTemplate('', '');
        $template->set('siteLangId', $this->siteLangId);
        $template->set('orderDetail', $orderDetail);
        $template->set('childOrderDetail', $childOrderDetail);
        $template->set('opId', $opId);

        require_once(CONF_INSTALLATION_PATH . 'library/tcpdf/tcpdf.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId));
        $pdf->SetKeywords(FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderMargin(0);
        $pdf->SetHeaderData('', 0, '', '', array(255, 255, 255), array(255, 255, 255));
        $pdf->setFooterData(array(0, 0, 0), array(200, 200, 200));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(10, 10, 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $pdf->SetTitle(Labels::getLabel('MSG_TAX_INVOICE', $this->siteLangId));
        $pdf->SetSubject(Labels::getLabel('MSG_TAX_INVOICE', $this->siteLangId));

        // set LTR direction for english translation
        $pdf->setRTL(('rtl' == Language::getLayoutDirection($this->siteLangId)));
        // set font
        $pdf->SetFont('dejavusans');

        $templatePath = "account/view-buyer-order-invoice.php";
        $html = $template->render(false, false, $templatePath, true, true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        ob_end_clean();
        // $saveFile = CONF_UPLOADS_PATH . 'demo-pdf.pdf';
        //$pdf->Output($saveFile, 'F');
        $pdf->Output('tax-invoice.pdf', 'I');
        return true;
    }

    private function updateFavConfTime()
    {
        $arrToUpdate = [
            'conf_name' => 'LAST_FAV_MARK_TIME',
            'conf_val' => time()
        ];
        if (!FatApp::getDb()->insertFromArray(
            'tbl_configurations',
            $arrToUpdate,
            false,
            array(),
            $arrToUpdate
        )) {
            echo "2424";
        }
    }
}
