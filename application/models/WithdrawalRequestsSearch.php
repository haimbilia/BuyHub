<?php

class WithdrawalRequestsSearch extends SearchBase
{
    private $langId;
    private $joinUsers = false;
    private $commonLangId;
    public const DB_TBL = WithdrawalRequest::DB_TBL;

    public function __construct()
    {
        parent::__construct(static::DB_TBL, 'tuwr');
        $this->commonLangId = CommonHelper::getLangId();
    }

    public function joinUsers($activeUser = false)
    {
        $this->joinUsers = true;
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'tuwr.withdrawal_user_id = tu.user_id', 'tu');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tc.credential_user_id = tu.user_id', 'tc');

        if ($activeUser) {
            $this->addCondition('tc.credential_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
            $this->addCondition('tc.credential_verified', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        }
    }

    public function joinForUserBalance()
    {
        if (!$this->joinUsers) {
            trigger_error(Labels::getLabel('ERR_You_must_join_joinUsers', $this->commonLangId), E_USER_ERROR);
        }
        $srch = new SearchBase(Transactions::DB_TBL, 'txn');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('txn.utxn_user_id');
        $srch->addCondition('txn.utxn_status', '=', 'mysql_func_' . Transactions::STATUS_COMPLETED, 'AND', true);
        $srch->addMultipleFields(array('txn.utxn_user_id as userId', "SUM(utxn_credit - utxn_debit) as user_balance"));
        $qryUserBalance = $srch->getQuery();

        $this->joinTable('(' . $qryUserBalance . ')', 'LEFT OUTER JOIN', 'tu.user_id = tqub.userId', 'tqub');
    }


    public static function getWithDrawalSpecifics($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            return false;
        }
        $srch = new SearchBase(User::DB_TBL_USR_WITHDRAWAL_REQ_SPEC, User::DB_TBL_USR_WITHDRAWAL_REQ_SPEC_PREFIX);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition(User::DB_TBL_USR_WITHDRAWAL_REQ_SPEC_PREFIX . 'withdrawal_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        $srch->addMultipleFields(
            array('uwrs_key', 'uwrs_value')
        );
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $withdrawalSpecifics = [];
        if (!empty($records)) {
            foreach ($records as $val) {
                $withdrawalSpecifics[$val["uwrs_key"]] = $val["uwrs_value"];
            }
        }
        return $withdrawalSpecifics;
    }
}
