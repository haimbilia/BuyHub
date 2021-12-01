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
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
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
        $componentFld = $frm->addTextBox(Labels::getLabel('FRM_TAX_COMPONENT_NAME', $this->siteLangId), 'taxstr_component_name[]', '', ['class' => 'test']);
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

    public function form() {
        $this->objPrivilege->canEditTax();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $lang = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $taxStrData = TaxStructure::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId);
            $combinedData = TaxStructure::getAttributesById($recordId, ['taxstr_is_combined', 'taxstr_id']);
            $taxStrData = $taxStrData + $combinedData;

            if ($taxStrData['taxstr_is_combined']) {
                $combinedTaxes = (new TaxStructure())->getCombinedTaxesForLang($taxStrData['taxstr_id'], CommonHelper::getDefaultFormLangId());
            }
            if (isset($combinedTaxes)) {
                $countStart = 0;
                foreach ($combinedTaxes as $key => $value) {
                    if ($countStart == 0) {
                        $countStart++;
                        $parentfld = $frm->getField('taxstr_component_name[]');
                        $parentfld->value = $value;
                        unset($combinedTaxes[$key]);
                        break;
                    }
                }
            }

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
        $post['taxstr_identifier'] = $post['taxstr_name'];
        $post['taxstr_is_combined'] = $post['taxstr_is_combined'] ?? 0;
        $record = new TaxStructure($recordId);
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $this->setLangData($record, [
            'taxstr_name' => $post['taxstr_name']
        ]);
        $recordId = $record->getMainTableRecordId();
        if (isset($post['taxstr_is_combined']) && !empty($post['taxstr_is_combined'])) {
            $postComponent = [];
            if (!empty(array_filter($post['taxstr_component_name']))) {
                foreach ($post['taxstr_component_name'] as $component) {
                    $postComponent[][CommonHelper::getDefaultFormLangId()] = $component;
                }
                $post['taxstr_component_name'] = $postComponent;
            }
            if ($recordId > 0) {
                $post['lang_id'] = CommonHelper::getDefaultFormLangId();
                $taxDetails = (new TaxStructure())->getCombinedTaxesWithLang($recordId, $post);
                $post = array_merge($post, $taxDetails);
            }
        } else {
            $post['taxstr_component_name'] = [];
        }
        
        if (!$record->addUpdateCombinedData($post, $record->getMainTableRecordId())) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0) {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $langFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(TaxStructure::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = TaxStructure::getAttributesByLangId($langId, $recordId);
            $langData = (!empty($langData)) ? $langData : [];
            $combinedData = TaxStructure::getAttributesById($recordId, ['taxstr_is_combined', 'taxstr_id']);
            $langData = $langData + $combinedData;
        }
        $isCombined = $langData['taxstr_is_combined'] ?? 0;
        $langFrm = $this->getLangForm($recordId, $langId, $isCombined);
        if ($langData) {
            $langFrm->fill($langData);
        }
        $this->set('langcombinedTaxes', $langcombinedTaxes ?? []);
        $this->set('combinedTaxes', $combinedTaxes ?? []);
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    public function langSetup() {
        $recordId = FatApp::getPostedData('taxstr_id', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        if (1 > $recordId || 1 > $lang_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $isCombined = TaxStructure::getAttributesById($recordId, 'taxstr_is_combined');
        $frm = $this->getLangForm($recordId, $lang_id . $isCombined);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData(), ['taxstr_component_name[]']);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $record = new TaxStructure($recordId);
        $this->setLangData($record, [
            'taxstr_name' => $post['taxstr_name']
                ], $lang_id);

        $post['taxstr_component_name'] = FatApp::getPostedData('taxstr_component_name');
        $postComponent = [];
        if (!empty(array_filter($post['taxstr_component_name']))) {
            foreach ($post['taxstr_component_name'] as $component) {
                $postComponent[][$lang_id] = $component;
            }
            $post['taxstr_component_name'] = $postComponent;
        }

        if ($recordId > 0) {
            $taxDetails = (new TaxStructure())->getCombinedTaxesWithLang($recordId, $post);
            $post = array_merge($post, $taxDetails);
        }


        if (!$record->addUpdateCombinedData($post, $record->getMainTableRecordId())) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('recordId', $recordId);
        $this->set('langId', $lang_id);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getLangForm($recordId = 0, $lang_id = 0, $isCombined = 0) {
        $frm = new Form('frmLangJs', array('id' => 'frmLangJs'));
        $frm->addHiddenField('', 'taxstr_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $lang_id), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_NAME', $lang_id), 'taxstr_name');
        
        if ($isCombined) {
            $htmlFld = $frm->addHTML('', 'component_link', Labels::getLabel('FRM_TAX_COMPONENT_NAME', $lang_id));
            $langcombinedTaxes = (new TaxStructure())->getCombinedTaxesForLang($recordId, $lang_id);
            $combinedTaxes = (new TaxStructure())->getCombinedTaxesForLang($recordId, CommonHelper::getDefaultFormLangId());
            foreach ($combinedTaxes as $key => $value) {
                $frm->addTextBox('', 'taxstr_component_name[]', $langcombinedTaxes[$key] ?? '');
            }
        }
        return $frm;
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
