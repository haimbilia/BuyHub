<?php

class TaxStructure extends MyAppModel
{

    public const DB_TBL = 'tbl_tax_structure';
    public const DB_TBL_PREFIX = 'taxstr_';
    public const DB_TBL_LANG = 'tbl_tax_structure_lang';
    public const DB_TBL_LANG_PREFIX = 'taxstrlang_';
    public const TYPE_SINGLE = 1;
    public const TYPE_COMBINED = 2;

    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    /**
     * getSearchObject
     *
     * @return object
     */
    public static function getSearchObject($langId = 0)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'ts');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'ts_l.' . static::DB_TBL_LANG_PREFIX . 'taxstr_id = ts.' . static::tblFld('id') . ' and
			ts_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'ts_l'
            );
        }
        return $srch;
    }

    /**
     * getAllAssoc
     *
     * @param  int $langId
     * @param  bool $onlyParent
     * @return array
     */
    public static function getAllAssoc($langId, $onlyParent = true): array
    {
        $langId = FatUtility::int($langId);
        $srch = static::getSearchObject($langId);
        $srch->addMultipleFields(array('taxstr_id', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name'));
        if ($onlyParent) {
            $srch->addCondition('taxstr_parent', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        }
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
    }

    /**
     * getCombinedTaxes
     *
     * @param  int $parentId
     * @return array
     */
    public function getCombinedTaxes($parentId): array
    {
        $parentId = FatUtility::int($parentId);
        $srch = static::getSearchObject();
        $srch->addMultipleFields(array('taxstr_id'));
        $srch->addCondition('taxstr_parent', '=', 'mysql_func_' . $parentId, 'AND', true);
        $srch->addOrder('taxstr_id', 'ASC');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $combinedTaxes = FatApp::getDb()->fetchAll($srch->getResultSet());

        $languages = Language::getAllNames();
        $combinedTaxStructure = [];
        $row = 0;
        foreach ($combinedTaxes as $val) {
            foreach ($languages as $langId => $lang) {
                $taxLangData = $this->getAttributesByLangId($langId, $val['taxstr_id']);
                if (!empty($taxLangData)) {
                    $combinedTaxStructure[$row][$langId] = $taxLangData['taxstr_name'];
                }
            }
            $row++;
        }
        return $combinedTaxStructure;
    }

    /**
     * getCombinedTaxes
     *
     * @param  int $parentId
     * @return object
     */
    public function getCombinedTaxesForLang($parentId, $langId): array
    {
        $parentId = FatUtility::int($parentId);
        $langId = FatUtility::int($langId);
        $srch = static::getSearchObject();
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxstr_id=taxstrlang_taxstr_id', 'taxLang');
        $srch->addMultipleFields(array('taxstr_id', 'taxstr_name'));
        $srch->addCondition('taxstr_parent', '=', 'mysql_func_' . $parentId, 'AND', true);
        $srch->addCondition('taxstrlang_lang_id', '=', 'mysql_func_' . $langId, 'AND', true);
        $srch->addOrder('taxstrlang_taxstr_id', 'ASC');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
    }

    /**
     * getCombinedTaxes
     *
     * @param  int $parentId
     * @return object
     */
    public function getCombinedTax($parentId): array
    {
        $parentId = FatUtility::int($parentId);
        $srch = static::getSearchObject();
        $srch->addMultipleFields(array('taxstr_id', 'taxstr_identifier'));
        $srch->addCondition('taxstr_parent', '=', 'mysql_func_' . $parentId, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
    }

    /**
     * getCombinedTaxes
     *
     * @param  int $parentId
     * @return object
     */
    /* @@ todo We have to modifiy the current procress for tax component */
    public function getCombinedTaxesWithLang($parentId, $data = []): array
    {
        $parentId = FatUtility::int($parentId);
        $srch = static::getSearchObject();
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxstr_id=taxstrlang_taxstr_id', 'taxLang');
        $srch->addCondition('taxstr_parent', '=', 'mysql_func_' . $parentId, 'AND', true);
        if (isset($data['deleted_taxstr_id']) && !empty(array_filter($data['deleted_taxstr_id']))) {
            $srch->addCondition('taxstr_id', 'NOT IN', array_filter($data['deleted_taxstr_id']));
        }
        $srch->addOrder('taxstr_id', 'ASC');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $results = FatApp::getDb()->fetchAll($srch->getResultSet());
        $unSortcomponent = [];
        $postComponents = $data['taxstr_component_name'] ?? [];
        $postLang = $data['lang_id'] ?? '';
        foreach ($results as $key => $result) {
            $unSortcomponent[$result['taxstr_id']][$result['taxstrlang_lang_id']] = $result['taxstr_name'];
        }
        $component = [];
        $i = 0;
        foreach ($unSortcomponent as $values) {
            $component[$i++] = $values;
        }

        foreach ($results as $result) {
            $components['taxstr_name'][$result['taxstrlang_lang_id']] = $result['taxstr_name'];
        }

        $count = 1;
        foreach ($postComponents as $key => $postComponent) {
            $component[$key][$postLang] = $postComponent[$postLang] ?? $count;
            $components['taxstr_name'][$postLang] = $data['taxstr_name'];
            $count++;
        }
        $components['taxstr_component_name'] = $component;
        return $components;
    }

    /**
     * 
     * @param int $langId
     * @param int $ruleId
     * @param int $userId
     * @return array
     */
    public function getCombinedTaxesByParent(int $langId, int $ruleId, int $userId = 0): array
    {
        $srch = static::getSearchObject($langId);
        $srch->joinTable(TaxRule::DB_DETAIL_TBL, 'LEFT JOIN', 'taxruledet_taxstr_id = taxstr_id and taxruledet_taxrule_id = ' . $ruleId . ' and taxruledet_user_id =' . $userId);
        $srch->addMultipleFields(array('taxstr_id', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxruledet_rate'));
        $srch->addCondition('taxstr_parent', '=', 'mysql_func_' . $this->mainTableRecordId, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    /**
     * getForm
     *
     * @param  int $langId
     * @param  int $taxStrId
     * @return object
     */
    public static function getForm($langId, $taxStrId = 0)
    {
        $taxStrId = FatUtility::int($taxStrId);

        $frm = new Form('frmTaxStructure');
        $frm->addHiddenField('', 'taxstr_id', $taxStrId);
        $frm->addCheckBox(Labels::getLabel('FRM_COMBINED_TAX', $langId), 'taxstr_is_combined', 1);

        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $languages = Language::getAllNames();
        foreach ($languages as $languageId => $lang) {
            if ($languageId == $siteDefaultLangId) {
                $frm->addRequiredField(Labels::getLabel('FRM_TAX_NAME', $languageId), 'taxstr_name[' . $languageId . ']');
            } else {
                $frm->addTextBox(Labels::getLabel('FRM_TAX_NAME', $languageId), 'taxstr_name[' . $languageId . ']');
            }
            $frm->addTextBox(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $languageId), 'taxstr_component_name[0][' . $languageId . ']');
            /* if (0 < $taxStrId) {
              $combinedTaxes = $taxStructure->getCombinedTaxes($taxStrId);
              foreach($combinedTaxes as $combTaxCount => $combinedTax){
              $frm->addTextBox(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $languageId), 'taxstr_component_name['.$combTaxCount.'][' . $languageId . ']');
              }
              } else {
              if ($languageId == $siteDefaultLangId) {
              $frm->addRequiredField(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $languageId), 'taxstr_component_name[0][' . $languageId . ']');
              } else {
              $frm->addTextBox(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $languageId), 'taxstr_component_name[0][' . $languageId . ']');
              }
              } */
        }

        /* $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
          unset($languages[$siteDefaultLangId]);
          if (!empty($translatorSubscriptionKey) && count($languages) > 0) {
          $frm->addCheckBox(Labels::getLabel('FRM_TRANSLATE_TO_OTHER_LANGUAGES', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
          } */

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $langId));
        return $frm;
    }

    /**
     * addUpdateData
     *
     * @param  array $post
     * @return bool
     */
    public function addUpdateData($post): bool
    {
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (empty($post)) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $siteDefaultLangId);
            return false;
        }

        unset($post['taxstr_id']);

        $data = [
            'taxstr_identifier' => $post['taxstr_name'][$siteDefaultLangId],
            'taxstr_parent' => 0,
            'taxstr_is_combined' => isset($post['taxstr_is_combined']) ? $post['taxstr_is_combined'] : 0,
        ];
        $this->assignValues($data);
        if (!$this->save()) {
            $this->error = $this->getError();
            return false;
        }

        $autoUpdateOtherLangsData = isset($post['auto_update_other_langs_data']) ? FatUtility::int($post['auto_update_other_langs_data']) : 0;
        foreach ($post['taxstr_name'] as $langId => $taxStrName) {
            $data = array(
                static::DB_TBL_LANG_PREFIX . 'taxstr_id' => $this->mainTableRecordId,
                static::DB_TBL_LANG_PREFIX . 'lang_id' => $langId,
                'taxstr_name' => $taxStrName,
            );

            if (!$this->updateLangData($langId, $data)) {
                $this->error = $this->getError();
                return false;
            }

            if ($autoUpdateOtherLangsData > 0) {
                $this->saveTranslatedLangData();
            }
        }

        if (!isset($post['taxstr_is_combined']) || !$post['taxstr_is_combined']) {
            return true;
        }
        $parentId = $this->mainTableRecordId;
        if (!$this->addUpdateCombinedData($post, $parentId)) {
            $this->error = $this->getError();
            return false;
        }

        return true;
    }

    /**
     * addUpdateCombinedData
     *
     * @param  array $post
     * @return bool
     */
    public function addUpdateCombinedData($post, $parentId): bool
    {
        $parentId = FatUtility::int($parentId);
        $siteDefaultLangId = CommonHelper::getDefaultFormLangId();

        unset($post['taxstr_id']);

        $db = FatApp::getDb();
        if ($parentId > 0) {
            $components = $this->getCombinedTax($parentId);
            if (!$db->deleteRecords(static::DB_TBL, array('smt' => 'taxstr_parent = ?', 'vals' => array($parentId)))) {
                $this->error = $db->getError();
                return false;
            }
            foreach ($components as $key => $component) {
                $db->deleteRecords(static::DB_TBL_LANG, array('smt' => 'taxstrlang_taxstr_id = ?', 'vals' => array($key)));
            }
        }

        foreach ($post['taxstr_component_name'] as $taxStrValues) {
            $taxStrValues = array_filter($taxStrValues);
            if (empty($taxStrValues[$siteDefaultLangId])) {
                continue;
            }
            $this->mainTableRecordId = 0;
            $data = array(
                'taxstr_identifier' => $taxStrValues[$siteDefaultLangId],
                'taxstr_parent' => $parentId,
                'taxstr_is_combined' => 0
            );

            $this->assignValues($data);
            if (!$this->save()) {
                $this->error = $this->getError();
                return false;
            }
            $autoUpdateOtherLangsData = isset($post['auto_update_other_langs_data']) ? FatUtility::int($post['auto_update_other_langs_data']) : 0;
            foreach ($taxStrValues as $langId => $taxStrName) {
                $data = array(
                    static::DB_TBL_LANG_PREFIX . 'taxstr_id' => $this->mainTableRecordId,
                    static::DB_TBL_LANG_PREFIX . 'lang_id' => $langId,
                    'taxstr_name' => $taxStrName,
                );
                if (!$this->updateLangData($langId, $data)) {
                    $this->error = $this->getError();
                    return false;
                }

                if ($autoUpdateOtherLangsData > 0) {
                    $this->saveTranslatedLangData();
                }
            }
        }
        return true;
    }

    /**
     * addUpdateCombinedData
     *
     * @param  array $post
     * @return bool
     */
    public function addUpdateCombinedTax($post, $parentId, $langId): bool
    {
        $parentId = FatUtility::int($parentId);
        if (!FatApp::getDb()->deleteRecords(static::DB_TBL, array('smt' => 'taxstr_parent = ?', 'vals' => array($parentId)))) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        foreach ($post['taxstr_component_name'] as $key => $taxStrValues) {
            if (empty($taxStrValues)) {
                continue;
            }


            $data = array(
                static::DB_TBL_LANG_PREFIX . 'taxstr_id' => $this->mainTableRecordId,
                static::DB_TBL_LANG_PREFIX . 'lang_id' => $langId,
                'taxstr_name' => $taxStrValues,
            );
            if (!$this->updateLangData($langId, $data)) {
                $this->error = $this->getError();
                return false;
            }
        }
        return true;
    }

    /**
     * saveTranslatedLangData
     *
     * @return bool
     */
    public function saveTranslatedLangData(): bool
    {
        if ($this->mainTableRecordId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $translateLangobj = new TranslateLangData(static::DB_TBL_LANG);
        if (false === $translateLangobj->updateTranslatedData($this->mainTableRecordId)) {
            $this->error = $translateLangobj->getError();
            return false;
        }
        return true;
    }

    /**
     * getTranslatedData
     *
     * @param  mixed $data
     * @param  int $toLangId
     * @return void
     */
    public function getTranslatedData($data, $toLangId)
    {
        $toLangId = FatUtility::int($toLangId);
        if (empty($data) || $toLangId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $translateLangobj = new TranslateLangData(static::DB_TBL_LANG);
        $translatedData = $translateLangobj->directTranslate($data, $toLangId);
        if (false === $translatedData) {
            $this->error = $translateLangobj->getError();
            return false;
        }
        return $translatedData;
    }

    public static function getDefaultTaxStructureId()
    {

        $srch = self::getSearchObject();
        $srch->addCondition('taxstr_is_combined', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $srch->addFld('taxstr_id');
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {

            $taxStrName = Labels::getLabel('LBL_STRUCTURE_SINGLE_TYPE', CommonHelper::getLangId());
            /* [ CREATE DEFAULT TAX STRUCTURE */
            $dataToInsert = array(
                'taxstr_identifier' => $taxStrName,
                'taxstr_parent' => 0,
                'taxstr_is_combined' => 0,
            );
            $obj = new TaxStructure();
            $obj->assignValues($dataToInsert);
            if (!$obj->save()) {
                Message::addErrorMessage($obj->getError());
            }
            $data = array(
                static::DB_TBL_LANG_PREFIX . 'taxstr_id' => $obj->mainTableRecordId,
                static::DB_TBL_LANG_PREFIX . 'lang_id' => CommonHelper::getLangId(),
                'taxstr_name' => $taxStrName,
            );
            if (!$obj->updateLangData(CommonHelper::getLangId(), $data)) {
                Message::addErrorMessage($obj->getError());
            }
            return $obj->getMainTableRecordId();
        }
        return $row['taxstr_id'];
    }
}
