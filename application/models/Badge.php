<?php

class Badge extends MyAppModel
{
    public const DB_TBL = 'tbl_badges';
    public const DB_TBL_PREFIX = 'badge_';

    public const DB_TBL_LANG = 'tbl_badges_lang';
    public const DB_TBL_LANG_PREFIX = 'badgelang_';

    public const TYPE_BADGE = 1;
    public const TYPE_RIBBON = 2;

    /* Used in case of Ribbons */
    public const SHAPE_RECTANGLE = 1;
    public const SHAPE_STRIP = 2;
    public const SHAPE_STAR = 3;
    public const SHAPE_TRIANGLE = 4;
    public const SHAPE_CIRCLE = 5;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'type',
        self::DB_TBL_PREFIX . 'trigger_type',
        self::DB_TBL_PREFIX . 'shape_type',
        self::DB_TBL_PREFIX . 'display_inside',
        self::DB_TBL_PREFIX . 'color',
        self::DB_TBL_PREFIX . 'identifier',
        self::DB_TBL_PREFIX . 'required_approval',
        self::DB_TBL_PREFIX . 'active',
        self::DB_TBL_PREFIX . 'added_on',
        self::DB_TBL_PREFIX . 'updated_on',
    ];

    public const LANG_ATTR = [
        self::DB_TBL_LANG_PREFIX . 'lang_id',
        self::DB_TBL_PREFIX . 'name'
    ];

    public const ICON_MIN_WIDTH = 26;
    public const ICON_MIN_HEIGHT = 26;

    /* For Ribbon */
    public const RIBB_TEXT_MIN_LEN = 2;
    public const RIBB_TEXT_MAX_LEN = 10;

    public const RIBB_POS_TRIGHT = 1;
    public const RIBB_POS_TLEFT = 2;
    /* For Ribbon */

    public const REMOVED_OLD_IMAGE_TIME = 4;

    public const APPROVAL_REQUIRED = 1;
    public const APPROVAL_OPEN = 0;

    public const COND_MANUAL = 1;
    public const COND_AUTO = 2;

    /**
     * __construct
     *
     * @param  int $ratingTypeId
     * @return void
     */
    public function __construct(int $ratingTypeId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $ratingTypeId);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
    }

    /**
     * getTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getTypeArr(int $langId): array
    {
        $arr = CacheHelper::get('getBadgeTypeArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::TYPE_BADGE => Labels::getLabel('LBL_BADGE', $langId),
                self::TYPE_RIBBON => Labels::getLabel('LBL_RIBBON', $langId)
            ];
            CacheHelper::create('getBadgeTypeArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getTriggerCondTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getTriggerCondTypeArr(int $langId): array
    {
        $arr = CacheHelper::get('getBadgeConditionTypeArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::COND_MANUAL => Labels::getLabel('LBL_MANUAL', $langId),
                self::COND_AUTO => Labels::getLabel('LBL_AUTOMATIC', $langId)
            ];
            CacheHelper::create('getBadgeConditionTypeArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getShapeTypesArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getShapeTypesArr(int $langId): array
    {
        $arr = CacheHelper::get('getBadgeShapeTypesArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::SHAPE_RECTANGLE => Labels::getLabel('LBL_RECTANGLE', $langId),
                self::SHAPE_STRIP => Labels::getLabel('LBL_STRIP', $langId),
                self::SHAPE_STAR => Labels::getLabel('LBL_STAR', $langId),
                self::SHAPE_TRIANGLE => Labels::getLabel('LBL_TRIANGLE', $langId),
                self::SHAPE_CIRCLE => Labels::getLabel('LBL_CIRCLE', $langId),
            ];
            CacheHelper::create('getBadgeShapeTypesArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getRibbonPostionArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getRibbonPostionArr(int $langId): array
    {
        $arr = CacheHelper::get('getRibbonPostionArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::RIBB_POS_TRIGHT => Labels::getLabel("LBL_TOP_RIGHT", $langId),
                self::RIBB_POS_TLEFT => Labels::getLabel("LBL_TOP_LEFT", $langId),
            ];
            CacheHelper::create('getRibbonPostionArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getApprovalStatusArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getApprovalStatusArr(int $langId): array
    {
        $arr = CacheHelper::get('getBadgeApprovalStatusArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::APPROVAL_OPEN => Labels::getLabel('LBL_OPEN', $langId),
                self::APPROVAL_REQUIRED => Labels::getLabel('LBL_REQUIRED', $langId),
            ];
            CacheHelper::create('getBadgeApprovalStatusArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * deleteImagesWithOutBadgeId
     *
     * @return bool
     */
    public static function deleteImagesWithOutBadgeId(): bool
    {
        $currentDate = date('Y-m-d  H:i:s');
        $prevDate = strtotime('-' . static::REMOVED_OLD_IMAGE_TIME . ' hour', strtotime($currentDate));
        $prevDate = date('Y-m-d  H:i:s', $prevDate);
        $where = array('smt' => 'afile_type = ? AND afile_record_id = ? AND afile_updated_at <= ?', 'vals' => array(AttachedFile::FILETYPE_BADGE, 0, $prevDate));
        if (!FatApp::getDb()->deleteRecords(AttachedFile::DB_TBL, $where)) {
            return false;
        }
        return true;
    }

    /**
     * canAccess
     *
     * @param  mixed $badgeId
     * @param  mixed $userId
     * @return int
     */
    public static function canAccess(int $badgeId, int $userId): int
    {
        $srch = new BadgeSearch();
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'LEFT JOIN', 'blinkcond_badge_id = badge_id');
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id');
        $srch->addMultipleFields([
            self::DB_TBL_PREFIX . 'id',
            '(CASE
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_RIBBON . ' OR ' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_OPEN . '
                THEN 1
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_BADGE . ' AND ' . Badge::DB_TBL_PREFIX . 'trigger_type = ' . Badge::COND_AUTO . '
                THEN 0
                WHEN SUM(
                    IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED  . ' AND ' . BadgeLinkCondition::DB_TBL_PREFIX . 'id > 0 AND ' . BadgeRequest::DB_TBL_PREFIX . 'id IS NULL AND ' .  BadgeRequest::DB_TBL_PREFIX . 'user_id = ' . $userId . ', 1, 0)
                    ) > 0
                THEN 1
                WHEN SUM(
                    IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'status = ' . BadgeRequest::REQUEST_APPROVED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'user_id = ' . $userId . ', 1, 0)
                    ) > 0
                THEN 1
                ELSE 0
            END) as canAccess',
        ]);
        $srch->doNotCalculateRecords();
        $srch->addCondition(Badge::DB_TBL_PREFIX . 'id', '=', $badgeId);
        $record = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        return current($record);
    }

    public static function getRibbons(int $langId, int $position, array $selProdIdArr)
    {
        if (self::RIBB_POS_TLEFT == $position) {
            /* We can remove this condition when we need to use display ribbons on top left and right */
            return [];
        }
        $date = date('Y-m-d H:i:00');
        $srch = new BadgeLinkConditionSearch();
        $srch->setSelProdIdArr($selProdIdArr);
        $srch->joinBadges($langId, Badge::TYPE_RIBBON);
        $srch->joinBadgeLinks();
        $srch->joinProducts();
        $srch->joinSellerProducts();
        $srch->joinShops();
        $srch->doNotCalculateRecords();

        $srch->addMultipleFields(['blnk.blinkcond_id', 'blnk.blinkcond_badge_id', 'blnk.blinkcond_position', 'bdg.badge_display_inside', 'bdg.badge_shape_type', 'bdg.badge_text_color', 'bdg.badge_color', 'COALESCE(bdg_l.badge_name, bdg.badge_identifier) as badge_name', 'blc.badgelink_id', 'blc.badgelink_record_id', 'COALESCE(sp.selprod_id,prod.product_selprod_id,shpprod.shop_selprod_id) as selprod_id']);
        $srch->addCondition('blnk.blinkcond_from_date', '<=', $date);
        $cnd = $srch->addCondition('blnk.blinkcond_to_date', '>=', $date);
        $cnd->attachCondition('blnk.blinkcond_to_date', '=', '0000-00-00 00:00:00');
        $srch->addCondition('bdg.badge_type', '=', Badge::TYPE_RIBBON);
        $srch->addCondition('bdg.badge_active', '=', applicationConstants::ACTIVE);
        $srch->addHaving('selprod_id', 'is NOT', 'mysql_func_NULL', 'AND', true);
        $srch->addOrder('blinkcond_id');
        $srch->addCondition('blnk.blinkcond_position', '=', $position);
        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'selprod_id');
    }

    public static function getSelprodBadges(int $langId, array $selprodIdArr = [])
    {
        $date = date('Y-m-d H:i:00');
        $srch = new BadgeLinkConditionSearch();
        $srch->setSelProdIdArr($selprodIdArr);
        $srch->joinBadges($langId, Badge::TYPE_BADGE);
        $srch->joinBadgeLinks();
        $srch->joinProducts();
        $srch->joinSellerProducts();
        $srch->joinBadgeRequest();

        $srch->addCondition('blnk.blinkcond_from_date', '<=', $date);
        $cnd = $srch->addCondition('blnk.blinkcond_to_date', '>=', $date);
        $cnd->attachCondition('blnk.blinkcond_to_date', '=', '0000-00-00 00:00:00');
        $srch->addCondition('bdg.badge_type', '=', Badge::TYPE_BADGE);
        $srch->addCondition('bdg.badge_trigger_type', '=', Badge::COND_MANUAL);
        $srch->addDirectCondition('(bdg.badge_required_approval = ' . Badge::APPROVAL_OPEN . ' or (if(breq.breq_id > 0, breq.breq_status = ' . BadgeRequest::REQUEST_APPROVED . ', bdg.badge_required_approval = ' . Badge::APPROVAL_REQUIRED . ')))');

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(['blnk.blinkcond_id', 'blnk.blinkcond_badge_id', 'bdg.badge_display_inside', 'COALESCE(bdg_l.badge_name, bdg.badge_identifier) as badge_name', 'blc.badgelink_id', 'blc.badgelink_record_id', 'breq.breq_id', 'COALESCE(sp.selprod_id,prod.product_selprod_id) as selprod_id']);
        $srch->addHaving('selprod_id', 'is NOT', 'mysql_func_NULL', 'AND', true);
        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'blinkcond_badge_id');
    }

    /**
     * getShopBadges
     *
     * @param  int $langId
     * @param  array $shopIdArr
     * @return array
     */
    public static function getShopBadges(int $langId, array $shopIdArr = []): array
    {
        $manualBadges = self::getManualShopBadges($langId, $shopIdArr);
        $autoBadges = self::getAutoShopBadges($langId, $shopIdArr);
        return $manualBadges + $autoBadges;
    }

    /**
     * getManualBadges
     *
     * @param  int $langId
     * @param  array $shopIdArr   
     * @return array
     */
    public static function getManualShopBadges(int $langId, array $shopIdArr = []): array
    {
        $date = date('Y-m-d H:i:00');
        $srch = new BadgeLinkConditionSearch();
        $srch->joinBadges($langId, Badge::TYPE_BADGE);
        $srch->joinBadgeLinks();
        $srch->joinBadgeRequest();
        $srch->joinShopsForBadges($shopIdArr);

        $srch->addCondition('blnk.blinkcond_from_date', '<=', $date);
        $cnd = $srch->addCondition('blnk.blinkcond_to_date', '>=', $date);
        $cnd->attachCondition('blnk.blinkcond_to_date', '=', '0000-00-00 00:00:00');
        $srch->addCondition('bdg.badge_type', '=', Badge::TYPE_BADGE);
        $srch->addCondition('bdg.badge_trigger_type', '=', Badge::COND_MANUAL);
        $srch->addDirectCondition('(bdg.badge_required_approval = ' . Badge::APPROVAL_OPEN . ' or (if(breq.breq_id > 0, breq.breq_status = ' . BadgeRequest::REQUEST_APPROVED . ', bdg.badge_required_approval = ' . Badge::APPROVAL_REQUIRED . ')))');

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(['blnk.blinkcond_id', 'blnk.blinkcond_badge_id', 'bdg.badge_display_inside', 'COALESCE(bdg_l.badge_name, bdg.badge_identifier) as badge_name', 'blc.badgelink_id', 'blc.badgelink_record_id', 'breq.breq_id', 'shpprod.shop_id']);

        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'blinkcond_badge_id');
    }

    /**
     * getAutomaticShopBadges
     *
     * @param  int $langId
     * @param  array $shopIdArr   
     * @return array
     */
    public static function getAutoShopBadges(int $langId, array $shopIdArr = [], bool $addGroupBy = true): array
    {
        $srch = new SearchBase(Shop::DB_TBL_STATS, 'stats');
        if (!empty($shopIdArr)) {
            $srch->addCondition('sstats_shop_id', 'IN', $shopIdArr);
        }
        $srch->doNotCalculateRecords();
        $shopStats = FatApp::getDb()->fetchAll($srch->getResultSet());
        if (empty($shopStats)) {
            return [];
        }

        $shopAutoBadges = [];
        $now = date('Y-m-d H:i:s');
        foreach ($shopStats as $ss) {
            $shopAvgRating = $ss['sstats_avg_rating'];
            $completionRate = $ss['sstats_completion_rate'];
            $completedOrders = $ss['sstats_completed_orders'];
            $returnAcceptanceRate = $ss['sstats_return_acceptance_rate'];
            $orderCancellationRate = $ss['sstats_cancellation_rate'];

            $srch = new BadgeLinkConditionSearch();
            $srch->joinBadge($langId);
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addMultipleFields(['blinkcond_badge_id', 'COALESCE(bdg_l.badge_name, bdg.badge_identifier) as badge_name', $ss['sstats_shop_id'] . ' as shop_id']);
            if (false === $addGroupBy) {
                $srch->addFld('blinkcond_id');
            }

            $srch->addDirectCondition(
                '(CASE 
                    WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP . ' 
                        THEN ' . $shopAvgRating . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                    WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE . ' 
                        THEN ' . $completionRate . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                    WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS . ' 
                        THEN ' . $completedOrders . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                    WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE . ' 
                        THEN ' . $returnAcceptanceRate . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                    WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED . ' 
                        THEN ' . $orderCancellationRate . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                    ELSE FALSE
                END)'
            );

            $srch->addDirectCondition(
                '(CASE 
                    WHEN blinkcond_from_date != 0 AND blinkcond_to_date != 0
                    THEN "' . $now . '" BETWEEN blinkcond_from_date AND blinkcond_to_date 
                    WHEN blinkcond_from_date != 0 AND blinkcond_to_date = 0
                    THEN "' . $now . '" >= blinkcond_from_date
                    WHEN blinkcond_from_date = 0 AND blinkcond_to_date != 0
                    THEN "' . $now . '" <= blinkcond_to_date 
                    ELSE TRUE 
                END)'
            );

            $srch->addCondition('badge_trigger_type', '=', Badge::COND_AUTO);
            $srch->addCondition('badge_type', '=', Badge::TYPE_BADGE);
            $srch->addCondition('badge_active', '=', applicationConstants::ACTIVE);

            if (true === $addGroupBy) {
                $srch->addGroupBy('blinkcond_badge_id');
            }
            $shopAutoBadges += FatApp::getDb()->fetchAll($srch->getResultSet(), 'blinkcond_badge_id');
        }
        return $shopAutoBadges;
    }

    public static function getTriggerCondTypeHtml(int $langId, int $type): string
    {
        $arr = self::getTriggerCondTypeArr($langId);
        $msg = $arr[$type];
        switch ($type) {
            case self::COND_MANUAL:
                $status = 'info';
                break;
            case self::COND_AUTO:
                $status = 'success';
                break;

            default:
                $status = 'warning';
                break;
        }
        return '<span class="font-' . $status . '">' . $msg . '</span>';
    }

    public static function getApprovalTypeHtml(int $langId, int $status, int $conditionType): string
    {
        $arr = self::getApprovalStatusArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        switch ($status) {
            case self::APPROVAL_OPEN:
                $status = HtmlHelper::INFO;
                break;
            case self::APPROVAL_REQUIRED:
                $status = HtmlHelper::DANGER;
                break;

            default:
                $status = HtmlHelper::WARNING;
                break;
        }
        $notAllowed = (Badge::COND_AUTO == $conditionType);
        $msg = $notAllowed ? Labels::getLabel('LBL_NOT_ALLOWED') : $msg;
        $status = $notAllowed ? HtmlHelper::WARNING : $status;
        return HtmlHelper::getStatusHtml($status, $msg);
    }
}
