<?php
class PayoutBaseController extends PluginBaseController
{
    protected function validateWithdrawalRequest()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $post = FatApp::getPostedData();

        $balance = User::getUserBalance($userId);
        $lastWithdrawal = User::getUserLastWithdrawalRequest($userId);

        if ($lastWithdrawal && (strtotime($lastWithdrawal["withdrawal_request_date"] . "+" . FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS", FatUtility::VAR_INT, 0) . " days") - time()) > 0) {
            $nextWithdrawalDate = date('d M,Y', strtotime($lastWithdrawal["withdrawal_request_date"] . "+" . FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS") . " days"));

            $message = sprintf(Labels::getLabel('MSG_Withdrawal_Request_Date', $this->siteLangId), FatDate::format($lastWithdrawal["withdrawal_request_date"]), FatDate::format($nextWithdrawalDate), FatApp::getConfig("CONF_MIN_INTERVAL_WITHDRAW_REQUESTS"));
            FatUtility::dieJsonError($message);
        }

        $minimumWithdrawLimit = FatApp::getConfig("CONF_MIN_WITHDRAW_LIMIT", FatUtility::VAR_INT, 0);
        if ($balance < $minimumWithdrawLimit) {
            $message = sprintf(Labels::getLabel('MSG_Withdrawal_Request_Minimum_Balance_Less', $this->siteLangId), CommonHelper::displayMoneyFormat($minimumWithdrawLimit));
            FatUtility::dieJsonError($message);
        }

        if (($minimumWithdrawLimit > $post["amount"])) {
            $message = sprintf(Labels::getLabel('MSG_Your_withdrawal_request_amount_is_less_than_the_minimum_allowed_amount_of_%s', $this->siteLangId), CommonHelper::displayMoneyFormat($minimumWithdrawLimit));
            FatUtility::dieJsonError($message);
        }

        $maximumWithdrawLimit = FatApp::getConfig("CONF_MAX_WITHDRAW_LIMIT", FatUtility::VAR_INT, 0);
        if (($maximumWithdrawLimit < $post["amount"])) {
            $message = sprintf(Labels::getLabel('MSG_Your_withdrawal_request_amount_is_greater_than_the_maximum_allowed_amount_of_%s', $this->siteLangId), CommonHelper::displayMoneyFormat($maximumWithdrawLimit));
            FatUtility::dieJsonError($message);
        }

        if (($post["amount"] > $balance)) {
            $message = Labels::getLabel('MSG_Withdrawal_Request_Greater', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }
    }

    public function getRequestForm()
    {
        $this->set('html', $this->_template->render(false, false, '_partial/no-record-found.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
}
