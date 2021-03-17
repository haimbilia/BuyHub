<?php
class TaxRule extends MyAppModel
{
    const DB_TBL = 'tbl_tax_rules';
    const DB_TBL_PREFIX = 'taxrule_';
    
    const DB_RATES_TBL = 'tbl_tax_rule_rates';
    const DB_RATES_TBL_PREFIX = 'trr_';
    
    const DB_DETAIL_TBL = 'tbl_tax_rule_details';
    const DB_DETAIL_TBL_PREFIX = 'taxruledet_';

    const TYPE_ALL_STATES = -1;
    const TYPE_INCLUDE_STATES = 1;
    const TYPE_EXCLUDE_STATES = 2;

    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    /**
    * getSearchObject
    *
    * @return object
    */
    public static function getSearchObject(): object
    {
        $srch = new SearchBase(static::DB_TBL, 'taxRule');        
        return $srch;
    }
    
    /**
     * 
     * @return object
     */
    public static function getCombinedTaxSearchObject(): object
    {
        $srch = new SearchBase(static::DB_DETAIL_TBL, 'tc');        
        return $srch;
    }

    /**
    * getTypeOptions
    *
    * @param  int $langId
    * @return array
    */
    public static function getTypeOptions(int $langId): array
    {
        return array(
            self::TYPE_ALL_STATES => Labels::getLabel('LBL_ALL_STATES', $langId),
            self::TYPE_INCLUDE_STATES => Labels::getLabel('LBL_INCLUDE_STATES', $langId),
            self::TYPE_EXCLUDE_STATES => Labels::getLabel('LBL_EXCLUDE_STATES', $langId),
        );
    } 
    
    /**
     * 
     * @param int $langId
     * @return array
     */
    public function getRule(int $langId, int $userId = 0): array
    {
        $srch = TaxRule::getSearchObject();
        $srch->joinTable(TaxRule::DB_RATES_TBL, 'INNER JOIN', TaxRule::tblFld('id') . '=' . TaxRule::DB_RATES_TBL_PREFIX . TaxRule::tblFld('id'));
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxstr_id = taxrule_taxstr_id');
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = ' . $langId);
        $srch->addCondition('taxrule_id', '=', $this->getMainTableRecordId());
        if (0 < $userId) {
            $srch->addCondition(TaxRule::DB_RATES_TBL_PREFIX . 'user_id', '=', $userId);
        }
        $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'taxrule_taxcat_id', 'taxrule_taxstr_id', 'trr_rate', 'taxstr_id', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxstr_parent', 'taxstr_is_combined'));
        return (array) FatApp::getDb()->fetch($srch->getResultSet());
    }

    public function deleteRelatedRecord(): bool
    {

        if (1 > $this->mainTableRecordId) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        if (!FatApp::getDb()->deleteRecords(
                        self::DB_TBL,
                        array(
                            'smt' => self::DB_TBL_PREFIX . 'id=? ',
                            'vals' => array($this->getMainTableRecordId())
                        )
                )) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        if (!FatApp::getDb()->deleteRecords(
                        self::DB_RATES_TBL,
                        array(
                            'smt' => self::DB_RATES_TBL_PREFIX . self::DB_TBL_PREFIX . 'id=? ',
                            'vals' => array($this->getMainTableRecordId())
                        )
                )) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        $locObj = new TaxRuleLocation();
        if (!$locObj->deleteLocations($this->getMainTableRecordId())) {
            $this->error = $locObj->getError();
            return false;
        }

        if (!FatApp::getDb()->deleteRecords(
                        self::DB_DETAIL_TBL,
                        array(
                            'smt' => self::DB_DETAIL_TBL_PREFIX . 'taxrule_id = ?',
                            'vals' => array($this->getMainTableRecordId())
                        )
                )) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        return true;
    }

    public static function getRulesByCatId(int $taxCatId, int $langId): array
    {
        $srch = TaxRule::getSearchObject();
        $srch->joinTable(TaxRule::DB_RATES_TBL, 'LEFT OUTER JOIN', TaxRule::tblFld('id') . '=' . TaxRule::DB_RATES_TBL_PREFIX . TaxRule::tblFld('id') . ' and ' . TaxRule::DB_RATES_TBL_PREFIX . 'user_id = 0');
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxstr_id = taxrule_taxstr_id');
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = '.$langId);
        $srch->addCondition('taxrule_taxcat_id', '=', $taxCatId);       
        $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'taxrule_taxcat_id', 'taxrule_taxstr_id', 'trr_rate', 'taxstr_id', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxstr_parent', 'taxstr_is_combined'));
        $res = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($res);      
    }
    
    /**
    * getCombinedRuleDetails
    *
    * @param  array $rulesIds
    * @param int $langId
    * @return array
    */
    public function getCombinedRuleDetails(array $rulesIds, int $langId): array
    {
        if (empty($rulesIds)) {
            return [];
        }
        $srch = TaxRule::getCombinedTaxSearchObject();
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxruledet_taxstr_id = taxstr_id');
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxruledet_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = '.$langId);
        $srch->addCondition('taxruledet_taxrule_id', 'IN', $rulesIds);
        $srch->addMultipleFields(array('taxstr_id', 'taxruledet_taxrule_id','taxruledet_user_id','taxruledet_rate', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxstr_parent'));
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $combinedData = FatApp::getDb()->fetchAll($rs);
        return self::groupDataByKey($combinedData, 'taxruledet_taxrule_id');
    } 
    
    /**
     * 
     * @return array
     */
    public function getLocations(): array
    {
        $srch = TaxRuleLocation::getSearchObject();        
        $srch->addCondition('taxruleloc_taxrule_id', '=', $this->getMainTableRecordId());
        return FatApp::getDb()->fetchAll($srch->getResultSet());        
    }
    
    /**
     * 
     * @param int $taxCatId
     * @param bool $joinCountryState
     * @param type $langId
     * @return array
     */
    public static function getLocationsByCatId(int $taxCatId = 0,  bool $joinCountryState = false, $langId = 0): array
    {
        $srch = TaxRuleLocation::getSearchObject();        
        $srch->addCondition('taxruleloc_taxcat_id', '=', $taxCatId);        
        if ($joinCountryState) {
            $srch->joinTable(States::DB_TBL, 'LEFT OUTER JOIN', 'taxruleloc_from_state_id = from_st.state_id', 'from_st');
            $srch->joinTable(States::DB_TBL_LANG, 'LEFT OUTER JOIN', 'from_st.state_id = from_st_l.statelang_state_id AND from_st_l.statelang_lang_id = ' . $langId, 'from_st_l');

            $srch->joinTable(Countries::DB_TBL, 'LEFT OUTER JOIN', 'taxruleloc_to_country_id = from_c.country_id', 'from_c');
            $srch->joinTable(Countries::DB_TBL_LANG, 'LEFT OUTER JOIN', 'from_c.country_id = from_c_l.countrylang_country_id AND from_c_l.countrylang_lang_id = ' . $langId, 'from_c_l');
            
            $srch->joinTable(States::DB_TBL, 'LEFT OUTER JOIN', 'taxruleloc_to_state_id = to_st.state_id', 'to_st');
            $srch->joinTable(States::DB_TBL_LANG, 'LEFT OUTER JOIN', 'to_st.state_id = to_st_l.statelang_state_id AND to_st_l.statelang_lang_id = ' . $langId, 'to_st_l');

            $srch->joinTable(Countries::DB_TBL, 'LEFT OUTER JOIN', 'taxruleloc_to_country_id = to_c.country_id', 'to_c');
            $srch->joinTable(Countries::DB_TBL_LANG, 'LEFT OUTER JOIN', 'to_c.country_id = to_c_l.countrylang_country_id AND to_c_l.countrylang_lang_id = ' . $langId, 'to_c_l');

            $srch->addMultipleFields(array('taxruleloc_taxcat_id', 'taxruleloc_taxrule_id', 'taxruleloc_to_country_id', 'taxruleloc_to_state_id', 'taxruleloc_type', 'taxruleloc_unique', 'IFNULL(from_c_l.country_name, from_c.country_code) as from_country_name','IFNULL(to_c_l.country_name, to_c.country_code) as to_country_name', 'IFNULL(from_st_l.state_name, from_st.state_identifier) as from_state_name','IFNULL(to_st_l.state_name, to_st.state_identifier) as to_state_name'));
        }
        $locationsData = FatApp::getDb()->fetchAll($srch->getResultSet());      
        return self::groupDataByKey($locationsData, 'taxruleloc_taxrule_id');
    }
    
    /**
     * 
     * @param type $rate
     * @param type $userId
     * @return bool
     */
    public function addUpdateRate($rate, $userId = 0): bool
    {
        if (1 > $this->mainTableRecordId) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }
        $dataToSave = [
            'trr_taxrule_id' => $this->getMainTableRecordId(),
            'trr_rate' => $rate,
            'trr_user_id' => $userId
        ];

        if (!FatApp::getDb()->insertFromArray(self::DB_RATES_TBL, $dataToSave, true, array(), $dataToSave)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
    * groupDataByKey
    *
    * @param  array $data
    * @param  string $key
    * @return array
    */
    
    public static function groupDataByKey(array $data, string $key): array
    {
        $groupedData = [];
        if (!empty($data)) {
            foreach ($data as $val) {
                $groupedData[$val[$key]][] = $val;
            }
        }
        return $groupedData;
    }
    
    
    /**
     * 
     * @param int $userId
     * @return bool
     */  
    public function deleteCombinedTaxes(int $userId = 0): bool
    {
        if (1 > $this->mainTableRecordId) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        if (!FatApp::getDb()->deleteRecords(
                        self::DB_DETAIL_TBL,
                        array(
                            'smt' => self::DB_DETAIL_TBL_PREFIX . 'taxrule_id = ? and ' . self::DB_DETAIL_TBL_PREFIX . 'user_id = ?',
                            'vals' => array($this->getMainTableRecordId(), $userId)
                        )
                )) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }
    
    /**
     * 
     * @param array $data
     * @param int $userId
     * @return bool
     */
    public function addUpdateCombinedTax(array $data, int $userId = 0): bool
    {
        if (1 > $this->mainTableRecordId || !isset($data['taxruledet_taxstr_id']) || !isset($data['taxruledet_rate']) || 1 > $data['taxruledet_taxstr_id']) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $dataToSave = [
            'taxruledet_taxrule_id' => $this->mainTableRecordId,
            'taxruledet_taxstr_id' => $data['taxruledet_taxstr_id'],
            'taxruledet_rate' => $data['taxruledet_rate'],
            'taxruledet_user_id' => $userId,
        ];

        if (!FatApp::getDb()->insertFromArray(self::DB_DETAIL_TBL, $dataToSave, true, array(), $dataToSave)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

}
