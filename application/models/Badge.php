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

        $attr = [
            'blinkcond_badge_id',
            'blinkcond_record_type',
            'badge_display_inside',
            'blinkcond_position',
            'badge_type',
            'COALESCE(badge_name, badge_identifier) as badge_name'
        ];

        $srch = new BadgeLinkConditionSearch();
        $srch->doNotCalculateRecords();

        if ($type == Badge::TYPE_BADGE) {
            $srch->doNotLimitRecords();
        }

        if ($type == Badge::TYPE_RIBBON) {
            $srch->setPageSize(count(self::getRibbonPostionArr($langId)));
        }

        $srch->joinBadgeLinks();
        $srch->joinBadge($langId);
        $srch->addMultipleFields($attr);

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
            $srch->addFld('blinkcond_condition_type');
            $srch->addDirectCondition(
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
            $srch->addFld([
                'badge_shape_type',
                'badge_color',
            ]);
            $srch->addDirectCondition($recordCondition);
        }

        $srch->addDirectCondition(
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
        $srch->addCondition('badge_type', '=', $type);
        $srch->addCondition('badge_active', '=', applicationConstants::ACTIVE);
        $srch->addOrder('blinkcond_id', 'DESC');

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
     * getAllBadgesAndRibbons
     *
     * @param  int $langId
     * @param  int $type
     * @param  int $approvalStatus
     * @param  bool $assoc
     * @return array
     */
    public static function getAllBadgesAndRibbons(int $langId, int $type = 0, int $approvalStatus = -1, bool $assoc = true): array
    {
        $srch = new BadgeSearch($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        if (0 < $type) {
            $srch->addCondition('badge_type', '=', $type);
        }

        if (-1 < $approvalStatus) {
            $srch->addCondition('badge_required_approval', '=', $approvalStatus);
        }

        if (true === $assoc) {
            $srch->addMultipleFields([
                    'badge_id',
                    'COALESCE(badge_name, badge_identifier) as badge_name'
                ]
            );
            return (array) FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        }

        $srch->addMultipleFields(array_merge(self::ATTR, ['COALESCE(badge_name, badge_identifier) as badge_name']));
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }
}
