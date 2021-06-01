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
     /* For Ribbon */

    public const REMOVED_OLD_IMAGE_TIME = 4;

    private $selProdId = 0;  //Priority 1
    private $prodId = 0;  //Priority 2
    private $shopId = 0;  //Priority 3

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
        return [
            self::TYPE_BADGE => Labels::getLabel('LBL_BADGE', $langId),
            self::TYPE_RIBBON => Labels::getLabel('LBL_RIBBON', $langId)
        ];
    }
    
    /**
     * getTypeName
     *
     * @param  int $type
     * @param  int $langId
     * @return string
     */
    public static function getTypeName(int $type, int $langId): string
    {
        $arr = self::getTypeArr($langId);
        if (!array_key_exists($type, $arr)) {
            return '';
        }
        return (string) $arr[$type];
    }

    /**
     * getShapeTypesArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getShapeTypesArr(int $langId): array
    {
        return [
            self::SHAPE_RECTANGLE => Labels::getLabel('LBL_RECTANGLE', $langId),
            self::SHAPE_STRIP => Labels::getLabel('LBL_STRIP', $langId),
            self::SHAPE_STAR => Labels::getLabel('LBL_STAR', $langId),
            self::SHAPE_TRIANGLE => Labels::getLabel('LBL_TRIANGLE', $langId),
            self::SHAPE_CIRCLE => Labels::getLabel('LBL_CIRCLE', $langId),
        ];
    }

    /**
     * getShapeTypeName
     *
     * @param  int $type
     * @param  int $langId
     * @return string
     */
    public static function getShapeTypeName(int $type, int $langId): string
    {
        $arr = self::getShapeTypesArr($langId);
        if (!array_key_exists($type, $arr)) {
            return '';
        }
        return (string) $arr[$type];
    }
    
    /**
     * getData
     *
     * @param  int $langId
     * @return array
     */
    public function getData(int $langId): array
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
            return [];
        }

        $srch = new BadgeSearch($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition(self::DB_TBL_PREFIX . 'id', '=', $this->getMainTableRecordId());
        $srch->addMultipleFields(array_merge(self::ATTR, self::LANG_ATTR));
        $srch->descOrder();
        $rs = $srch->getResultSet();
        
        return (array) FatApp::getDb()->fetch($rs);
    }

    /**
     * getAllLangData
     *
     * @return array
     */
    public function getAllLangData(): array
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('MSG_INVALID_REQUEST', CommonHelper::getLangId());
            return [];
        }

        $srch = new BadgeSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->joinTable(
            Badge::DB_TBL_LANG,
            'LEFT OUTER JOIN',
            'bdg_l.badgelang_badge_id = bdg.badge_id',
            'bdg_l'
        );
        $srch->addCondition(self::DB_TBL_PREFIX . 'id', '=', $this->getMainTableRecordId());
        $srch->addMultipleFields(array_merge(self::ATTR, self::LANG_ATTR));
        $srch->descOrder();
        $rs = $srch->getResultSet();
        
        return (array) FatApp::getDb()->fetchAll($rs, self::DB_TBL_LANG_PREFIX . 'lang_id');
    }
    
    /**
     * getRequiredApprovalName
     *
     * @param  int $status
     * @param  int $langId
     * @return string
     */
    public static function getRequiredApprovalName(int $status, int $langId): string
    {
        return (applicationConstants::YES == $status ? Labels::getLabel('LBL_REQUESTED', $langId) : Labels::getLabel('LBL_OPEN', $langId));
    }
    
    /**
     * add
     *
     * @param  array $post
     * @return bool
     */
    public function add(array $post): bool
    {
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $recordData = [];
        foreach (Badge::ATTR as $column) {
            switch ($column) {
                case Badge::DB_TBL_PREFIX . 'id':
                    continue 2;
                    break;
                
                case Badge::DB_TBL_PREFIX . 'identifier':
                        $recordData[$column] = "";
                        if (array_key_exists(Badge::DB_TBL_PREFIX . 'name', $post) && is_array($post[Badge::DB_TBL_PREFIX . 'name']) && array_key_exists($siteDefaultLangId, $post[Badge::DB_TBL_PREFIX . 'name'])) {
                            $recordData[$column] = $post[Badge::DB_TBL_PREFIX . 'name'][$siteDefaultLangId];
                        } else {
                            $recordData[$column] = $post[Badge::DB_TBL_PREFIX . 'name'];
                        }

                        if (self::TYPE_RIBBON == $post[self::DB_TBL_PREFIX . 'type']) {
                            if (self::RIBB_TEXT_MIN_LEN > strlen($recordData[$column])) {
                                $this->error = Labels::getLabel('LBL_INVALID_MIN_LENGTH', $siteDefaultLangId);
                                return false; 
                            }

                            if (self::RIBB_TEXT_MAX_LEN < strlen($recordData[$column])) {
                                $recordData[$column] = substr($recordData[$column], 0, (self::RIBB_TEXT_MAX_LEN - 1));
                            }
                        }

                    break;
                    
                case Badge::DB_TBL_PREFIX . 'active':
                    $recordData[$column] = (0 > $post[Badge::DB_TBL_PREFIX . 'active'] ? applicationConstants::NO : $post[Badge::DB_TBL_PREFIX . 'active']);
                    break;
                        
                default:
                    $recordData[$column] = array_key_exists($column, $post) ? $post[$column] : '';
                    break;
                
            }
        }
        
        $this->assignValues($recordData);
        if (!$this->save()) {
            return false;
        }

        $badgeId = $this->getMainTableRecordId();

        if (array_key_exists(Badge::DB_TBL_PREFIX . 'name', $post) && is_array($post[Badge::DB_TBL_PREFIX . 'name'])) {
            $langNames = Language::getAllNames();
            foreach ($post[Badge::DB_TBL_PREFIX . 'name'] as $langId => $name) {
                $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
                $tranlateToOtherLang = array_key_exists('auto_update_other_langs_data', $post) ? $post['auto_update_other_langs_data'] : 0;
                if (empty($name) && !empty($translatorSubscriptionKey) && 0 < $tranlateToOtherLang) {
                    $updateLangDataobj = new TranslateLangData(self::DB_TBL_LANG);
                    $translatedText = $updateLangDataobj->directTranslate([Badge::DB_TBL_PREFIX . 'name' => $recordData[Badge::DB_TBL_PREFIX . 'identifier']]);
                    if (false === $translatedText) {
                        continue;
                    }
                    $name = current($translatedText)[Badge::DB_TBL_PREFIX . 'name'];
                }

                if (empty($name)) {
                    continue;
                }

                if (self::TYPE_RIBBON == $post[self::DB_TBL_PREFIX . 'type']) {
                    if (self::RIBB_TEXT_MIN_LEN > strlen($name)) {
                        $this->error = Labels::getLabel('LBL_INVALID_LENGTH_OF_{LANG}_NAME', $langId);
                        $this->error = CommonHelper::replaceStringData($this->error, ['{LANG}' => $langNames[$langId]]);
                        return false; 
                    }

                    if (self::RIBB_TEXT_MAX_LEN < strlen($name)) {
                        $name = substr($name, 0, (self::RIBB_TEXT_MAX_LEN - 1));
                    }
                }

                $recordLangData = [
                    Badge::DB_TBL_LANG_PREFIX . 'badge_id' => $badgeId,
                    Badge::DB_TBL_LANG_PREFIX . 'lang_id' => $langId,
                    Badge::DB_TBL_PREFIX . 'name' => $name
                ];
                
                if (!$this->updateLangData($langId, $recordLangData)) {
                    return false;
                }
            }
        }
        return true;
    }
    
    /**
     * deleteImagesWithOutBadgeId
     *
     * @param  int $fileType
     * @return bool
     */
    public static function deleteImagesWithOutBadgeId(int $fileType): bool
    {
        if (empty($fileType) || $fileType != AttachedFile::FILETYPE_BADGE) {
            return false;
        }

        $currentDate = date('Y-m-d  H:i:s');
        $prevDate = strtotime('-' . static::REMOVED_OLD_IMAGE_TIME . ' hour', strtotime($currentDate));
        $prevDate = date('Y-m-d  H:i:s', $prevDate);
        $where = array('smt' => 'afile_type = ? AND afile_record_id = ? AND afile_updated_at <= ?', 'vals' => array($fileType, 0, $prevDate));
        if (!FatApp::getDb()->deleteRecords(AttachedFile::DB_TBL, $where)) {
            return false;
        }
        return true;
    }
    
    /**
     * setSellerProdudtId
     *
     * @param  int $selProdId
     * @return object
     */
    public function setSellerProdudtId(int $selProdId): object
    {
        $this->selProdId = $selProdId;
        return $this;
    }

    /**
     * setProductId
     *
     * @param  int $prodId
     * @return object
     */
    public function setProductId(int $prodId): object
    {
        $this->prodId = $prodId;
        return $this;
    }

    /**
     * setShopId
     *
     * @param  int $shopId
     * @return object
     */
    public function setShopId(int $shopId): object
    {
        $this->shopId = $shopId;
        return $this;
    }
    
    /**
     * getRibbon
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

        $avgRating = SellerProduct::getRating($this->selProdId);
        if (1 > $avgRating) {
            $avgRating = SellerProduct::getProdRating($this->prodId);
        }
        
        $sellerId = Shop::getAttributesById($this->shopId, 'shop_user_id');

        $shopAvgRating = SellerProduct::getShopRating($sellerId);
        $completionRate = OrderProduct::getCompletionRate($sellerId);
        $completedOrders = OrderProduct::getCompltedOrderCount($sellerId);
        $returnAcceptanceRate = OrderProduct::getReturnAcceptanceRate($sellerId);
        $orderCancellationRate = OrderProduct::getCancellationRate($sellerId);

        $attr = [
            'blinkcond_badge_id',
            'blinkcond_record_type',
            'badge_display_inside',
            'badge_type',
            'badge_shape_type',
            'badge_color',
            'COALESCE(badge_name, badge_identifier) as badge_name'
        ];

        $srch = new BadgeLinkConditionSearch();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);/* Need to discuss about display functionality relatd to badges and ribbons. single or multiple */
        $srch->joinBadgeLinks();
        $srch->joinBadge($langId);
        $srch->addMultipleFields($attr);
        $srch->addDirectCondition(
            '(CASE 
                WHEN blinkcond_condition_type > 0
                THEN 
                    (CASE 
                        WHEN blinkcond_condition_type = "' . BadgeLinkCondition::COND_TYPE_AVG_RATING . '" 
                            THEN (CASE 
                                    WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . ' 
                                    THEN "' . $shopAvgRating . '" BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                                    ELSE "' . $avgRating . '" BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                                END)
                        WHEN blinkcond_condition_type = "' . BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE . '" 
                            THEN "' . $completionRate . '" = blinkcond_condition_from
                        WHEN blinkcond_condition_type = "' . BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS . '" 
                            THEN "' . $completedOrders . '" BETWEEN blinkcond_condition_from AND blinkcond_condition_to
                        WHEN blinkcond_condition_type = "' . BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE . '" 
                            THEN "' . $returnAcceptanceRate . '" = blinkcond_condition_from
                        WHEN blinkcond_condition_type = "' . BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED . '" 
                            THEN "' . $orderCancellationRate . '" = blinkcond_condition_from
                        ELSE TRUE
                    END)
                ELSE 
                    badgelink_record_id = (CASE 
                    WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . ' THEN ' . $this->selProdId . '
                    WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_PRODUCT . ' THEN ' . $this->prodId . '
                    WHEN blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . ' THEN ' . $this->shopId . '
                    ELSE 0 END)
            END)'
        );
        $srch->addDirectCondition(
            '(CASE 
                WHEN blinkcond_to_date != 0 
                THEN "' . date('Y-m-d H:i:s') . '" BETWEEN blinkcond_from_date AND blinkcond_to_date 
                ELSE TRUE 
            END)'
        );
        $srch->addCondition('badge_type', '=', $type);
        $srch->addCondition('badge_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('badge_required_approval', '=', applicationConstants::NO);
        $srch->addOrder('blinkcond_record_type', 'ASC');
        // echo $srch->getQuery();
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
            $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], $langId, 0, false);
            if (!is_array($icon) || empty($icon['afile_physical_path'])) {
                /* Fetching Universal Image Else */
                $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[BadgeLinkCondition::DB_TBL_PREFIX . 'badge_id'], 0, 0, false);
            }
            $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
            $urls[] = UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], $size, $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        }
        return $urls;
    }
}
