<?php

class BadgeLinkCondition extends MyAppModel
{
    public const DB_TBL = 'tbl_badge_link_conditions';
    public const DB_TBL_PREFIX = 'blinkcond_';
    
    public const DB_TBL_BADGE_LINKS = 'tbl_badge_links';
    public const DB_TBL_BADGE_LINKS_PREFIX = 'badgelink_';

    public const RECORD_TYPE_SELLER_PRODUCT = 1;
    public const RECORD_TYPE_PRODUCT = 2;
    public const RECORD_TYPE_SHOP = 3;

    public const COND_TYPE_DATE = 1;
    public const COND_TYPE_AVG_RATING_SELPROD = 2;
    public const COND_TYPE_AVG_RATING_SHOP = 3;
    public const COND_TYPE_ORDER_COMPLETION_RATE = 4;
    public const COND_TYPE_COMPLETED_ORDERS = 5;
    public const COND_TYPE_RETURN_ACCEPTANCE = 6; // Refund/Return Acceptance
    public const COND_TYPE_ORDER_CANCELLED = 7; // Cancelled By Seller
    
    public const REC_COND_AUTO = 1;
    public const REC_COND_MANUAL = 2;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'badge_id',
        self::DB_TBL_PREFIX . 'position',
        self::DB_TBL_PREFIX . 'record_type',
        self::DB_TBL_PREFIX . 'from_date',
        self::DB_TBL_PREFIX . 'to_date',
        self::DB_TBL_PREFIX . 'condition_type',
        self::DB_TBL_PREFIX . 'condition_from',
        self::DB_TBL_PREFIX . 'condition_to'
    ];

    /* Require Range Element(From, To) for the these condition types. */
    public const RANGE_COND_TYPE_ELEMENT = [
        self::COND_TYPE_COMPLETED_ORDERS,
        self::COND_TYPE_AVG_RATING_SELPROD,
        self::COND_TYPE_AVG_RATING_SHOP,
        self::COND_TYPE_ORDER_COMPLETION_RATE
    ];

    /* Display Badge relared to these condition types.  */
    public const SHOP_BADGES_COND_TYPES = [
        self::COND_TYPE_AVG_RATING_SHOP,
        self::COND_TYPE_ORDER_COMPLETION_RATE,
        self::COND_TYPE_COMPLETED_ORDERS,
        self::COND_TYPE_RETURN_ACCEPTANCE,
        self::COND_TYPE_ORDER_CANCELLED
    ];

    /**
     * __construct
     *
     * @param  int $badgeLinkId
     * @return void
     */
    public function __construct(int $badgeLinkId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $badgeLinkId);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
    }

    /**
     * getRecordTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getRecordTypeArr(int $langId): array
    {
        return [
            self::RECORD_TYPE_SELLER_PRODUCT => Labels::getLabel('LBL_SELLER_PRODUCT', $langId),
            self::RECORD_TYPE_PRODUCT => Labels::getLabel('LBL_PRODUCT', $langId),
            self::RECORD_TYPE_SHOP => Labels::getLabel('LBL_SHOP', $langId)
        ];
    }
    
    /**
     * getRecordTypeName
     *
     * @param  int $type
     * @param  int $langId
     * @return string
     */
    public static function getRecordTypeName(int $type, int $langId): string
    {
        $arr = self::getRecordTypeArr($langId);
        if (!array_key_exists($type, $arr)) {
            return '';
        }
        return (string) $arr[$type];
    }

    /**
     * getConditionTypesArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getConditionTypesArr(int $langId): array
    {
        return [
            self::COND_TYPE_AVG_RATING_SELPROD => Labels::getLabel('LBL_AVERAGE_RATING_SELLER_PRODUCT_(%)', $langId),
            self::COND_TYPE_AVG_RATING_SHOP => Labels::getLabel('LBL_AVERAGE_RATING_SHOP_(%)', $langId),
            self::COND_TYPE_ORDER_COMPLETION_RATE => Labels::getLabel('LBL_ORDER_COMPLETION_RATE_(%)', $langId),
            self::COND_TYPE_COMPLETED_ORDERS => Labels::getLabel('LBL_COMPLETED_ORDERS', $langId),
            self::COND_TYPE_RETURN_ACCEPTANCE => Labels::getLabel('LBL_RETURN/_REFUND_ACCEPTANCE_RATE_(%)', $langId),
            self::COND_TYPE_ORDER_CANCELLED => Labels::getLabel('LBL_ORDER_CANCELLED_BY_SELLER_(%)', $langId),
            
        ];
    }

    /**
     * getConditionTypeName
     *
     * @param  int $type
     * @param  int $langId
     * @return string
     */
    public static function getConditionTypeName(int $type, int $langId): string
    {
        $arr = self::getConditionTypesArr($langId);
        if (!array_key_exists($type, $arr)) {
            return '';
        }
        return (string) $arr[$type];
    }

    /**
     * getRecordConditionArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getRecordConditionArr(int $langId): array
    {
        return [
            self::REC_COND_MANUAL => Labels::getLabel('LBL_MANUALLY', $langId),
            self::REC_COND_AUTO => Labels::getLabel('LBL_AUTOMATICALLY', $langId),
        ];
    }
    
    /**
     * getBadgeLinksSearchObj
     *
     * @param  int $langId
     * @param  bool $linkRecords
     * @return object
     */
    public static function getBadgeLinksSearchObj(int $langId, bool $linkRecords = false): object
    {
        $srch = new BadgeLinkConditionSearch();

        $recordFields = [];
        if (true === $linkRecords) {
            $recordFields = [
                '(CASE 
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_PRODUCT . ' 
                        THEN COALESCE( p_l.product_name, p.product_identifier )
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '  
                        THEN selprod_title
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . ' 
                        THEN COALESCE( shp_l.shop_name, shp.shop_identifier )
                    ELSE TRUE
                END) as record_name',
                '(CASE 
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '  
                        THEN option_name
                    ELSE ""
                END) as option_name',
                '(CASE 
                        WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '  
                            THEN optionvalue_name
                        ELSE ""
                END) as option_value_name',
                '(CASE 
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '
                        THEN spu.credential_username
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . '
                        THEN shpu.credential_username
                    ELSE ""
                END) as seller'
            ];
        }

        $recordIdsCol = (false === $linkRecords) ? 'GROUP_CONCAT(badgelink_record_id) as badgelink_record_ids' : 'badgelink_record_id';

        $attr = array_merge(
            self::ATTR,
            [
                'COALESCE(' . Badge::DB_TBL_PREFIX . 'name, ' . Badge::DB_TBL_PREFIX . 'identifier) as ' . Badge::DB_TBL_PREFIX . 'name',
                Badge::DB_TBL_PREFIX . 'type',
                Badge::DB_TBL_PREFIX . 'display_inside',
                Badge::DB_TBL_PREFIX . 'shape_type',
                Badge::DB_TBL_PREFIX . 'color',
                $recordIdsCol
            ],
            $recordFields
        );
        $srch->addMultipleFields($attr);
        $srch->joinBadge($langId);
        $srch->joinBadgeLinks();
        if (false === $linkRecords) {
            $srch->addGroupBy('blinkcond_id');
        }
        return $srch;
    }
    
    /**
     * isUnique
     *
     * @param  int $badgeType
     * @param  int $recordType
     * @param  int $record_id
     * @param  int $position
     * @return void
     */
    public static function isUnique(int $badgeType, int $recordType, int $record_id, int $position = 0): bool
    {
        return true; /* Require Discussion. */
        
        /* $srch = self::getBadgeLinksSearchObj(CommonHelper::getLangId());
        $srch->addFld('blinkcond_badge_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addBadgeTypeCondition([$badgeType]);
        $srch->addRecordTypesCondition([$recordType]);
        if (Badge::TYPE_RIBBON == $badgeType && 0 < $position) {
            $srch->addCondition('blinkcond_position', '=', $position);
        }
        $srch->addCondition('badgelink_record_id', '=', $record_id);
        $result = (array) FatApp::getDb()->fetch($srch->getResultSet());
        return (empty($result)); */
    }
}
