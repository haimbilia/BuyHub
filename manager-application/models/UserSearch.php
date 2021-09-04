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

        $userBalance = 'ifnull(tqub.walletAmount, 0)';
        if ($excludePendingWidrawReq) {
            $this->includePendingWithdrawReq($excludeProcessedWidrawReq);
            $userBalance .= ' - ifnull(wrqb.pendingWithdrawalAmount, 0)';
        }

        if ($excludePromotion) {
            $this->includePromotionWalletToBeCharged();
            $userBalance .= ' - ifnull(pmCharge.pendingPromotionCost, 0)';
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
        $prChargeSummary->addMultipleFields(['p.promotion_user_id', 'sum(IFNULL(picharge_cost, 0)) as pendingPromotionCost']);
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

    public function includeAffiliateUserRevenue()
    {
        $srch = Transactions::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('utxn.utxn_user_id');
        $cnd = $srch->addCondition('utxn_type', '=', Transactions::TYPE_AFFILIATE_REFERRAL_SIGN_UP);
        $cnd->attachCondition('utxn_type', '=', Transactions::TYPE_AFFILIATE_REFERRAL_ORDER);
        $srch->addMultipleFields(array('utxn.utxn_user_id', 'SUM(utxn_credit) as totAffilateRevenue', 'SUM(if(utxn_type = ' . Transactions::TYPE_AFFILIATE_REFERRAL_SIGN_UP . ',utxn_credit,0)) as totAffilateSignupRevenue', 'SUM(if(utxn_type = ' . Transactions::TYPE_AFFILIATE_REFERRAL_ORDER . ',utxn_credit,0)) as totAffilateOrdersRevenue'));
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = afRev.utxn_user_id', 'afRev');
    }

    public function includeAffiliateUsersCount()
    {
        $srch = User::getSearchObject(true, 0, false);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('u.user_affiliate_referrer_user_id');
        $srch->addMultipleFields(array('user_affiliate_referrer_user_id', 'COUNT(user_id) as totAffiliatedUsers'));
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = afUsr.user_affiliate_referrer_user_id', 'afUsr');
    }

    public function includePromotionCharges()
    {
        $srch = new SearchBase(Promotion::DB_TBL_CHARGES, 'pc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('pcharge_user_id');
        $srch->addMultipleFields(['pc.pcharge_user_id', 'SUM(IFNULL(pc.pcharge_charged_amount, 0)) as promotionCharged']);
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = pchagres.pcharge_user_id', 'pchagres');
    }

    public function includePromotionsCount()
    {
        $srch = new PromotionSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('promotion_deleted', '=', applicationConstants::NO);
        $srch->addCondition('promotion_approved', '=', applicationConstants::YES);
        if (0 < $this->userId) {
            $srch->addCondition('pr.promotion_user_id', '=', $this->userId);
        }
        $currDate = date('Y-m-d');
        $currTime = date('H:i');
        $activeCond = '(promotion_start_date <= "' . $currDate . '" and (promotion_end_date >= "' . $currDate . '" or promotion_end_date = "0000-00-00"))';
        $activeCond .= ' and (promotion_start_time <= "' . $currTime . '" and (promotion_end_time >= "' . $currTime . '" or promotion_end_time = "00:00")) and promotion_active > 0';

        $srch->addMultipleFields(['pr.promotion_user_id', 'count(promotion_id) as promotionsCount', 'count(if(' . $activeCond . ',1,null)) as activePromotions']);
        $srch->addGroupBy('pr.promotion_user_id');
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = promocount.promotion_user_id', 'promocount');
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
