<?php

class TaxStructureController extends ListingBaseController {

    protected $modelClass = 'TaxStructure';
    protected $pageKey = 'MANAGE_TAX_STRUCTURE';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewTax();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->setModel();
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_TAX_STRUCTURE', $this->siteLangId);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageData['plang_title'] ?? LibHelper::getControllerName(true));
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('actionItemsData', HtmlHelper::getDefaultActionItems($fields, $this->modelObj));
        $this->getListingData();
        $this->_template->addJs([
            'tax-structure/page-js/index.js'
        ]);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tax-structure/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();
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
        $srchFrm = $this->getSearchForm($fields);
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = TaxStructure::getSearchObject($this->siteLangId);
        $srch->addCondition('taxstr_parent', '=', 0);
        $srch->addMultipleFields(array('ts.*', 'ts_l.*'));
        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('taxstr_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('taxstr_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set("arrListing", $db->fetchAll($srch->getResultSet()));
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

    protected function setLangTemplateData(array $constructorArgs = []): void {
        $this->objPrivilege->canEditTax();
        $this->setModel();
        $this->formLangFields = [
            $this->modelObj::tblFld('name'),
            $this->modelObj::tblFld('is_combined')
        ];
        $this->set('formTitle', Labels::getLabel('LBL_TAX_STRUCTURE_SETUP', $this->siteLangId)); 
    }

    /**
     * getForm
     *
     * @param  int $langId
     * @param  int $taxStrId
     * @return object
     */
    public function getForm($taxStrId = 0) {
        $frm = new Form('frmTaxStructure', array('id' => 'frmTaxStructure'));
        $frm->addHiddenField('', 'taxstr_id', FatUtility::int($taxStrId));
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_NAME', $this->siteLangId), 'taxstr_name');
        $frm->addCheckBox(Labels::getLabel('FRM_COMBINED_TAX', $this->siteLangId), 'taxstr_is_combined', 1);
        $componentFld = $frm->addTextBox(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $this->siteLangId), 'taxstr_component_name[]');
        $htmlFld = $frm->addHTML('', 'component_link', '');
        $componentFld->attachField($htmlFld);
        $componentFld->fieldWrapper = ['<div class="component_link"><div class="row">', '</div></div>'];
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        $frm->addHTML('', 'space', '');
        $frm->addHTML('', 'space', '');
        return $frm;
    }

    protected function getLangForm($recordId = 0, $lang_id = 0) {
        $frm = new Form('frmtaxStructureLang', array('id' => 'frmtaxStructureLang'));
        $frm->addHiddenField('', 'taxstr_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_NAME', $this->siteLangId), 'brand_name');
        $frm->addCheckBox(Labels::getLabel('FRM_COMBINED_TAX', $this->siteLangId), 'taxstr_is_combined', 1);
        $componentFld = $frm->addTextBox(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $this->siteLangId), 'taxstr_component_name[]');
        $htmlFld = $frm->addHTML('', 'component_link', '');
        $componentFld->attachField($htmlFld);
        $componentFld->fieldWrapper = ['<div class="component_link"><div class="row">', '</div></div>'];
        return $frm;
    }

    public function form() {
        $this->objPrivilege->canEditTax();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $lang = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $taxStrData = TaxStructure::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId);
            $frm->fill($taxStrData);
        }
        $this->set('combinedTaxes', $combinedTaxes ?? []);
        $this->set('taxStrData', $taxStrData ?? []);
        $this->set('languages', $lang);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup() {
        $this->objPrivilege->canEditTax();

        $frm = TaxStructure::getForm($this->siteLangId);
        $post = FatApp::getPostedData();

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        } 
        $recordId = $post['taxstr_id'];
        unset($post['taxstr_id']); 
        $record = new TaxStructure($recordId);
        if (!$record->addUpdateData($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function translatedData() {
        $taxstrName = FatApp::getPostedData('taxstrName', FatUtility::VAR_STRING, '');
        $toLangId = FatApp::getPostedData('toLangId', FatUtility::VAR_INT, 0);
        $data['taxstr_name'] = $taxstrName;
        $taxStructure = new TaxStructure();
        $translatedData = $taxStructure->getTranslatedData($data, $toLangId);
        if (!$translatedData) {
            LibHelper::exitWithError($taxStructure->getError(), true);
        }
        $this->set('taxstrName', $translatedData[$toLangId]['taxstr_name']);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array {
        $taxStructureTblHeadingCols = CacheHelper::get('taxStructureTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($taxStructureTblHeadingCols) {
            return json_decode($taxStructureTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'taxstr_identifier' => Labels::getLabel('LBL_TAX_STRUCTURE_NAME', $this->siteLangId),
            'taxstr_is_combined' => Labels::getLabel('LBL_COMBINED_TAX', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->siteLangId),
        ];
        CacheHelper::create('taxStructureTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'taxstr_identifier',
            'taxstr_is_combined',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['taxstr_is_combined'], Common::excludeKeysForSort());
    }

}
