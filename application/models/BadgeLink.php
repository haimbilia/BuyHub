<?php

class BadgeLink extends MyAppModel
{
    public const DB_TBL = 'tbl_badge_links';
    public const DB_TBL_PREFIX = 'badgelink_';

    public const RECORD_TYPE_PRODUCT = 1;
    public const RECORD_TYPE_SELLER_PRODUCT = 2;
    public const RECORD_TYPE_SHOP = 3;

    public const COND_TYPE_DATE = 1;
    public const COND_TYPE_AVG_RATING = 2;
    public const COND_TYPE_ORDER_COMPLETION_RATE = 3;
    public const COND_TYPE_COMPLETED_ORDERS = 4;
    public const COND_TYPE_RETURN_ACCEPTANCE = 5; // Refund/Return Acceptance
    public const COND_TYPE_ORDER_CANCELLED = 6; // Cancelled By Seller
    
    public const REC_COND_AUTO = 1;
    public const REC_COND_MANUAL = 2;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'badge_id',
        self::DB_TBL_PREFIX . 'record_ids',
        self::DB_TBL_PREFIX . 'record_type',
        self::DB_TBL_PREFIX . 'from_date',
        self::DB_TBL_PREFIX . 'to_date',
        self::DB_TBL_PREFIX . 'condition_type',
        self::DB_TBL_PREFIX . 'condition_from',
        self::DB_TBL_PREFIX . 'condition_to'
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
            self::RECORD_TYPE_PRODUCT => Labels::getLabel('LBL_PRODUCT', $langId),
            self::RECORD_TYPE_SELLER_PRODUCT => Labels::getLabel('LBL_SELLER_PRODUCT', $langId),
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
            self::COND_TYPE_AVG_RATING => Labels::getLabel('LBL_AVERAGE_RATING', $langId),
            self::COND_TYPE_ORDER_COMPLETION_RATE => Labels::getLabel('LBL_ORDER_COMPLETION_RATE_(%)', $langId),
            self::COND_TYPE_COMPLETED_ORDERS => Labels::getLabel('LBL_COMPLETED_ORDERS', $langId),
            self::COND_TYPE_RETURN_ACCEPTANCE => Labels::getLabel('LBL_RETURN/_REFUND_ACCEPTANCE_RATE_(%)', $langId),
            self::COND_TYPE_ORDER_CANCELLED => Labels::getLabel('LBL_ORDER_CANCELLED_BY_SELLER', $langId),
            
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
            self::REC_COND_AUTO => Labels::getLabel('LBL_AUTOMATICALLY', $langId),
            self::REC_COND_MANUAL => Labels::getLabel('LBL_MANUALLY', $langId)
        ];
    }
    
    /**
     * getBadgeLinksSearchObj
     *
     * @param  int $langId
     * @return object
     */
    public static function getBadgeLinksSearchObj(int $langId): object
    {
        $srch = new BadgeLinkSearch($langId);
        $attr = array_merge(
            self::ATTR,
            [
                Badge::DB_TBL_PREFIX . 'name',
                Badge::DB_TBL_PREFIX . 'type',
                Badge::DB_TBL_PREFIX . 'shape_type',
                Badge::DB_TBL_PREFIX . 'color',
            ]
        );
        $srch->addMultipleFields($attr);
        $srch->joinBadge($langId);
        $srch->addGroupBy('badgelink_id');
        return $srch;
    }
}
