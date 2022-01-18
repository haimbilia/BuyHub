<?php

class HelpCenter extends MyAppModel
{
    public const DB_TBL = 'tbl_help_center';
    public const DB_TBL_LANG = 'tbl_help_center_lang';
    public const DB_TBL_PREFIX = 'hc_';
    public const DB_TBL_LANG_PREFIX = 'hclang_';

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'user_type',
        self::DB_TBL_PREFIX . 'controller',
        self::DB_TBL_PREFIX . 'action',
        self::DB_TBL_PREFIX . 'default_title',
        self::DB_TBL_PREFIX . 'default_description'
    ];

    public const LANG_ATTR = [
        self::DB_TBL_LANG_PREFIX . 'lang_id',
        self::DB_TBL_LANG_PREFIX . 'title',
        self::DB_TBL_LANG_PREFIX . 'description'
    ];

    public const USER_TYPE_ADMIN = 0;
    public const USER_TYPE_SELLER = 1;

    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    /**
     * getUserTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getUserTypeArr(int $langId): array
    {
        $arr = CacheHelper::get('getUserTypeArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::USER_TYPE_ADMIN => Labels::getLabel('LBL_ADMIN', $langId),
                self::USER_TYPE_SELLER => Labels::getLabel('LBL_SELLER', $langId)
            ];
            CacheHelper::create('getUserTypeArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
            return $arr;
        }

        return json_decode($arr, true);
    }
}
