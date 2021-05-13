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

    public function includeTransactionBalance($excludePendingWidrawReq = true, $excludePromotion = true, $excludeProcessedWidrawReq = true)
    {
        $srch = Transactions::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('utxn.utxn_user_id');
        $srch->addMultipleFields(array('utxn.utxn_user_id', 'SUM(utxn_credit - utxn_debit) as walletAmount'));
        if (0 < $this->userId) {
            $srch->addCondition('utxn.utxn_user_id', '=', $this->userId);
        }
        $srch->addCondition('utxn_status', '=', Transactions::STATUS_COMPLETED);

        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = tqub.utxn_user_id', 'tqub');

        $userBalance = 'tqub.walletAmount';
        if ($excludePendingWidrawReq) {
            $this->includePendingWithdrawReq($excludeProcessedWidrawReq);
            $userBalance .= ' - wrqb.pendingWithdrawalAmount';
        }

        if ($excludePromotion) {
            $this->includePromotionWalletToBeCharged();
            $userBalance .= ' - pmCharge.pendingPromotionCost';
        }

        $this->addFld('(' . $userBalance . ') as availableBalance');
    }

    public function includePromotionWalletToBeCharged()
    {
        $srch = new PromotionSearch();
        $srch->joinPromotionCharge();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        if (0 < $this->userId) {
            $srch->addCondition('pr.promotion_user_id', '=', $this->userId);
        }
        $srch->addGroupBy('pr.promotion_id');
        $srch->addMultipleFields(['pr.promotion_id', 'IFNULL(MAX(pcharge_end_piclick_id),0) as endClickId', 'IFNULL(MAX(pcharge_end_date),"0000-00-00") as chargeTillDate']);

        $prChargeSummary = new SearchBase(Promotion::DB_TBL_ITEM_CHARGES, 'pci');
        $prChargeSummary->joinTable(Promotion::DB_TBL_CLICKS, 'LEFT JOIN', 'pcl.pclick_id=pci.picharge_pclick_id', 'pcl');
        $prChargeSummary->joinTable(Promotion::DB_TBL, 'LEFT JOIN', 'p.promotion_id=pcl.pclick_promotion_id', 'p');

        $prChargeSummary->joinTable('(' . $srch->getQuery() . ')', 'INNER JOIN', 'p.promotion_id = pcs.promotion_id and pci.picharge_id > pcs.endClickId', 'pcs');
        $prChargeSummary->addGroupBy('p.promotion_user_id');
        $prChargeSummary->addMultipleFields(['p.promotion_user_id', 'sum(picharge_cost) as pendingPromotionCost']);
        $prChargeSummary->doNotLimitRecords();
        $prChargeSummary->doNotCalculateRecords();

        $this->joinTable('(' . $prChargeSummary->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = pmCharge.promotion_user_id', 'pmCharge');
    }

    public function includePendingWithdrawReq($excludeProcessedWidrawReq = true)
    {
        $wrSrch = new WithdrawalRequestsSearch();
        $wrSrch->doNotCalculateRecords();
        $wrSrch->doNotLimitRecords();
        $wrSrch->addGroupBy('tuwr.withdrawal_user_id');
        $wrSrch->addMultipleFields(array('tuwr.withdrawal_user_id', 'SUM(withdrawal_amount) as pendingWithdrawalAmount'));
        if (0 < $this->userId) {
            $wrSrch->addCondition('withdrawal_user_id', '=', $this->userId);
        }

        $cnd = $wrSrch->addCondition('withdrawal_status', '=', Transactions::WITHDRAWL_STATUS_PENDING);
        if (true == $excludeProcessedWidrawReq) {
            $cnd->attachCondition('withdrawal_status', '=', Transactions::WITHDRAWL_STATUS_PROCESSED);
        }
        $this->joinTable('(' . $wrSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = wrqb.withdrawal_user_id', 'wrqb');
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

    public function includePromotionCharges()
    {
        $srch = new SearchBase(Promotion::DB_TBL_CHARGES, 'pc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('pcharge_user_id');
        $srch->addMultipleFields(['pc.pcharge_user_id', 'SUM(pc.pcharge_charged_amount) as promotionCharged']);
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = pchagres.pcharge_user_id', 'pchagres');
    }

    public function addRatingsCount()
    {
        $srch = new SelProdReviewSearch();
        $srch->joinSeller();
        $srch->joinSellerProducts();
        $srch->joinSelProdRating();
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        $srch->addMultipleFields(array('ROUND(AVG(sprating_rating),2) as avg_rating', 'spreview_seller_user_id'));
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN `ratingtype_type` IN('" . RatingType::TYPE_SHOP . "', '" . RatingType::RATING_DELIVERY . "') ELSE `ratingtype_type` = '" . RatingType::TYPE_SHOP . "' END)");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $srch->addGroupby('spreview_seller_user_id');

        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'sprating.spreview_seller_user_id = u.user_id', 'sprating');
        $this->addFld('IFNULL(sprating.avg_rating, 0) as totRating');
    }
}
