<?php

class TaxController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewTax();
        $this->rewriteUrl = Brand::REWRITE_URL_PREFIX;
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm(false, $fields);
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_TAX_CATEGORIES', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->_template->render();
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'taxcat_identifier');
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tax/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $data = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = Tax::getSearchObject($this->siteLangId, false, false);
        $srch->addCondition('taxcat_deleted', '=', 0);
        $activatedTaxServiceId = Tax::getActivatedServiceId();
        $srch->addCondition('taxcat_plugin_id', '=', $activatedTaxServiceId);
        $srch->addMultipleFields([
            't.*', 't_l.taxcat_name'
        ]);

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('t.taxcat_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('t_l.taxcat_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cnd->attachCondition('t.taxcat_code', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
    }

    public function setup()
    {
        $this->objPrivilege->canEditTax();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $taxcat_id = $post['taxcat_id'];
        unset($post['taxcat_id']);

        $record = new Tax($taxcat_id);
        if (!$record->addUpdateData($post)) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        if ($taxcat_id == 0) {
            $taxcat_id = $record->getMainTableRecordId();
        }

        $newTabLangId = 0;
        if ($taxcat_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Tax::getAttributesByLangId($langId, $taxcat_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $taxcat_id = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('taxcatId', $taxcat_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditTax();
        $post = FatApp::getPostedData();

        $taxcat_id = $post['taxcat_id'];
        $lang_id = $post['lang_id'];

        if ($taxcat_id == 0 || $lang_id == 0) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $frm = $this->getLangForm($taxcat_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['taxcat_id']);
        unset($post['lang_id']);

        $data = array(
            'taxcatlang_taxcat_id' => $taxcat_id,
            'taxcatlang_lang_id' => $lang_id,
            'taxcat_name' => $post['taxcat_name'],
        );

        $taxObj = new Tax($taxcat_id);
        if (!$taxObj->updateLangData($lang_id, $data)) {
            Message::addErrorMessage($taxObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Tax::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($taxcat_id)) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Tax::getAttributesByLangId($langId, $taxcat_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('taxcatId', $taxcat_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function form($taxcat_id = 0)
    {
        $this->objPrivilege->canEditTax();

        $taxcat_id = FatUtility::int($taxcat_id);
        $frm = $this->getForm($taxcat_id);

        if (0 < $taxcat_id) {
            $taxObj = new Tax($taxcat_id);
            $srch = $taxObj->getSearchObject($this->siteLangId, false);

            $srch->addCondition('taxcat_id', '=', $taxcat_id);
            $srch->addMultipleFields(array('t.*', 't_l.taxcat_name'));

            $rs = $srch->getResultSet();
            $data = FatApp::getDb()->fetch($rs);

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }

            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('taxcat_id', $taxcat_id);
        $this->set('frmTax', $frm);
        $this->_template->render(false, false);
    }

    public function langForm($taxcat_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canEditTax();

        $taxcat_id = FatUtility::int($taxcat_id);
        $lang_id = FatUtility::int($lang_id);

        if ($taxcat_id == 0 || $lang_id == 0) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $taxLangFrm = $this->getLangForm($taxcat_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Tax::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($taxcat_id, $lang_id);
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = Tax::getAttributesByLangId($lang_id, $taxcat_id);
        }

        if ($langData) {
            $taxLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('taxcat_id', $taxcat_id);
        $this->set('taxcat_lang_id', $lang_id);
        $this->set('taxLangFrm', $taxLangFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditTax();

        $taxCatId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if (1 > $taxCatId) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->markAsDeleted($taxCatId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditTax();
        $taxcatIdsArr = FatUtility::int(FatApp::getPostedData('taxcat_ids'));

        if (empty($taxcatIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($taxcatIdsArr as $taxcat_id) {
            if (1 > $taxcat_id) {
                continue;
            }
            $this->markAsDeleted($taxcat_id);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($taxcat_id)
    {
        $taxcat_id = FatUtility::int($taxcat_id);
        if (1 > $taxcat_id) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $taxtObj = new Tax($taxcat_id);
        if (!$taxtObj->canRecordMarkDelete($taxcat_id)) {
            $msg = Labels::getLabel('MSG_PLEASE_UNLINK_ALL_THE_PRODUCTS_FIRST', $this->siteLangId);
            Message::addErrorMessage($msg);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $taxtObj->assignValues(array(Tax::tblFld('deleted') => 1));
        if (!$taxtObj->save()) {
            Message::addErrorMessage($taxtObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        if (!$this->deleteGroupData($taxcat_id)) {
            Message::addErrorMessage(Labels::getLabel('LBL_Unable_to_delete_group_old_data', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
    }

    /*  public function changeStatus()
    {
        $this->objPrivilege->canEditTax();
        $taxcatId = FatApp::getPostedData('taxcatId', FatUtility::VAR_INT, 0);
        if (0 >= $taxcatId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $data = Tax::getAttributesById($taxcatId, array('taxcat_id', 'taxcat_active'));

        if ($data == false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $status = ($data['taxcat_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updateTaxStatus($taxcatId, $status);

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    } */

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditTax();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $taxcatIdsArr = FatUtility::int(FatApp::getPostedData('taxcat_ids'));
        if (empty($taxcatIdsArr) || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($taxcatIdsArr as $taxcatId) {
            if (1 > $taxcatId) {
                continue;
            }

            $this->updateTaxStatus($taxcatId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateTaxStatus($taxcatId, $status)
    {
        $status = FatUtility::int($status);
        $taxcatId = FatUtility::int($taxcatId);
        if (1 > $taxcatId || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        $obj = new Tax($taxcatId);
        if (!$obj->changeStatus($status)) {
            Message::addErrorMessage($obj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    private function getLangForm($taxcat_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmTaxLang');
        $frm->addHiddenField('', 'taxcat_id', $taxcat_id);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Tax_Category_Name', $this->siteLangId), 'taxcat_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Update', $this->siteLangId));
        return $frm;
    }

    private function getForm($taxcat_id = 0)
    {
        $this->objPrivilege->canEditTax();
        $taxcat_id = FatUtility::int($taxcat_id);

        $frm = new Form('frmTax');
        $frm->addHiddenField('', 'taxcat_id', $taxcat_id);
        $frm->addRequiredField(Labels::getLabel('LBL_Tax_Category_Identifier', $this->siteLangId), 'taxcat_identifier');

        $activatedTaxServiceId = Tax::getActivatedServiceId();

        if ($activatedTaxServiceId) {
            $frm->addHiddenField('', 'taxcat_plugin_id', $activatedTaxServiceId)->requirements()->setRequired();
        }

        if ($activatedTaxServiceId || FatApp::getConfig('CONF_TAX_CATEGORIES_CODE', FatUtility::VAR_INT, 1)) {
            $frm->addRequiredField(Labels::getLabel('LBL_Tax_Code', $this->siteLangId), 'taxcat_code');
        }

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'taxcat_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    public function autoCompleteTaxCategories()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();
        $this->objPrivilege->canViewTax();
        $srch = Tax::getSearchObject($this->siteLangId, true);
        $srch->addCondition('taxcat_deleted', '=', 0);
        $activatedTaxServiceId = Tax::getActivatedServiceId();

        $srch->addFld('taxcat_id');
        if ($activatedTaxServiceId) {
            $srch->addFld('concat(IFNULL(taxcat_name,taxcat_identifier), " (",taxcat_code,")")as taxcat_name');
        } else {
            $srch->addFld('IFNULL(taxcat_name,taxcat_identifier)as taxcat_name');
        }
        $srch->addCondition('taxcat_plugin_id', '=', $activatedTaxServiceId);

        if (!empty($post['keyword'])) {
            $srch->addCondition('taxcat_name', 'LIKE', '%' . $post['keyword'] . '%')
                ->attachCondition('taxcat_identifier', 'LIKE', '%' . $post['keyword'] . '%')
                ->attachCondition('taxcat_code', 'LIKE', '%' . $post['keyword'] . '%');
        }
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $taxCategories = $db->fetchAll($rs, 'taxcat_id');
        $json = array();
        $defaultStringLength = applicationConstants::DEFAULT_STRING_LENGTH;
        foreach ($taxCategories as $key => $taxCategory) {
            $taxCatName = strip_tags(html_entity_decode($taxCategory['taxcat_name'], ENT_QUOTES, 'UTF-8'));
            $taxCatName1 = substr($taxCatName, 0, $defaultStringLength);
            if ($defaultStringLength < strlen($taxCatName)) {
                $taxCatName1 .= '...';
            }
            $json[] = array(
                'id' => $key,
                'name' => $taxCatName1
            );
        }
        die(json_encode($json));
    }

    public function ruleList($taxCatId)
    {
        $this->objPrivilege->canViewTax();
        $data = Tax::getAttributesById($taxCatId);
        if (empty($data)) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $frmSearch = $this->getRuleListSearchForm($taxCatId);
        $this->set('taxCategory', $data['taxcat_identifier']);
        $this->set('taxCatId', $taxCatId);
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }

    public function ruleListSearch()
    {
        $this->objPrivilege->canViewTax();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getRuleListSearchForm();
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : $post['page'];

        $srch = TaxRule::getSearchObject();
        $srch->joinTable(TaxRule::DB_RATES_TBL, 'INNER JOIN', TaxRule::tblFld('id') . '=' . TaxRule::DB_RATES_TBL_PREFIX . TaxRule::tblFld('id') . ' and ' . TaxRule::DB_RATES_TBL_PREFIX . 'user_id = 0');
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxstr_id = taxrule_taxstr_id');
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = ' . $this->siteLangId);
        $srch->addCondition('taxrule_taxcat_id', '=', $post['taxrule_taxcat_id']);
        $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'trr_rate', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxrule_taxcat_id'));

        if (!empty($post['keyword'])) {
            $srch->addCondition('taxrule_name', 'LIKE', "%" . $post['keyword'] . "%");
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->addOrder('taxrule_name', 'ASC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);

        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    private function getRuleListSearchForm($taxCatId = 0)
    {
        $frm = new Form('frmRuleListSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->siteLangId), 'keyword');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'taxrule_taxcat_id', $taxCatId);
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function ruleForm($taxCatId, $taxRuleId = 0)
    {
        $this->objPrivilege->canEditTax();
        $taxCatId = FatUtility::int($taxCatId);
        $taxRuleId = FatUtility::int($taxRuleId);

        $frm = $this->getRuleForm($taxCatId);

        $taxObj = new TaxRule($taxRuleId);
        $ruleLocations = [];
        $ruleData = $taxObj->getRule($this->siteLangId);
        if (!empty($ruleData)) {
            $frm->fill($ruleData);
            $ruleLocations = $taxObj->getLocations($taxCatId);
        }
        $this->set('ruleLocations', $ruleLocations);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setupTaxRule()
    {
        $this->objPrivilege->canEditTax();
        $frm = $this->getRuleForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $post['taxruleloc_to_state_id'] = FatApp::getPostedData('taxruleloc_to_state_id');
        $post['taxruleloc_from_state_id'] = FatApp::getPostedData('taxruleloc_from_state_id');

        $combinedTaxDetails = (isset($post['combinedTaxDetails'])) ? $post['combinedTaxDetails'] : [];

        if (!empty($combinedTaxDetails)) {
            $totalCombinedTax = 0;
            array_walk($combinedTaxDetails, function ($value) use (&$totalCombinedTax) {
                $totalCombinedTax += $value['taxruledet_rate'];
            });
            if ($totalCombinedTax != $post['trr_rate']) {
                Message::addErrorMessage(Labels::getLabel('LBL_INVALID_COMBINED_TAX_COMBINATION', $this->siteLangId));
                FatUtility::dieJsonError(Message::getHtml());
            }
        }
        /* validate state country combination */
        $this->validateStateCountry($post);

        $taxRuleObj = new TaxRule($post['taxrule_id']);
        unset($post['taxrule_id']);
        $taxRuleObj->assignValues($post);
        if (!$taxRuleObj->save()) {
            Message::addErrorMessage($taxRuleObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        $ruleId = $taxRuleObj->getMainTableRecordId();

        if (!$taxRuleObj->addUpdateRate($post['trr_rate'])) {
            FatUtility::dieJsonError($taxRuleObj->getError());
        }

        /* [ update location data */
        if (!$this->addUpdateLocationData($ruleId, $post)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Unable_to_Update_Location_Data', $this->siteLangId));
        }
        /* ] */

        /* [ UPDATE COMBINED TAX DETAILS */
        if (!$this->addUpdateCombinedData($combinedTaxDetails, $ruleId)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Unable_to_Update_Combined_Tax_Data', $this->siteLangId));
        }
        /* ] */

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function validateStateCountry($post)
    {
        $catLocations = TaxRuleLocation::getLocationsByCatId($post['taxrule_taxcat_id']);
        if (!$catLocations) {
            return;
        }
        $combination = [];
        foreach ($catLocations as $location) {
            if ($post['taxrule_id'] != $location['taxruleloc_taxrule_id']) {
                $combination[] = $location['taxruleloc_from_country_id'] . "-" . $location['taxruleloc_from_state_id'] . "-" . $location['taxruleloc_to_country_id'] . "-" . $location['taxruleloc_to_state_id'] . "-" . $location['taxruleloc_type'];
            }
        }
        foreach ($post['taxruleloc_from_state_id'] as $fromState) {
            if (count($post['taxruleloc_from_state_id']) > 1 && $fromState == -1) {
                continue;
            }
            foreach ($post['taxruleloc_to_state_id'] as $toState) {
                if (count($post['taxruleloc_to_state_id']) > 1 && $toState == -1) {
                    continue;
                }
                $isUnique = 1;
                if ($post['taxruleloc_type'] == TaxRule::TYPE_EXCLUDE_STATES) {
                    $isUnique = null;
                }
                $key = $post['taxruleloc_from_country_id'] . "-" . $fromState . "-" . $post['taxruleloc_to_country_id'] . "-" . $toState . "-" . $post['taxruleloc_type'] . "-" . $isUnique;
                if (in_array($key, $combination)) {
                    Message::addErrorMessage(Labels::getLabel('LBL_COMBINATION_OF_COUNTRY_STATE_AND_STATE_TYPE_ALREADY_EXIST_IN_CATEGORY', $this->siteLangId));
                    FatUtility::dieJsonError(Message::getHtml());
                }
            }
        }
    }

    public function deleteRule()
    {
        $this->objPrivilege->canEditTax();
        $ruleId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if (1 > $ruleId) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $taxRule = new TaxRule($ruleId);
        if (!$taxRule->deleteRelatedRecord()) {
            FatUtility::dieJsonError($taxRule->getError());
        }

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    private function getRuleForm($taxCatId = 0)
    {
        $frm = new Form('frmTaxRule');
        $frm->addHiddenField('', 'taxrule_taxcat_id', $taxCatId);

        /* [ TAX CATEGORY RULE FORM */
        $frm->addHiddenField('', 'taxrule_id', 0);
        $frm->addRequiredField(Labels::getLabel('LBL_Rule_Name', $this->siteLangId), 'taxrule_name');
        $fld = $frm->addFloatField(Labels::getLabel('LBL_Tax_Rate(%)', $this->siteLangId), 'trr_rate', '');
        $fld->requirements()->setPositive();


        $taxStructures = TaxStructure::getAllAssoc($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_Select_Tax', $this->siteLangId), 'taxrule_taxstr_id', $taxStructures, '', array(), Labels::getLabel('LBL_Select_Tax', $this->siteLangId));
        $fld->requirements()->setRequired();
        /* ] */

        /* [ TAX CATEGORY RULE LOCATIONS FORM */
        $countryObj = new Countries();
        $countriesOptions = $countryObj->getCountriesAssocArr($this->siteLangId, true);
        $countriesOptions = array(-1 => Labels::getLabel('LBL_Rest_of_the_world', $this->siteLangId)) + $countriesOptions;
        array_walk($countriesOptions, function (&$v) {
            $v = str_replace("'", "\'", trim($v));
        });

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_FROM_COUNTRY', $this->siteLangId), 'taxruleloc_from_country_id', $countriesOptions, '', array(), Labels::getLabel('LBL_Select_Country', $this->siteLangId));
        $fld->requirements()->setRequired();
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_FROM_STATE', $this->siteLangId), 'taxruleloc_from_state_id[]', array(), '', array(), '');
        $fld->requirements()->setRequired();

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_TO_COUNTRY', $this->siteLangId), 'taxruleloc_to_country_id', $countriesOptions, '', array(), Labels::getLabel('LBL_Select_Country', $this->siteLangId));
        $fld->requirements()->setRequired();
        $locattionTypeOtions = TaxRule::getTypeOptions($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_TO_STATE_TYPE', $this->siteLangId), 'taxruleloc_type', $locattionTypeOtions, '', array(), Labels::getLabel('LBL_Select', $this->siteLangId));
        $fld->requirements()->setRequired();
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_TO_STATES', $this->siteLangId), 'taxruleloc_to_state_id[]', array(), '', array(), '');
        $fld->requirements()->setRequired();
        /* ] */

        /* [ TAX GROUP RULE COMBINED DETAILS FORM */
        $frm->addHiddenField('', 'combinedTaxDetails');
        /* ] */

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save', $this->siteLangId));
        $frm->addButton("", "btn_discard", Labels::getLabel('LBL_Discard', $this->siteLangId));

        return $frm;
    }

    private function addUpdateLocationData($ruleId, $post)
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
                    /*'taxruleloc_unique' => $isUnique*/
                );

                if (!$locObj->updateLocations($data)) {
                    return false;
                }
            }
        }
        return true;
    }

    private function addUpdateCombinedData($combinedTaxes, $ruleId)
    {
        if (!empty($combinedTaxes)) {
            $taxRuleObj = new TaxRule($ruleId);
            if (!$taxRuleObj->deleteCombinedTaxes()) {
                return false;
            }
            foreach ($combinedTaxes as $combinedTax) {
                if (!$taxRuleObj->addUpdateCombinedTax($combinedTax)) {
                    echo $taxRuleObj->getError();
                    return false;
                }
            }
        }
        return true;
    }

    public function getCombinedTaxes($taxStrId, $ruleId = 0)
    {
        $taxStrId = FatUtility::int($taxStrId);
        $ruleId = FatUtility::int($ruleId);

        $taxStructure = new TaxStructure($taxStrId);
        $combTaxes = $taxStructure->getCombinedTaxesByParent($this->siteLangId, $ruleId);

        $this->set('taxStrId', $taxStrId);
        $this->set('combTaxes', $combTaxes);
        $this->_template->render(false, false);
    }

    protected function getFormColumns(): array
    {
        $taxTblHeadingCols = CacheHelper::get('taxTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($taxTblHeadingCols) {
            return json_decode($taxTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'taxcat_identifier' => Labels::getLabel('LBL_CATEGORY_NAME', $this->siteLangId),
            'taxcat_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('taxTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'taxcat_identifier',
            'taxcat_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['taxcat_active'], Common::excludeKeysForSort());
    }
}
