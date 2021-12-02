<?php

class PageLanguageData extends MyAppModel
{
    public const DB_TBL = 'tbl_pages_language_data';
    public const DB_TBL_PREFIX = 'plang_';

    public function __construct($id)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getAttributesByKey(string $key, int $langId = 0, $attr = null)
    {
        $key = FatUtility::convertToType($key, FatUtility::VAR_STRING);

        $srch = new SearchBase(static::DB_TBL);
        $srch->doNotCalculateRecords();

        if (0 < $langId) {
            $srch->setPageSize(1);
            $srch->addOrder('plang_lang_id', 'DESC');

            $cnd = $srch->addCondition(static::tblFld('lang_id'), '=', $langId);
            $cnd->attachCondition(static::tblFld('lang_id'), '=', -1);
        }

        $srch->addCondition(static::tblFld('key'), '=', $key);


        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $row = FatApp::getDb()->fetch($srch->getResultSet());

        if (!is_array($row)) {
            return [];
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }
}
