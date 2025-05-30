<?php

class Promotion extends MyAppModel
{
    public const DB_TBL = 'tbl_promotions';
    public const DB_TBL_PREFIX = 'promotion_';

    public const DB_TBL_LANG = 'tbl_promotions_lang';

    public const DB_TBL_CLICKS = 'tbl_promotions_clicks';
    public const DB_TBL_CLICKS_PREFIX = 'pclick_';

    public const DB_TBL_CHARGES = 'tbl_promotions_charges';
    public const DB_TBL_CHARGES_PREFIX = 'pcharge_';

    public const DB_TBL_ITEM_CHARGES = 'tbl_promotion_item_charges';
    public const DB_TBL_ITEM_CHARGES_PREFIX = 'picharge_';

    public const DB_TBL_LOGS = 'tbl_promotions_logs';
    public const DB_TBL_LOGS_PREFIX = 'plog_';

    public const TYPE_SHOP = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_BANNER = 3;
    public const TYPE_SLIDES = 4;

    public const DAILY = 0;
    public const WEEKLY = 1;
    public const MONTHLY = 2;
    public const DURATION_NOT_AVAILABALE = 4;

    public const REDIRECT_SHOP = 1;
    public const REDIRECT_PRODUCT = 2;
    public const REDIRECT_CATEGORY = 3;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields(
            array(
            )
        );
    }

    public static function getSearchObject($langId = 0, $activeOnly = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'pr');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'pr_l.promotionlang_promotion_id = pr.promotion_id
			AND pr_l.promotionlang_lang_id = ' . $langId,
                'pr_l'
            );
        }

        if ($activeOnly) {
            $srch->addCondition('promotion_active', '=', applicationConstants::ACTIVE);
        }

        return $srch;
    }

    public static function getTypeArr($langId, $displayAdvertiserOnly = false)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        $arr = array(
        static::TYPE_BANNER => Labels::getLabel('LBL_BANNER', $langId),
        static::TYPE_SLIDES => Labels::getLabel('LBL_SLIDES', $langId),
        );

        if ($displayAdvertiserOnly) {
            return     $arr;
        }

        return array(
        static::TYPE_SHOP => Labels::getLabel('LBL_SHOP', $langId),
        static::TYPE_PRODUCT => Labels::getLabel('LBL_PRODUCT', $langId),
        static::TYPE_BANNER => Labels::getLabel('LBL_BANNER', $langId),
        static::TYPE_SLIDES => Labels::getLabel('LBL_SLIDES', $langId),
        );
    }

    public static function updateImpressionData($promotionId = 0)
    {
        if (1 > $promotionId) {
            return;
        }

        $bannerLogData = array(
        'plog_promotion_id' => $promotionId,
        'plog_date' => date('Y-m-d'),
        'plog_impressions' => 1,
        );

        $onDuplicateBannerLogData = array_merge($bannerLogData, array('plog_impressions' => 'mysql_func_plog_impressions+1'));
        FatApp::getDb()->insertFromArray(static::DB_TBL_LOGS, $bannerLogData, true, array(), $onDuplicateBannerLogData);
    }

    public static function getPromotionCostPerClick(int $promotionType, int $blocation_id = 0): string
    {
        switch ($promotionType) {
            case PROMOTION::TYPE_SHOP:
                return FatApp::getConfig('CONF_CPC_SHOP');
             break;
            case PROMOTION::TYPE_PRODUCT:
                return FatApp::getConfig('CONF_CPC_PRODUCT');
             break;
            case PROMOTION::TYPE_SLIDES:
                return FatApp::getConfig('CONF_CPC_SLIDES');
             break;
            case PROMOTION::TYPE_BANNER:
                $srch = Banner::getBannerLocationSrchObj();
                $srch->addCondition('blocation_id', '=', $blocation_id);
                $srch->addFld('blocation_promotion_cost');
                $srch->doNotCalculateRecords();
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);
                if ($row && array_key_exists('blocation_promotion_cost', $row)) {
                    return $row['blocation_promotion_cost'];
                }
                return 0;
             break;
        }
    }

    public function getPromotionLastChargedEntry(int $promotionId = 0): array
    {
        $promotionId = FatUtility::int($promotionId);
        if (1 > $promotionId) {
            return array();
        }
        $srch = new SearchBase(Promotion::DB_TBL_CHARGES, 'tpc');
        $srch->addCondition('tpc.' . Promotion::DB_TBL_CHARGES_PREFIX . 'promotion_id', '=', $promotionId);
        $srch->addOrder('tpc.' . Promotion::DB_TBL_CHARGES_PREFIX . 'id', 'desc');
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if ($row == false) {
            return array();
        } else {
            return $row;
        }
    }

    public static function getTotalChargedAmount(int $userId, bool $active = false)
    {
        $srch = new SearchBase(Promotion::DB_TBL_CHARGES, 'tpc');
        $srch->addCondition('tpc.' . Promotion::DB_TBL_CHARGES_PREFIX . 'user_id', '=', $userId);
        $srch->addFld("SUM(pcharge_charged_amount) totChargedAmount");
        if ($active) {
            $srch->joinTable(Promotion::DB_TBL, 'LEFT JOIN', 'tpc. pcharge_promotion_id=p.promotion_id', 'p');
            $srch->addCondition('promotion_active', '=', applicationConstants::ACTIVE);
            $srch->addCondition('promotion_end_date', '>', date("Y-m-d"));
            $srch->addCondition('promotion_approved', '=', applicationConstants::YES);
            $srch->addCondition('promotion_deleted', '=', applicationConstants::NO);
        }
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $result = FatApp::getDb()->fetch($rs);
        $totChargedAmount = $result['totChargedAmount'];
        return $totChargedAmount;
    }

    public function addUpdatePromotionCharges($data, $langId)
    {
        $pchargeUserId = FatUtility::int($data['user_id']);
        $pchargePromotionId = FatUtility::int($data['promotion_id']);
        $chargedAmount = $data['total_cost'];
        if (($pchargeUserId < 1) || ($pchargePromotionId < 1) || ($chargedAmount <= 0)) {
            return array();
        }

        $record = new TableRecord(Promotion::DB_TBL_CHARGES);

        $dataToSave = array();
        $dataToSave['pcharge_user_id'] = $pchargeUserId;
        $dataToSave['pcharge_promotion_id'] = $pchargePromotionId;
        $dataToSave['pcharge_charged_amount'] = $chargedAmount;
        $dataToSave['pcharge_clicks'] = $data['total_clicks'];
        $dataToSave['pcharge_date'] = date("Y-m-d H:i:s");
        $dataToSave['pcharge_start_piclick_id'] = $data['start_click_id'];
        $dataToSave['pcharge_end_piclick_id'] = $data['end_click_id'];
        $dataToSave['pcharge_start_date'] = $data['start_click_date'];
        $dataToSave['pcharge_end_date'] = $data['end_click_date'];
        $record->assignValues($dataToSave);

        if ($record->addNew()) {
            $this->charge_log_id = $record->getId();

            $transObj = new Transactions();
            $formatted_request_value = "#" . str_pad($pchargePromotionId, 6, '0', STR_PAD_LEFT);
            $txnArray["utxn_user_id"] = $pchargeUserId;
            $txnArray["utxn_debit"] = $chargedAmount;
            $txnArray["utxn_credit"] = 0;
            $txnArray["utxn_status"] = Transactions::STATUS_COMPLETED;
            $txnArray["utxn_type"] = Transactions::TYPE_PPC;

            $txnArray["utxn_comments"] = sprintf(Labels::getLabel('MSG_CHARGES_FOR_PROMOTION_FROM_DURATION', $langId), $formatted_request_value, $dataToSave['pcharge_start_date'], $dataToSave['pcharge_end_date'], $dataToSave['pcharge_clicks']);
            if ($txnId = $transObj->addTransaction($txnArray)) {
                $emailNotificationObj = new EmailHandler();

                $emailNotificationObj->sendTxnNotification($txnId, $langId);
            }
        } else {
            $this->error = $this->db->getError();
            return false;
        }
        return $this->charge_log_id;
    }

    public static function getPromotionBudgetDurationArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
        static::DAILY => Labels::getLabel('LBL_DAILY_BASIS', $langId),
        static::WEEKLY => Labels::getLabel('LBL_WEEKLY_BASIS', $langId),
        static::MONTHLY => Labels::getLabel('LBL_MONTHLY_BASIS', $langId)
        );
    }

    public static function isUserClickCountable($userId, $promotionId, $ip, $session)
    {
        $srch = new SearchBase(PROMOTION::DB_TBL_CLICKS);
        $srch->addCondition(PROMOTION::DB_TBL_CLICKS_PREFIX . 'promotion_id', '=', $promotionId);
        $srch->addCondition(PROMOTION::DB_TBL_CLICKS_PREFIX . 'user_id', '=', $userId);
        $srch->addCondition(PROMOTION::DB_TBL_CLICKS_PREFIX . 'datetime', '>=', date('Y-m-d H:i:s', strtotime("-" . FatApp::getConfig('CONF_PPC_CLICK_COUNT_TIME_INTERVAL') . " Minute")));
        $srch->addCondition(PROMOTION::DB_TBL_CLICKS_PREFIX . 'ip', '=', $ip);
        $srch->addCondition(PROMOTION::DB_TBL_CLICKS_PREFIX . 'session_id', '=', $session);
        $srch->doNotCalculateRecords();
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return ($row == false);
    }
    public static function getPromotionReqStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            trigger_error(Labels::getLabel('ERR_LANGUAGE_ID_NOT_SPECIFIED.', $langId), E_USER_ERROR);
        }
        $arr = array(

        applicationConstants::YES => Labels::getLabel('LBL_APPROVED', $langId),

        );
        return $arr;
    }

    public static function getPromotionWalleToBeCharged($user_id)
    {
        $prmSrch = new PromotionSearch();
        $prmSrch->joinPromotionCharge();
        $prmSrch->addGroupBy('promotion_id');
        $prmSrch->addCondition('pr.promotion_user_id', '=', $user_id);
        //$prmSrch->addLastChargeCondition();
        $prmSrch->addMultipleFields(array('promotion_id', 'promotion_user_id ', "IFNULL(MAX(pcharge_end_piclick_id),0) as end_click_id", "IFNULL(MAX(pcharge_end_date),'0000-00-00') as charge_till_date"));
        $prmSrch->doNotCalculateRecords();
        $rs = $prmSrch->getResultSet();
        $promotions = FatApp::getDb()->fetchAll($rs);

        $promotionCharges = 0;
        foreach ($promotions as $pKey => $pVal) {
            $promotionId = $pVal['promotion_id'];
            $prChargeSummary = new SearchBase(Promotion::DB_TBL_ITEM_CHARGES, 'pci');
            $prChargeSummary->joinTable(Promotion::DB_TBL_CLICKS, 'LEFT JOIN', 'pcl.pclick_id=pci.picharge_pclick_id', 'pcl');
            $prChargeSummary->joinTable(Promotion::DB_TBL, 'LEFT JOIN', 'p.promotion_id=pcl.pclick_promotion_id', 'p');
            $prChargeSummary->addCondition('promotion_id', '=', $promotionId);
            $prChargeSummary->addCondition('picharge_id', '>', $pVal['end_click_id']);
            $prChargeSummary->addMultipleFields(
                array("sum(picharge_cost) as total_cost", "min(picharge_id) as start_click_id", "max(picharge_id) as end_click_id", "MIN(picharge_datetime) as start_click_date",
                "MAX(picharge_datetime) as end_click_date",    "count(picharge_id) as total_clicks", )
            );
            $prChargeSummary->doNotCalculateRecords();
            $prChargeSummary->addGroupBy('pclick_promotion_id');            
            $rs = $prChargeSummary->getResultSet();
            $promotionClicks = FatApp::getDb()->fetch($rs);


            if ($promotionClicks) {
                // Get User Wallet Balance
                // $userId = $pVal['promotion_user_id'];
                /* $txnObj = new Transactions();
                $accountSummary = $txnObj->getTransactionSummary($userId); */
                //$balance = $accountSummary['total_earned'] - $accountSummary['total_used'];

                if ($promotionClicks) {
                    $promotionCharges += $promotionClicks['total_cost'];
                }
            }
        }

        return $promotionCharges;
    }
}
