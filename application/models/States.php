<?php

class States extends MyAppModel
{
    public const DB_TBL = 'tbl_states';
    public const DB_TBL_PREFIX = 'state_';

    public const DB_TBL_LANG = 'tbl_states_lang';
    public const DB_TBL_LANG_PREFIX = 'statelang_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($isActive = true, $langId = 0)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'st');

        if ($isActive == true) {
            $srch->addCondition('st.' . static::DB_TBL_PREFIX . 'active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'st_l.' . static::DB_TBL_LANG_PREFIX . 'state_id = st.' . static::tblFld('id') . ' and
			st_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'st_l'
            );
        }

        return $srch;
    }

    public static function requiredFields()
    {
        return array(
            ImportexportCommon::VALIDATE_POSITIVE_INT => array(
                'state_id',
                'state_country_id',
            ),
            ImportexportCommon::VALIDATE_NOT_NULL => array(
                'state_identifier',
                'country_code',
                'state_name',
                'state_code',
            ),
        );
    }

    public static function validateFields($columnIndex, $columnTitle, $columnValue, $langId)
    {
        $requiredFields = static::requiredFields();
        return ImportexportCommon::validateFields($requiredFields, $columnIndex, $columnTitle, $columnValue, $langId);
    }

    public static function getAttributesByIdentifierAndCountry($recordId, $countryId, $attr = array())
    {
        $recordId = FatUtility::convertToType($recordId, FatUtility::VAR_STRING);
        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL);
        $srch->addCondition(static::tblFld('identifier'), '=', $recordId);
        $srch->addCondition(static::tblFld('country_id'), '=', 'mysql_func_' . $countryId, 'AND', true);

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }

    public function getStatesByCountryId($countryId, $langId, $isActive = true, $idCol = 'state_id')
    {
        $langId = FatUtility::int($langId);
        $countryId = FatUtility::int($countryId);

        $srch = static::getSearchObject($isActive, $langId);
        $srch->addCondition('state_country_id', '=', 'mysql_func_' . $countryId, 'AND', true);
        if ('state_code' == $idCol) {
            $srch->addCondition('state_code', '!=', '');
        }

        if(!in_array($idCol,['state_code','state_country_id','state_identifier','state_id'])){
            $idCol = 'state_code';
        }
        
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder('state_name', 'ASC');
        $srch->addMultipleFields(
            array(
                $idCol,
                'IFNULL(state_name, state_identifier) as state_name'
            )
        );

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetchAllAssoc($rs);
        if (!is_array($row)) {
            return false;
        }
        return $row;
    }

    public static function getStateByCode($stateCode, $attr = null, int $countryId = 0)
    {
        if (!$stateCode) {
            return false;
        }
        
        $srch = static::getSearchObject();
        $srch->addCondition('state_code', '=', strtoupper($stateCode));
        if(0 < $countryId){
            $srch->addCondition('state_country_id', '=', $countryId);
        }

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }

    public static function getStateByCountryAndCode($countryId, $stateCode)
    {
        $countryId = FatUtility::int($countryId);
        if ($countryId < 1 || !$stateCode) {
            return false;
        }

        $srch = static::getSearchObject();
        $srch->addCondition('state_code', '=', strtoupper($stateCode));
        $srch->addCondition('state_country_id', '=', 'mysql_func_' . $countryId, 'AND', true);
        $srch->doNotCalculateRecords();
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    public static function getStateAttrByCountryIdAndName(int $countryId, string $stateName, int $langId, string $attr): string
    {
        $stateArr = self::getStateArrByCountryIdAndName($countryId, $stateName, $langId, [$attr]);
        return (string) (array_key_exists($attr, $stateArr) ? $stateArr[$attr] : '');
    }

    public static function getStateArrByCountryIdAndName(int $countryId, string $stateName, int $langId, array $attr = []): array
    {
        if (1 > $countryId || empty($stateName) || 1 > $langId) {
            return [];
        }

        $srch = static::getSearchObject(true, $langId);
        $srch->addCondition('state_name', '=', $stateName);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        return (is_array($row) ? $row : []);
    }
}
