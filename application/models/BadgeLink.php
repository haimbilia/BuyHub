<?php

class BadgeLink extends MyAppModel
{
    public const DB_TBL = 'tbl_badge_links';
    public const DB_TBL_PREFIX = 'badgelink_';

    public const RECORD_TYPE_PRODUCT = 1;
    public const RECORD_TYPE_SELLER_PRODUCT = 2;
    public const RECORD_TYPE_SHOP = 3;

    public const CONDITION_TYPE_DATE = 1;
    public const CONDITION_TYPE_ORDER = 2;
    public const CONDITION_TYPE_RATING = 3;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'badge_id',
        self::DB_TBL_PREFIX . 'record_id',
        self::DB_TBL_PREFIX . 'record_type',
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
            self::CONDITION_TYPE_DATE => Labels::getLabel('LBL_DATE', $langId),
            self::CONDITION_TYPE_ORDER => Labels::getLabel('LBL_ORDER', $langId),
            self::CONDITION_TYPE_RATING => Labels::getLabel('LBL_RATING', $langId),
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
}
