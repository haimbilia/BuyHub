<?php

class TaxCategoriesRuleController extends ListingBaseController {

    protected $modelClass = 'Tax';
    protected $pageKey = 'MANAGE_TAX_CATEGORIES_RULE';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewTax();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditTax($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditTax();
        }
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_TAX_CATEGORIES_RULE', $this->siteLangId);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageData['plang_title'] ?? LibHelper::getControllerName(true));
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($fields));
        $this->set('actionItemsData', HtmlHelper::getDefaultActionItems($fields, $this->modelObj));
        $this->getListingData();
        $this->_template->addCss(['css/select2.min.css']);
        $this->_template->addJs([
            'js/cropper.js',
            'js/cropper-main.js',
            'js/select2.js',
            'tax-categories-requests/page-js/index.js'
        ]);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'taxrule_name');
        }
        $frm->addHiddenField('', 'taxrule_taxcat_id');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tax-categories-rule/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = TaxRule::getSearchObject();
        $srch->joinTable(TaxRule::DB_RATES_TBL, 'INNER JOIN', TaxRule::tblFld('id') . '=' . TaxRule::DB_RATES_TBL_PREFIX . TaxRule::tblFld('id') . ' and ' . TaxRule::DB_RATES_TBL_PREFIX . 'user_id = 0');
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxstr_id = taxrule_taxstr_id');
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = ' . $this->siteLangId);
        $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'trr_rate', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxrule_taxcat_id'));
        if (!empty($post['keyword'])) {
            $srch->addCondition('taxrule_name', 'LIKE', "%" . $post['keyword'] . "%");
        }

        if (!empty($post['taxrule_taxcat_id'])) {
            $srch->addCondition('taxrule_taxcat_id', '=', $post['taxrule_taxcat_id']);
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
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

    public function form() {
        $this->objPrivilege->canEditTax();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 < $recordId) {
            $taxObj = new TaxRule($recordId);
            $data = $taxObj->getRule($this->siteLangId); 
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
            $ruleLocations = $taxObj->getLocations($data['taxrule_taxcat_id']);
        }
        $this->set('languages', []);
        $this->set('ruleLocations', $ruleLocations ?? []);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void {
        $this->objPrivilege->canEditBrandRequests();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_TAX_CATEGORIES_SETUP', $this->siteLangId));
        $this->checkMediaExist = false;
    }

    public function setup() {
        $this->objPrivilege->canEditTax();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $recordId = $post['taxcat_id'];
        unset($post['taxcat_id']);
        $data = $post;
        $data['taxcat_identifier'] = $data['taxcat_name'];
        $tax = new Tax($recordId);
        $tax->assignValues($data);
        if (!$tax->save()) {
            LibHelper::exitWithError($tax->getError(), true);
        }
        $this->setLangData($tax, [$tax::tblFld('name') => $post[$tax::tblFld('name')]]);
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $tax->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord() {
        $this->objPrivilege->canEditTax();
        $post = FatApp::getPostedData();
        if ($post == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['recordId']);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $taxObj = new Tax($recordId);
        $taxObj->assignValues(array('taxcat_deleted' => applicationConstants::YES));
        if (!$taxObj->save()) {
            LibHelper::exitWithError($taxObj->getError(), true);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getLangForm($recordId = 0, $lang_id = 0) {
        $frm = new Form('frmTaxLang', array('id' => 'frmTaxLang'));
        $frm->addHiddenField('', 'taxcat_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $lang_id);
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_CATEGORY_NAME', $this->siteLangId), 'taxcat_name');
        return $frm;
    }

    protected function getForm() {
        $this->objPrivilege->canEditTax();
        $frm = new Form('frmTaxRule');
        $frm->addHiddenField('', 'taxrule_taxcat_id');

        /* [ TAX CATEGORY RULE FORM */
        $frm->addHiddenField('', 'taxrule_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_RULE_NAME', $this->siteLangId), 'taxrule_name');
        $fld = $frm->addFloatField(Labels::getLabel('FRM_TAX_RATE(%)', $this->siteLangId), 'trr_rate', '');
        $fld->requirements()->setPositive();

        $taxStructures = TaxStructure::getAllAssoc($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELECT_TAX', $this->siteLangId), 'taxrule_taxstr_id', $taxStructures, '', array(), Labels::getLabel('FRM_Select_Tax', $this->siteLangId));
        $fld->requirements()->setRequired();
        /* ] */

        /* [ TAX CATEGORY RULE LOCATIONS FORM */
        $countryObj = new Countries();
        $countriesOptions = $countryObj->getCountriesAssocArr($this->siteLangId, true);
        $countriesOptions = array(-1 => Labels::getLabel('FRM_REST_OF_THE_WORLD', $this->siteLangId)) + $countriesOptions;
        array_walk($countriesOptions, function (&$v) {
            $v = str_replace("'", "\'", trim($v));
        });

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_FROM_COUNTRY', $this->siteLangId), 'taxruleloc_from_country_id', $countriesOptions, '', array(), Labels::getLabel('FRM_SELECT_COUNTRY', $this->siteLangId));
        $fld->requirements()->setRequired();
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_FROM_STATE', $this->siteLangId), 'taxruleloc_from_state_id[]', array(), '', array(), '');
        $fld->requirements()->setRequired();

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TO_COUNTRY', $this->siteLangId), 'taxruleloc_to_country_id', $countriesOptions, '', array(), Labels::getLabel('FRM_SELECT_COUNTRY', $this->siteLangId));
        $fld->requirements()->setRequired();
        $locattionTypeOtions = TaxRule::getTypeOptions($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TO_STATE_TYPE', $this->siteLangId), 'taxruleloc_type', $locattionTypeOtions, '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->requirements()->setRequired();
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TO_STATES', $this->siteLangId), 'taxruleloc_to_state_id[]', array(), '', array(), '');
        $fld->requirements()->setRequired();
        /* ] */

        /* [ TAX GROUP RULE COMBINED DETAILS FORM */
        $frm->addHiddenField('', 'combinedTaxDetails');
        /* ] */
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        $frm->addHTML('', 'space','');
        $frm->addHtml('', 'space','');
        return $frm;
    }

    protected function getFormColumns(): array {
        $taxTblHeadingCols = CacheHelper::get('taxTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($taxTblHeadingCols) {
            return json_decode($taxTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'taxrule_name' => Labels::getLabel('LBL_RULE_NAME', $this->siteLangId),
            'trr_rate' => Labels::getLabel('LBL_TAX_RATE(%)', $this->siteLangId),
            'taxstr_name' => Labels::getLabel('LBL_TAX_STRUCTURE_NAME', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('taxTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'taxrule_name',
            'trr_rate',
            'taxstr_name',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['trr_rate', 'taxstr_name'], Common::excludeKeysForSort());
    }

}
