<?php

class PageLanguageData extends MyAppModel
{
    public const DB_TBL = 'tbl_pages_language_data';
    public const DB_TBL_PREFIX = 'plang_';

    public const WARNING_MSG_LENGTH = 255; /* Db column length. */

    public function __construct($plangKey = '')
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'key', $plangKey);
    }

    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'ep');
        return $srch;
    }

    public static function getAttributesByKey(string $key, int $langId = 0, $attr = null)
    {
        $key = FatUtility::convertToType($key, FatUtility::VAR_STRING);

        $srch = new SearchBase(static::DB_TBL);
        $srch->doNotCalculateRecords();

        if (0 < $langId) {
            $srch->setPageSize(1);
            $srch->addOrder('plang_lang_id', 'DESC');

            $cnd = $srch->addCondition(static::tblFld('lang_id'), '=', 'mysql_func_' . $langId, 'AND', true);
            $cnd->attachCondition(static::tblFld('lang_id'), '=', 'mysql_func_-1', 'OR', true);
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

    public function addUpdateData($data = array())
    {
        $assignValues = [
            static::DB_TBL_PREFIX . 'key' => $data['plang_key'],
            static::DB_TBL_PREFIX . 'lang_id' => $data['plang_lang_id'],
            static::DB_TBL_PREFIX . 'title' => $data['plang_title'],
            static::DB_TBL_PREFIX . 'summary' => $data['plang_summary'],
            static::DB_TBL_PREFIX . 'warring_msg' => $data['plang_warring_msg'],
            static::DB_TBL_PREFIX . 'recommendations' => $data['plang_recommendations'],
            static::DB_TBL_PREFIX . 'replacements' => $data['plang_replacements'],
            static::DB_TBL_PREFIX . 'helping_text' => $data['plang_helping_text'],
        ];

        if (!FatApp::getDb()->insertFromArray(static::DB_TBL, $assignValues, false, array(), $assignValues)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }
}
