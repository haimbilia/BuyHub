<?php
class MyHelper extends FatModel
{
    static function getLanguages($key = 'language_id')
    {
        $srch = new SearchBase("tbl_language");
        $srch->doNotCalculateRecords();
        $srch->addCondition("language_status", "=", 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs, $key);
    }

    static function getLangFields($condition_id = 0, $condition_field = "", $condition_lang_field = "", $lang_flds = array(), $lang_table = "")
    {
        if ($condition_id == 0 || $condition_field == "" || $condition_lang_field == "" || $lang_table == "" || empty($lang_flds)) {
            return array();
        }
        $langs = Self::getLanguages();
        $array = array();
        $srch = new SearchBase($lang_table);
        $srch->addCondition($condition_field, '=', $condition_id); 
        $srch->doNotCalculateRecords();      
        $record = FatApp::getDb()->fetchAll($srch->getResultSet());
        foreach ($langs as $lang) {
            foreach ($record as $rec) {
                if ($rec[$condition_lang_field] == $lang['language_id']) {
                    foreach ($lang_flds as $fld) {
                        $array[$fld][$lang['language_id']] = $rec[$fld];
                        $array[$fld . $lang['language_id']] = $rec[$fld];
                    }
                    continue;
                }
            }
        }
        return $array;
    }

    static function getDefaultLangId()
    {
        return 1;
    }
}
