<?php

class UserSearch extends SearchBase
{
    private $userId = 0;
    public function __construct($joinCredentials = true, $userId = 0, $skipDeleted = false)
    {
        parent::__construct(User::DB_TBL, 'u');

        if ($joinCredentials) {
            $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'uc.' . User::DB_TBL_CRED_PREFIX . 'user_id = u.user_id', 'uc');
        }

        if ($skipDeleted == true) {
            $this->addCondition('user_deleted', '=', applicationConstants::NO);
        }

        $this->userId = $userId;
    }

    public function includeTransactionBalance()
    {
        $srch = Transactions::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('utxn.utxn_user_id');
        $srch->addMultipleFields(array('utxn.utxn_user_id', "SUM(utxn_credit - utxn_debit) as userBalance"));
        if (0 < $this->userId) {
            $srch->addCondition('utxn.utxn_user_id', '=', $this->userId);
        }
        $srch->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = tqub.utxn_user_id', 'tqub');
    }
}
