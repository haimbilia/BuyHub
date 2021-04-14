<?php

class RatingType extends MyAppModel
{
    public const DB_TBL = 'tbl_rating_types';
    public const DB_TBL_PREFIX = 'ratingtype_';

    public const DB_TBL_LANG = 'tbl_rating_types_lang';
    public const DB_TBL_LANG_PREFIX = 'ratingtypelang_';


    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'identifier',
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
}
