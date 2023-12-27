<?php

class PayoutBaseController extends PluginSettingController
{
    protected $envoirment;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->envoirment = FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_BOOLEAN, false);
    }

    public function index()
    {
        $recordId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            LibHelper::dieJsonError($message);
        }

        $comment = FatApp::getPostedData('comment', FatUtility::VAR_STRING, '');

        $specifics = WithdrawalRequestsSearch::getWithDrawalSpecifics($recordId);
        try {
            $calledClass = get_called_class();
            $obj = new $calledClass(__FUNCTION__);
            $response = $obj->release($recordId, $specifics);
        } catch (\Error $e) {
            $message = 'ERR - ' . $e->getMessage();
            LibHelper::dieJsonError($message);
        }

        if (true !== $response['status']) {
            $message = Labels::getLabel('ERR_UNABLE_TO_PROCEED!_PLEASE_TRY_AGAIN', $this->siteLangId);
            LibHelper::dieJsonError($message);
        }

        $this->updateWithdrawalRequest($recordId, json_encode($response['data']), Transactions::WITHDRAWL_STATUS_PROCESSED, Transactions::STATUS_APPROVED);

        $assignFields = array('withdrawal_status' => Transactions::WITHDRAWL_STATUS_PROCESSED, 'withdrawal_comments' => $comment);
        if (!FatApp::getDb()->updateFromArray(User::DB_TBL_USR_WITHDRAWAL_REQ, $assignFields, array('smt' => 'withdrawal_id=?', 'vals' => array($recordId)))) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }

        $oldTrxComment = Transactions::getAttributesById($recordId, 'utxn_comments');
        $rs = FatApp::getDb()->updateFromArray(
                Transactions::DB_TBL,
                array('utxn_comments' => $oldTrxComment . " (" . $comment . ")"),
                array('smt' => 'utxn_withdrawal_id=?', 'vals' => array($recordId))
        );
        CalculativeDataRecord::updateWithdrawalRequestCount();
        $this->set('msg', Labels::getLabel('ERR_PAYOUT_REQUEST_SENT_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateWithdrawalRequest($recordId, $data, $status, $txnstatus = '')
    {
        $txnstatus = empty($txnstatus) ? Transactions::STATUS_COMPLETED : $txnstatus;
        $updateData = [
            'uwrs_withdrawal_id' => $recordId,
            'uwrs_key' => 'PAYOUT_INITIATE_WEBHOOK_RESPONSE',
            'uwrs_value' => is_array($data) ? serialize($data) : $data,
        ];

        if (!FatApp::getDb()->insertFromArray(User::DB_TBL_USR_WITHDRAWAL_REQ_SPEC, $updateData, true, array(), $updateData)) {
            $message = Labels::getLabel('LBL_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $assignFields = array('withdrawal_status' => $status);
        if (!FatApp::getDb()->updateFromArray(User::DB_TBL_USR_WITHDRAWAL_REQ, $assignFields, array('smt' => 'withdrawal_id=?', 'vals' => array($recordId)))) {
            FatUtility::dieJsonError(FatApp::getDb()->getError());
        }

        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendWithdrawRequestNotification($recordId, $this->siteLangId, "U")) {
            FatUtility::dieJsonError(Labels::getLabel($emailNotificationObj->getError(), $this->siteLangId));
        }
        
        FatApp::getDb()->updateFromArray(
            Transactions::DB_TBL,
            array("utxn_status" => $txnstatus),
            array('smt' => 'utxn_withdrawal_id=?', 'vals' => array($recordId))
        );
        
        if ($status == Transactions::WITHDRAWL_STATUS_DECLINED) {
            $transObj = new Transactions();
            $txnDetail = $transObj->getAttributesBywithdrawlId($recordId);
            $formattedRequestValue = '#' . str_pad($recordId, 6, '0', STR_PAD_LEFT);
            
            $txnArray["utxn_user_id"] = $txnDetail["utxn_user_id"];
            $txnArray["utxn_credit"] = $txnDetail["utxn_debit"];
            $txnArray["utxn_status"] = $txnstatus;
            $txnArray["utxn_withdrawal_id"] = $txnDetail["utxn_withdrawal_id"];
            $txnArray["utxn_type"] = Transactions::TYPE_MONEY_WITHDRAWL_REFUND;
            $txnArray["utxn_comments"] = sprintf(Labels::getLabel('MSG_Withdrawal_Request_Declined_Amount_Refunded', $this->siteLangId), $formattedRequestValue);
            
            if ($txnId = $transObj->addTransaction($txnArray)) {
                $emailNotificationObj->sendTxnNotification($txnId, $this->siteLangId);
            }
        }
        CalculativeDataRecord::updateWithdrawalRequestCount();        
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
