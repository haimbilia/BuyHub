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
    
    public const REC_COND_MANUAL = 1;
    public const REC_COND_AUTO = 2;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'badge_id',
        self::DB_TBL_PREFIX . 'user_id',
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
        $arr = FatCache::get('getBadgeLinkRecordTypeArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::RECORD_TYPE_SELLER_PRODUCT => Labels::getLabel('LBL_SELLER_PRODUCT', $langId),
                self::RECORD_TYPE_PRODUCT => Labels::getLabel('LBL_PRODUCT', $langId),
                self::RECORD_TYPE_SHOP => Labels::getLabel('LBL_SHOP', $langId)
            ];
            FatCache::set('getBadgeLinkRecordTypeArr' . $langId, FatUtility::convertToJson($arr), '.txt');
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getConditionTypesArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getConditionTypesArr(int $langId): array
    {
        $arr = FatCache::get('getBadgeLinkConditionTypesArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::COND_TYPE_AVG_RATING_SELPROD => Labels::getLabel('LBL_AVERAGE_RATING_SELLER_PRODUCT_(%)', $langId),
                self::COND_TYPE_AVG_RATING_SHOP => Labels::getLabel('LBL_AVERAGE_RATING_SHOP_(%)', $langId),
                self::COND_TYPE_ORDER_COMPLETION_RATE => Labels::getLabel('LBL_ORDER_COMPLETION_RATE_(%)', $langId),
                self::COND_TYPE_COMPLETED_ORDERS => Labels::getLabel('LBL_COMPLETED_ORDERS', $langId),
                self::COND_TYPE_RETURN_ACCEPTANCE => Labels::getLabel('LBL_RETURN/_REFUND_ACCEPTANCE_RATE_(%)', $langId),
                self::COND_TYPE_ORDER_CANCELLED => Labels::getLabel('LBL_ORDER_CANCELLED_BY_SELLER_(%)', $langId),
            ];
            FatCache::set('getBadgeLinkConditionTypesArr' . $langId, FatUtility::convertToJson($arr), '.txt');
            return $arr;
        }

        return json_decode($arr, true);
    }

    /**
     * getRecordConditionArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getRecordConditionArr(int $langId): array
    {
        $arr = FatCache::get('getBadgeLinkRecordConditionArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::REC_COND_MANUAL => Labels::getLabel('LBL_MANUAL', $langId),
                self::REC_COND_AUTO => Labels::getLabel('LBL_AUTOMATIC', $langId),
            ];
            FatCache::set('getBadgeLinkRecordConditionArr' . $langId, FatUtility::convertToJson($arr), '.txt');
            return $arr;
        }

        return json_decode($arr, true);
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
                        THEN GROUP_CONCAT(option_name SEPARATOR "|")
                    ELSE ""
                END) as option_name',
                '(CASE 
                        WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '  
                            THEN GROUP_CONCAT(optionvalue_name SEPARATOR "|")
                        ELSE ""
                END) as option_value_name',
                '(CASE
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_PRODUCT . ' 
                        THEN pu.credential_username
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '
                        THEN spu.credential_username
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . '
                        THEN shpu.credential_username
                    ELSE ""
                END) as seller',
                '(CASE
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_PRODUCT . ' 
                        THEN pu.credential_user_id
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT . '
                        THEN spu.credential_user_id
                    WHEN ' . BadgeLinkCondition::DB_TBL_PREFIX . 'record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP . '
                        THEN shpu.credential_user_id
                    ELSE ""
                END) as seller_id'
            ];
        }

        $recordIdsCol = (false === $linkRecords) ? 'GROUP_CONCAT(badgelink_record_id) as badgelink_record_ids' : 'badgelink_record_id';

        $attr = array_merge(
            self::ATTR,
            [
                'COALESCE(' . Badge::DB_TBL_PREFIX . 'name, ' . Badge::DB_TBL_PREFIX . 'identifier) as ' . Badge::DB_TBL_PREFIX . 'name',
                'blnku.user_name as cond_seller_name',
                Badge::DB_TBL_PREFIX . 'type',
                Badge::DB_TBL_PREFIX . 'display_inside',
                Badge::DB_TBL_PREFIX . 'shape_type',
                Badge::DB_TBL_PREFIX . 'color',
                Badge::DB_TBL_PREFIX . 'required_approval',
                $recordIdsCol
            ],
            $recordFields
        );
        $srch->addMultipleFields($attr);
        $srch->joinUser();
        $srch->joinBadge($langId);
        $srch->joinBadgeLinks();
        if (false === $linkRecords) {
            $srch->addGroupBy('blinkcond_id');
        }
        return $srch;
    }
    
    /**
     * isUnique : Used for Badge
     *
     * @param  int $badgeId
     * @param  int $userId
     * @param  int $recordType
     * @param  int $position
     * @param  int $badgeLinkCondId : Other than this id.
     * @return void
     */
    public static function isUnique(int $badgeId, int $userId, int $recordType, int $position = 0, int $badgeLinkCondId = 0): bool
    {
        $srch = new BadgeSearch();
        $srch->setPageSize(1);
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'LEFT JOIN', 'blinkcond_badge_id = badge_id');
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id');
        $srch->addCondition('badge_id', '=', $badgeId);
        $srch->addCondition('badge_condition_type', '=', Badge::COND_MANUAL);
        $srch->addCondition('blinkcond_user_id', '=', $userId);
        $srch->addCondition('blinkcond_record_type', '=', $recordType);
        $srch->addCondition('blinkcond_position', '=', $position);
        if (0 < $badgeLinkCondId) {
            $srch->addCondition('blinkcond_id', '!=', $badgeLinkCondId);
        }
        $srch->addDirectCondition('(
            CASE 
                WHEN breq_id IS NOT NULL
                THEN breq_status = ' . BadgeRequest::REQUEST_APPROVED . ' OR breq_status = ' . BadgeRequest::REQUEST_PENDING . '
                ELSE TRUE
            END
        )');
        $srch->getResultSet();
        return (1 > $srch->recordCount());
    }
    
    /**
     * getApprovalRequestBadges
     *
     * @param  int $langId
     * @param  bool $assoc
     * @return array
     */
    public static function getApprovalRequestBadges(int $langId, bool $assoc = true): array
    {
        $srch = new BadgeSearch($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        $srch->joinTable(self::DB_TBL, 'LEFT JOIN', 'blc.blinkcond_badge_id =  bdg.badge_id', 'blc');
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id');
        $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=', Badge::TYPE_BADGE);
        $srch->addCondition(Badge::DB_TBL_PREFIX . 'condition_type', '=', Badge::COND_MANUAL);
        $srch->addCondition(Badge::DB_TBL_PREFIX . 'required_approval', '=', applicationConstants::YES);
      
        $srch->addDirectCondition('(
            CASE
                WHEN (
                        (blinkcond_id > 0 AND breq_id IS NULL)
                        OR
                        (breq_status = 1 AND breq_user_id = ' . UserAuthentication::getLoggedUserId() . ') 
                    )
                THEN FALSE
                ELSE TRUE
            END
        )');
        
        $badgeNameField = "COALESCE(badge_name, badge_identifier) badge_name";


        $srch->addGroupBy(Badge::DB_TBL_PREFIX . 'id');
        $srch->addOrder(Badge::DB_TBL_PREFIX . 'id', 'DESC');
        if (true === $assoc) {
            $srch->addMultipleFields([
                    'badge_id',
                    $badgeNameField
                ]
            );
            return (array) FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        }

        $srch->addMultipleFields(array_merge(self::ATTR, [$badgeNameField]));
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }
}
