<?php

class RatingType extends MyAppModel
{
    public const DB_TBL = 'tbl_rating_types';
    public const DB_TBL_PREFIX = 'rt_';

    public const DB_TBL_LANG = 'tbl_rating_types_lang';
    public const DB_TBL_LANG_PREFIX = 'rtlang_';
    
    /**
     * __construct
     *
     * @param  int $ratingTypeId
     * @return void
     */
    public function __construct(int $ratingTypeId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $ratingTypeId);
    }
    
    /**
     * getRatingTypes
     *
     * @param  int $langId
     * @param  array $attr
     * @return array
     */
    public static function getRatingTypes(int $langId = 0, array $attr = []): array
    {
        $srch = new RatingTypeSearch($langId);
        if (!empty($attr)) {
            $srch->addMultipleFields(['rt_id', 'rt_identifier']);
        }
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }
}
