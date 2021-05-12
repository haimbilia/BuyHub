<?php

class UserSearch extends SearchBase
{
    private $userId = 0;
    private $langId = 0;
    public function __construct(int $langId = 0, $joinCredentials = true, $userId = 0, $skipDeleted = true)
    {
        parent::__construct(User::DB_TBL, 'u');

        if ($joinCredentials) {
            $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'uc.' . User::DB_TBL_CRED_PREFIX . 'user_id = u.user_id', 'uc');
        }

        if ($skipDeleted == true) {
            $this->addCondition('u.user_deleted', '=', applicationConstants::NO);
        }

        $this->userId = $userId;
        $this->langId = $langId;
    }


    public function joinReferrerUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'uref.user_id = u.user_referrer_user_id', 'uref');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'uref_c.' . User::DB_TBL_CRED_PREFIX . 'user_id = uref.user_id', 'uref_c');
    }

    public function includeTransactionBalance($excludePendingWidrawReq = true, $excludePromotion = true)
    {
        $srch = Transactions::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('utxn.utxn_user_id');
        $srch->addMultipleFields(array('utxn.utxn_user_id', "SUM(utxn_credit - utxn_debit) as userBalance"));
        if (0 < $this->userId) {
            $srch->addCondition('utxn.utxn_user_id', '=', $this->userId);
        }
        
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = tqub.utxn_user_id', 'tqub');
    }

    public function includeRewardsCount()
    {
        $srch = new UserRewardSearch();
        $srch->joinUserRewardBreakup();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('urp.urp_user_id');
        $srch->addMultipleFields(['urp.urp_user_id', 'sum(if(urpb.urpbreakup_used = 1, urpbreakup_points,0)) as rewardsPointsRedeemed', 'SUM(urpb.urpbreakup_points) as rewardsPointsEarned', 'sum(if(urpb.urpbreakup_used = 0 and (urp_date_expiry = "0000-00-00" or urp_date_expiry >= ' . date('Y-m-d') . '), urpbreakup_points,0)) as rewardsPoints']);
        if (0 < $this->userId) {
            $srch->addCondition('urp.urp_user_id', '=', $this->userId);
        }
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = urpbal.urp_user_id', 'urpbal');
    }
}
