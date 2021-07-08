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
        self::DB_TBL_PREFIX . 'condition_type',
        self::DB_TBL_PREFIX . 'shape_type',
        self::DB_TBL_PREFIX . 'display_inside',
        self::DB_TBL_PREFIX . 'color',
        self::DB_TBL_PREFIX . 'identifier',
        self::DB_TBL_PREFIX . 'required_approval',
        self::DB_TBL_PREFIX . 'active'
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

    private $selProdId = 0;  //Priority 1
    private $prodId = 0;  //Priority 2
    private $shopId = 0;  //Priority 3

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
        $arr = FatCache::get('getBadgeTypeArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::TYPE_BADGE => Labels::getLabel('LBL_BADGE', $langId),
                self::TYPE_RIBBON => Labels::getLabel('LBL_RIBBON', $langId)
            ];
            FatCache::set('getBadgeTypeArr' . $langId, FatUtility::convertToJson($arr), '.txt');
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getConditionTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getConditionTypeArr(int $langId): array
    {
        $arr = FatCache::get('getBadgeConditionTypeArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::COND_MANUAL => Labels::getLabel('LBL_MANUAL', $langId),
                self::COND_AUTO => Labels::getLabel('LBL_AUTOMATIC', $langId)
            ];
            FatCache::set('getBadgeConditionTypeArr' . $langId, FatUtility::convertToJson($arr), '.txt');
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
        $arr = FatCache::get('getBadgeShapeTypesArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::SHAPE_RECTANGLE => Labels::getLabel('LBL_RECTANGLE', $langId),
                self::SHAPE_STRIP => Labels::getLabel('LBL_STRIP', $langId),
                self::SHAPE_STAR => Labels::getLabel('LBL_STAR', $langId),
                self::SHAPE_TRIANGLE => Labels::getLabel('LBL_TRIANGLE', $langId),
                self::SHAPE_CIRCLE => Labels::getLabel('LBL_CIRCLE', $langId),
            ];
            FatCache::set('getBadgeShapeTypesArr' . $langId, FatUtility::convertToJson($arr), '.txt');
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
        $arr = FatCache::get('getRibbonPostionArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::RIBB_POS_TRIGHT => Labels::getLabel("LBL_TOP_RIGHT", $langId),
                self::RIBB_POS_TLEFT => Labels::getLabel("LBL_TOP_LEFT", $langId),
            ];
            FatCache::set('getRibbonPostionArr' . $langId, FatUtility::convertToJson($arr), '.txt');
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
        $arr = FatCache::get('getBadgeApprovalStatusArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::APPROVAL_OPEN => Labels::getLabel('LBL_OPEN', $langId),
                self::APPROVAL_REQUIRED => Labels::getLabel('LBL_REQUIRED', $langId),
            ];
            FatCache::set('getBadgeApprovalStatusArr' . $langId, FatUtility::convertToJson($arr), '.txt');
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
     * setRecordId
     *
     * @param  int $selProdId
     * @param  int $prodId
     * @param  int $shopId
     * @return void
     */
    public function setRecordId(int $selProdId = 0, int $prodId = 0, int $shopId = 0): object
    {
        $this->selProdId = $selProdId;
        $this->prodId = $prodId;
        $this->shopId = $shopId;
        return $this;
    }

    /**
     * getBadges
     *
     * @param  int $langId
     * @param  int $type
     * @return array
     */
    public function getRibbonOrBadge(int $langId, int $type = Badge::TYPE_RIBBON): array
    {
        if (1 > $this->selProdId && 1 > $this->prodId && 1 > $this->shopId) {
            return [];
        }

        $sellerId = Shop::getAttributesById($this->shopId, 'shop_user_id');

        $avgRating = SellerProduct::getRating($this->selProdId);
        $shopAvgRating = SellerProduct::getShopRating($sellerId);
        $completionRate = OrderProduct::getCompletionRate($sellerId);
        $completedOrders = OrderProduct::getCompltedOrderCount($sellerId);
        $returnAcceptanceRate = OrderProduct::getReturnAcceptanceRate($sellerId);
        $orderCancellationRate = OrderProduct::getCancellationRate($sellerId);

        $srchRecord = new BadgeLinkConditionSearch();
        $srchRecord->doNotCalculateRecords();

        if ($type == Badge::TYPE_BADGE) {
            $srchRecord->doNotLimitRecords();
        }

        if ($type == Badge::TYPE_RIBBON) {
            $srchRecord->setPageSize(count(self::getRibbonPostionArr($langId)));
        }

        $srchRecord->joinBadgeLinks();
        $srchRecord->joinBadgeRequest();
        $srchRecord->joinBadge();
        $srchRecord->addMultipleFields(['MAX(blinkcond_id) as m_blinkcond_id']);

        $recordCondition = '(CASE 
                                WHEN blinkcond_condition_type = 0
                                THEN badgelink_record_id = 
                                    (CASE 
                                        WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . ' THEN ' . $this->selProdId . '
                                        WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_PRODUCT . ' THEN ' . $this->prodId . '
                                        WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . ' THEN ' . $this->shopId . '
                                        ELSE 0 
                                    END)
                                ELSE FALSE END)';

        if ($type == Badge::TYPE_BADGE) {
            $srchRecord->addFld('blinkcond_condition_type');
            $srchRecord->addDirectCondition(
                '(CASE 
                    WHEN blinkcond_condition_type > 0
                    THEN 
                        (CASE 
                            WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_AVG_RATING_SELPROD . ' 
                                THEN ' . $avgRating . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                            WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP . ' 
                                THEN ' . $shopAvgRating . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                            WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE . ' 
                                THEN ' . $completionRate . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                            WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS . ' 
                                THEN ' . $completedOrders . ' BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                            WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE . ' 
                                THEN ' . $returnAcceptanceRate . ' = blinkcond_condition_from
                            WHEN blinkcond_condition_type = ' . BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED . ' 
                                THEN ' . $orderCancellationRate . ' = blinkcond_condition_from
                            ELSE FALSE
                        END)
                    ELSE ' . $recordCondition . ' END)'
            );
        }

        if ($type == Badge::TYPE_RIBBON) {
            $srchRecord->addDirectCondition($recordCondition);
        }

        $srchRecord->addDirectCondition(
            '(CASE 
                WHEN blinkcond_from_date != 0 AND blinkcond_to_date != 0
                THEN "' . date('Y-m-d H:i:s') . '" BETWEEN blinkcond_from_date AND blinkcond_to_date 
                WHEN blinkcond_from_date != 0 AND blinkcond_to_date = 0
                THEN "' . date('Y-m-d H:i:s') . '" >= blinkcond_from_date
                WHEN blinkcond_from_date = 0 AND blinkcond_to_date != 0
                THEN "' . date('Y-m-d H:i:s') . '" <= blinkcond_to_date 
                ELSE TRUE 
            END)'
        );

        $srchRecord->addDirectCondition(
            '(CASE 
                WHEN breq_id IS NOT NULL
                THEN breq_status = ' . BadgeRequest::REQUEST_APPROVED . ' 
                ELSE TRUE 
            END)'
        );

        $srchRecord->addCondition('badge_type', '=', $type);
        $srchRecord->addCondition('badge_active', '=', applicationConstants::ACTIVE);
        if ($type == Badge::TYPE_RIBBON) {
            $srchRecord->addGroupBy('blinkcond_position');
        } else {
            $srchRecord->addGroupBy('blinkcond_id');
        }
        
        $srchRecord->addOrder('blinkcond_id', 'DESC');


        $attr = [
            'blinkcond_id',
            'blinkcond_badge_id',
            'blinkcond_record_type',
            'badge_display_inside',
            'blinkcond_position',
            'badge_type',
            'COALESCE(badge_name, badge_identifier) as badge_name',
            'breq_id',
            'badge_shape_type',
            'badge_color',
            'blnk.blinkcond_condition_type'
        ];

        $srch = new BadgeLinkConditionSearch();
        $srch->joinTable('(' . $srchRecord->getQuery() . ') as m_blnk', 'INNER JOIN', 'blnk.blinkcond_id = m_blnk.m_blinkcond_id');
        $srch->joinBadgeLinks();
        $srch->joinBadgeRequest();
        $srch->joinBadge($langId);
        $srch->addMultipleFields($attr);
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    /**
     * getBadgeUrl
     *
     * @param  int $langId
     * @param  string|int $size
     * @return array
     */
    public function getBadgeUrl(int $langId, $size = 'MINI'): array
    {
        if (1 > $this->selProdId && 1 > $this->prodId && 1 > $this->shopId) {
            return [];
        }

        $badgeDetail = $this->getRibbonOrBadge($langId, Badge::TYPE_BADGE);
        if (!is_array($badgeDetail) || empty($badgeDetail)) {
            return [];
        }

        $urls = [];

        foreach ($badgeDetail as $row) {
            $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], 0, $langId, true);
            $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
            $urls[] = [
                'url' => UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $langId, $size, $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                'name' => $row['badge_name'],
                'conditionType' => $row['blinkcond_condition_type'],
            ];
        }
        return $urls;
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
        $srch = new BadgeLinkConditionSearch();
        $srch->joinBadge();
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id');
        $srch->addMultipleFields([
            self::DB_TBL_PREFIX . 'id',
            '(CASE
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_RIBBON . ' OR ' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_OPEN . '
                THEN 1
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_BADGE . ' AND ' . Badge::DB_TBL_PREFIX . 'condition_type = ' . Badge::COND_AUTO . '
                THEN 0
                WHEN (SUM(IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED  . ' AND ' . BadgeLinkCondition::DB_TBL_PREFIX . 'id > 0 AND ' . BadgeRequest::DB_TBL_PREFIX . 'id IS NULL, 1, 0))) > 0 OR (SUM(IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'status = ' . BadgeRequest::REQUEST_APPROVED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'user_id = ' . UserAuthentication::getLoggedUserId() . ', 1, 0)) > 0)
                THEN 1
                ELSE 0
            END) as canAccess'
        ]);
        $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id', '=', $badgeId);
        $record = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        return current($record);
    }
}
