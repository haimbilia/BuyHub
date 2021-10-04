<?php

class Language extends MyAppModel
{
    public const DB_TBL = 'tbl_languages';
    public const DB_TBL_PREFIX = 'language_';

    public function __construct($langId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $langId);
        $this->objMainTableRecord->setSensitiveFields(array());
    }

    public static function getSearchObject($isActive = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'l');

        if ($isActive == true) {
            $srch->addCondition('l.' . static::DB_TBL_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        }
        return $srch;
    }

    public static function getAllNames($assoc = true, $recordId = 0, $active = true, $deleted = false)
    {
        $cacheKey = $assoc . '-' . $recordId . '-' . $active . '-' . $deleted;
        $languageGetAllNames = CacheHelper::get('languageGetAllNames' .  $cacheKey, CONF_DEF_CACHE_TIME, '.txt');
        if ($languageGetAllNames) {
            return json_decode($languageGetAllNames, true);
        }

        $srch = new SearchBase(static::DB_TBL);
        $srch->addOrder(static::tblFld('id'));
        if ($active === true) {
            $srch->addCondition(static::DB_TBL_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        }

        if ($recordId > 0) {
            $srch->addCondition(static::tblFld('id'), '=', FatUtility::int($recordId));
        }

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        if ($assoc) {
            $srch->addMultipleFields(array(static::tblFld('id'), static::tblFld('name')));
            $langData = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        } else {
            $langData = FatApp::getDb()->fetchAll($srch->getResultSet(), static::tblFld('id'));
        }

        CacheHelper::create('languageGetAllNames' . $cacheKey, FatUtility::convertToJson($langData), CacheHelper::TYPE_LANGUAGE);
        return $langData;
    }

    public static function getAllCodesAssoc($withDefaultValue = false, $recordId = 0, $active = true, $deleted = false)
    {
        $cacheKey = $withDefaultValue . '-' . $recordId . '-' . $active . '-' . $deleted;
        $languageGetAllCodesAssoc = CacheHelper::get('languageGetAllCodesAssoc' .  $cacheKey, CONF_DEF_CACHE_TIME, CacheHelper::TYPE_LANGUAGE);
        if ($languageGetAllCodesAssoc) {
            return json_decode($languageGetAllCodesAssoc, true);
        }

        $srch = new SearchBase(static::DB_TBL);
        $srch->addOrder(static::tblFld('id'));
        if ($active === true) {
            $srch->addCondition('language_active', '=', applicationConstants::ACTIVE);
        }

        if ($recordId > 0) {
            $srch->addCondition(static::tblFld('id'), '=', FatUtility::int($recordId));
        }

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array(static::tblFld('id'), 'UPPER(' . static::tblFld('code') . ')'));
        $row = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        if ($withDefaultValue) {
            $row = array(0 => 'Universal') + $row;
        }

        CacheHelper::create('languageGetAllCodesAssoc' . $cacheKey, FatUtility::convertToJson($row), CacheHelper::TYPE_LANGUAGE);
        return $row;
    }

    public static function getLayoutDirection($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            trigger_error(Labels::getLabel('MSG_Language_Id_not_specified.', $langId), E_USER_ERROR);
        }

        $getLayoutDirection = CacheHelper::get('getLayoutDirection' .  $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($getLayoutDirection) {
            return json_decode($getLayoutDirection, true);
        }

        $langData = self::getAttributesById($langId, array('language_layout_direction'));
        if (false != $langData) {
            CacheHelper::create('getLayoutDirection' . $langId, FatUtility::convertToJson($langData['language_layout_direction']), CacheHelper::TYPE_LANGUAGE);
            return $langData['language_layout_direction'];
        }
    }
    
    /**
     * getDropDownList
     *
     * @param  mixed $langIdToRemove - default system lang
     * @return void
     */
    public static function getDropDownList(int $langIdToRemove = 0) : array
    {
        $arr = self::getAllNames();
        if (0 < $langIdToRemove) {
            unset($arr[$langIdToRemove]);
        }
        return $arr;
    }
}
