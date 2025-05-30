<?php

class Faq extends MyAppModel
{
    public const DB_TBL = 'tbl_faqs';
    public const DB_TBL_LANG = 'tbl_faqs_lang';
    public const DB_TBL_PREFIX = 'faq_';
    public const DB_TBL_LANG_PREFIX = 'faqlang_';
    public const FAQS_SEARCH_STRING_LENGTH = 5;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0, $isDeleted = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'f');

        if ($isDeleted == true) {
            $srch->addCondition('f.' . static::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'f_l.' . static::DB_TBL_LANG_PREFIX . 'faq_id = f.' . static::tblFld('id') . ' and
			f_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'f_l'
            );
        }

        $srch->addOrder('f.' . static::DB_TBL_PREFIX . 'active', 'DESC');
        return $srch;
    }

    public function getMaxOrder()
    {
        $srch = new SearchBase(static::DB_TBL);
        $srch->addFld("MAX(" . static::DB_TBL_PREFIX . "display_order) as max_order");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        if (!empty($record)) {
            return $record['max_order'] + 1;
        }
        return 1;
    }
}
