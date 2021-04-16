<?php

class RatingType extends MyAppModel
{
    public const DB_TBL = 'tbl_rating_types';
    public const DB_TBL_PREFIX = 'ratingtype_';

    public const DB_TBL_LANG = 'tbl_rating_types_lang';
    public const DB_TBL_LANG_PREFIX = 'ratingtypelang_';

    public const TYPE_PRODUCT = 1;
    public const TYPE_SHOP = 2;
    public const TYPE_DELIVERY = 3;
    public const TYPE_OTHER = 4;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'identifier',
        self::DB_TBL_PREFIX . 'type',
        self::DB_TBL_PREFIX . 'active',
        self::DB_TBL_PREFIX . 'default'
    ];

    public const LANG_ATTR = [
        self::DB_TBL_LANG_PREFIX . 'lang_id',
        self::DB_TBL_PREFIX . 'name'
    ];

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
            self::TYPE_PRODUCT => Labels::getLabel('LBL_PRODUCT', $langId),
            self::TYPE_SHOP => Labels::getLabel('LBL_SHOP', $langId),
            self::TYPE_DELIVERY => Labels::getLabel('LBL_DELIVERY', $langId),
            self::TYPE_OTHER => Labels::getLabel('LBL_OTHER', $langId),
        ];
    }
}
