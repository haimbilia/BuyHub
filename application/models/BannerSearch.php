<?php

class BannerSearch extends SearchBase
{
    private $langId;
    private $joinedPromotion = false;
    private $joinedUserWallet = false;

    public function __construct($langId = 0, $isActive = true)
    {
        $this->langId = FatUtility::int($langId);
        parent::__construct(Banner::DB_TBL, 'b');

        if ($langId > 0) {
            $this->joinTable(
                Banner::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'b_l.bannerlang_banner_id = b.banner_id
			AND b_l.bannerlang_lang_id = ' . $langId,
                'b_l'
            );
        }

        if ($isActive) {
            $this->addCondition('b.banner_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        }
    }

    public function setDefinedCriteria()
    {
        $this->addCondition('promotion_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
    }

    public function joinLocations($langId = 0, $joinCollection = false)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }

        $this->joinTable(Banner::DB_TBL_LOCATIONS, 'LEFT OUTER JOIN', 'bl.blocation_id = b.banner_blocation_id', 'bl');
        if ($langId > 0) {
            $this->joinTable(Banner::DB_TBL_LANG_LOCATIONS, 'LEFT OUTER JOIN', 'bl_l.blocationlang_blocation_id = bl.blocation_id AND bl_l.blocationlang_lang_id = ' . $langId, 'bl_l');
        }

        if ($joinCollection) {
            $this->joinTable(Collections::DB_TBL, 'LEFT OUTER JOIN', 'c.collection_id = bl.blocation_collection_id', 'c');
        }
    }

    public function joinCollectionToRecords()
    {
        $this->joinTable(Collections::DB_TBL_COLLECTION_TO_RECORDS, 'LEFT OUTER JOIN', 'ctr.ctr_record_id = b.banner_id', 'ctr');
    }

    public function joinLocationDimension($deviceType = 0)
    {
        $deviceType = FatUtility::int($deviceType);
        if (1 > $deviceType) {
            $deviceType = applicationConstants::SCREEN_DESKTOP;
        }
        $this->joinTable(BannerLocation::DB_DIMENSIONS_TBL, 'LEFT OUTER JOIN', 'bldim.bldimension_blocation_id = bl.blocation_id AND bldim.bldimension_device_type = ' . $deviceType, 'bldim');
    }

    public function joinPromotions($langId = 0, $activeOnly = true, $approvedOnly = true, $deleted = true)
    {
        $this->joinedPromotion = true;
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }

        if ($activeOnly) {
            $this->addFld(array('IF(pr.promotion_id > 0, promotion_active,1) AS promotionActive'));
            $this->addHaving('promotionActive', '=', applicationConstants::ACTIVE);
        }

        if ($approvedOnly) {
            $this->addFld(array('IF(pr.promotion_id > 0, promotion_approved,1) AS promotionApproved'));
            $this->addHaving('promotionApproved', '=', applicationConstants::YES);
        }

        if ($deleted) {
            $this->addFld(array('IF(pr.promotion_id > 0, promotion_deleted,0) AS promotionDeleted'));
            $this->addHaving('promotionDeleted', '=', applicationConstants::NO);
        }



        $this->joinTable(Promotion::DB_TBL, 'LEFT OUTER JOIN', 'pr.promotion_id = b.banner_record_id and b.banner_type = ' . Banner::TYPE_PPC, 'pr');
        if ($langId > 0) {
            $this->joinTable(Promotion::DB_TBL_LANG, 'LEFT OUTER JOIN', 'pr_l.promotionlang_promotion_id = pr.promotion_id AND pr_l.promotionlang_lang_id = ' . $langId, 'pr_l');
        }
    }

    public function joinActiveUser($isActive = true)
    {
        //$this->joinTable( User::DB_TBL, 'LEFT JOIN', 'pr.promotion_user_id = u.user_id', 'u' );
        $this->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'cu.credential_user_id = pr.promotion_user_id', 'cu');
        if ($isActive) {
            $this->addFld(array('IF(pr.promotion_id > 0, credential_active,1) AS credential_active'));
            $this->addHaving('credential_active', '=', applicationConstants::ACTIVE);
        }
    }

    public function addSkipExpiredPromotionAndBannerCondition($langId = 0)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }

        if (!$this->joinedPromotion) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_PROMOTIONS', $langId), E_USER_ERROR);
        }



        $this->addFld(array('if(b.banner_type = ' . Banner::TYPE_PPC . ',pr.promotion_start_date,b.banner_start_date) as start_date'));

        $this->addFld(array('if(b.banner_type = ' . Banner::TYPE_PPC . ',pr.promotion_end_date,b.banner_end_date) as end_date'));

        $this->addFld(array('if(b.banner_type = ' . Banner::TYPE_PPC . ',pr.promotion_start_time,b.banner_start_time) as start_time'));
        $this->addFld(array('if(b.banner_type = ' . Banner::TYPE_PPC . ',pr.promotion_end_time,b.banner_end_time) as end_time'));

        $this->addFld(array('if(b.banner_type = ' . Banner::TYPE_PPC . ',pr.promotion_duration,' . Promotion::DURATION_NOT_AVAILABALE . ') as promotion_duration'));
        $this->addFld(array('if(b.banner_type = ' . Banner::TYPE_PPC . ',pr.promotion_budget,-1) as promotion_budget'));



        $cnd = $this->addHaving('start_date', '=', '0000-00-00 00:00:00');
        $cnd->attachCondition('start_date', '<=', date('Y-m-d 00:00:00'), 'OR');

        $cnd = $this->addHaving('end_date', '=', '0000-00-00 00:00:00');
        $cnd->attachCondition('end_date', '>=', date('Y-m-d 00:00:00'), 'OR');


        $cnd = $this->addHaving('start_time', '=', '00:00:00');
        $cnd->attachCondition('start_time', '<=', date('H:i:s'), 'OR');

        $cnd = $this->addHaving('end_time', '=', '00:00:00');
        $cnd->attachCondition('end_time', '>=', date('H:i:s'), 'OR');
    }


    public function addActiveLocationCondition()
    {
        $this->addCondition('bl.blocation_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
    }

    public function addActivePromotionCondition()
    {
        $this->addCondition('pr.promotion_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
    }

    public function addApprovedPromotionCondition()
    {
        $this->addCondition('pr.promotion_approved', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
    }
    public function addPromotionTypeCondition()
    {
        $cnd = $this->addCondition('pr.promotion_type', '=', 'mysql_func_' . Promotion::TYPE_BANNER, 'AND', true);
        $cnd->attachCondition('banner_type', '=', 'mysql_func_' . Banner::TYPE_BANNER, 'OR', true);
    }

    public function joinUserWallet($excludePendingWidrawReq = true, $excludePromotion = true, $excludeProcessedWidrawReq = true)
    {
        $this->joinedUserWallet = true;
        $srch = Transactions::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('utxn.utxn_user_id');
        $srch->addMultipleFields(array('utxn.utxn_user_id', 'SUM(utxn_credit - utxn_debit) as walletAmount'));
        $srch->addCondition('utxn_status', '=', 'mysql_func_' . Transactions::STATUS_COMPLETED, 'AND', true);

        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'pr.promotion_user_id = tqub.utxn_user_id', 'tqub');

        $userBalance = 'tqub.walletAmount';
        if ($excludePendingWidrawReq) {
            $this->includePendingWithdrawReq($excludeProcessedWidrawReq);
            $userBalance .= ' - IFNULL(pendingWithdrawalAmount,0)';
        }

        if ($excludePromotion) {
            $this->includePromotionWalletToBeCharged();
            $userBalance .= ' - IFNULL(pmCharge.pendingPromotionCost,0)';
        }

        $this->addFld(array('IF(pr.promotion_id > 0, ' . $userBalance . ' ,' . FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE') . ') AS userBalance'));
        $this->addHaving('userBalance', '>=', FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE'));
    }

    public function includePromotionWalletToBeCharged()
    {
        $srch = new PromotionSearch();
        $srch->joinPromotionCharge();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
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

        $this->joinTable('(' . $prChargeSummary->getQuery() . ')', 'LEFT OUTER JOIN', 'pr.promotion_user_id = pmCharge.promotion_user_id', 'pmCharge');
    }

    public function includePendingWithdrawReq($excludeProcessedWidrawReq = true)
    {
        $wrSrch = new WithdrawalRequestsSearch();
        $wrSrch->doNotCalculateRecords();
        $wrSrch->doNotLimitRecords();
        $wrSrch->addGroupBy('tuwr.withdrawal_user_id');
        $wrSrch->addMultipleFields(array('tuwr.withdrawal_user_id', 'SUM(withdrawal_amount) as pendingWithdrawalAmount'));
        $cnd = $wrSrch->addCondition('withdrawal_status', '=', 'mysql_func_' . Transactions::WITHDRAWL_STATUS_PENDING, 'AND', true);
        if (true == $excludeProcessedWidrawReq) {
            $cnd->attachCondition('withdrawal_status', '=', 'mysql_func_' . Transactions::WITHDRAWL_STATUS_PROCESSED, 'OR', true);
        }
        $this->joinTable('(' . $wrSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'pr.promotion_user_id = wrqb.withdrawal_user_id', 'wrqb');
    }

    public function joinBudget()
    {
        $srch = new SearchBase(Promotion::DB_TBL_ITEM_CHARGES, 'tpic');
        $srch->joinTable(Promotion::DB_TBL_CLICKS, 'LEFT OUTER JOIN', 'tpc.' . Promotion::DB_TBL_CLICKS_PREFIX . 'id = tpic.' . Promotion::DB_TBL_ITEM_CHARGES_PREFIX . 'pclick_id', 'tpc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('tpc.' . Promotion::DB_TBL_CLICKS_PREFIX . 'promotion_id');
        $srch->addMultipleFields(
            array(
                'tpc.pclick_promotion_id',
                "SUM(IF(date(`picharge_datetime`)>CURRENT_DATE - INTERVAL 1 DAY,`picharge_cost`,0)) daily_cost,
			SUM(IF(date(`picharge_datetime`)>CURRENT_DATE - INTERVAL 1 WEEK,`picharge_cost`,0)) weekly_cost,
			SUM(IF(date(`picharge_datetime`)>CURRENT_DATE - INTERVAL 1 MONTH,`picharge_cost`,0)) monthly_cost",
                "SUM(picharge_cost) as total_cost"
            )
        );

        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'pr.promotion_id =pclick_promotion_id', 'pcb');
    }

    public function joinAttachedFile()
    {
        $this->joinTable(AttachedFile::DB_TBL, 'INNER  JOIN', 'af.afile_record_id = b.banner_id and afile_type =' . AttachedFile::FILETYPE_BANNER, 'af');
        $this->addGroupBy('banner_id');
    }
}
