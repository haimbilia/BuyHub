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
        return new SearchBase(static::DB_TBL, 'taxRule');
    }

    /**
     * 
     * @return object
     */
    public static function getCombinedTaxSearchObject(): object
    {
        return new SearchBase(static::DB_DETAIL_TBL, 'tc');
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
        $srch->addCondition('taxrule_id', '=', 'mysql_func_' . $this->getMainTableRecordId(), 'AND', true);
        $srch->addCondition(TaxRule::DB_RATES_TBL_PREFIX . 'user_id', '=', 'mysql_func_' . $userId, 'AND', true);
        $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'taxrule_taxcat_id', 'taxrule_taxstr_id', 'trr_rate', 'taxstr_id', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxstr_parent', 'taxstr_is_combined'));
        $srch->doNotCalculateRecords();
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return (is_array($row) ? $row : []);
    }

    /**
     * 
     * @return bool
     */
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

    /**
     * 
     * @param int $taxCatId
     * @param int $langId
     * @return array
     */
    public static function getRulesByCatId(int $taxCatId, int $langId = 0): array
    {
        $srch = TaxRule::getSearchObject();
        $srch->joinTable(TaxRule::DB_RATES_TBL, 'LEFT OUTER JOIN', TaxRule::tblFld('id') . '=' . TaxRule::DB_RATES_TBL_PREFIX . TaxRule::tblFld('id') . ' and ' . TaxRule::DB_RATES_TBL_PREFIX . 'user_id = 0');
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxstr_id = taxrule_taxstr_id');
        if (1 > $langId) {
            $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = ' . $langId);
            $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'taxrule_taxcat_id', 'taxrule_taxstr_id', 'trr_rate', 'taxstr_id', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxstr_parent', 'taxstr_is_combined'));
        }
        $srch->addCondition('taxrule_taxcat_id', '=', 'mysql_func_' . $taxCatId, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    /**
     * 
     * @return array
     */
    public function getLocations(): array
    {
        $srch = TaxRuleLocation::getSearchObject();
        $srch->addCondition('taxruleloc_taxrule_id', '=', 'mysql_func_' . $this->getMainTableRecordId(), 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAll($srch->getResultSet());
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

    public function addUpdateLocationData($ruleId, $post)
    {
        $locObj = new TaxRuleLocation();
        if (!$locObj->deleteLocations($ruleId)) {
            return false;
        }
        foreach ($post['taxruleloc_from_state_id'] as $fromState) {
            /* [ excluding all state if other states exist */
            if (count($post['taxruleloc_from_state_id']) > 1 && $fromState == -1) {
                continue;
            }
            /* ] */

            foreach ($post['taxruleloc_to_state_id'] as $toState) {
                /* [ excluding all state if other states exist */
                if (count($post['taxruleloc_to_state_id']) > 1 && $toState == -1) {
                    continue;
                }
                /* ] */

                $isUnique = 1;
                if ($post['taxruleloc_type'] == TaxRule::TYPE_EXCLUDE_STATES) {
                    $isUnique = null;
                }
                $data = array(
                    'taxruleloc_taxcat_id' => $post['taxrule_taxcat_id'],
                    'taxruleloc_taxrule_id' => $ruleId,
                    'taxruleloc_from_country_id' => $post['taxruleloc_from_country_id'],
                    'taxruleloc_from_state_id' => $fromState,
                    'taxruleloc_to_country_id' => $post['taxruleloc_to_country_id'],
                    'taxruleloc_to_state_id' => $toState,
                    'taxruleloc_type' => $post['taxruleloc_type'],
                    /* 'taxruleloc_unique' => $isUnique */
                );

                if (!$locObj->updateLocations($data)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function addUpdateCombinedData($combinedTaxes, $ruleId)
    {
        if (!empty($combinedTaxes)) {
            $taxRuleObj = new TaxRule($ruleId);
            if (!$taxRuleObj->deleteCombinedTaxes()) {
                return false;
            }
            foreach ($combinedTaxes as $combinedTax) {
                if (!$taxRuleObj->addUpdateCombinedTax($combinedTax)) {
                    $this->error = $taxRuleObj->getError();
                    return false;
                }
            }
        }
        return true;
    }
}
