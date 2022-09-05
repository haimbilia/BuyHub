<?php

class TaxCategoriesRuleController extends ListingBaseController
{

    protected string $modelClass = 'Tax';
    protected $pageKey = 'MANAGE_TAX_CATEGORIES_RULE';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewTax();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditTax($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditTax();
        }
    }

    public function index(int $taxCatId = 0)
    {
        if (0 < Tax::getActivatedServiceId()) {
            LibHelper::exitWithError($this->str_invalid_request, false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('TaxCategories'));
        }

        if (0 < $taxCatId) {
            $isTaxCatDeleted = Tax::getAttributesById($taxCatId, 'taxcat_deleted');
            if (false === $isTaxCatDeleted || 0 < $isTaxCatDeleted) {
                LibHelper::exitWithError($this->str_invalid_request, false, true);
                FatApp::redirectUser(UrlHelper::generateUrl('TaxCategories'));
            }
        }

        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields, $taxCatId);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageData['plang_title'] ?? LibHelper::getControllerName(true));
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), [
            'newRecordBtn' => (($taxCatId) > 0 ? true : false),
            'newRecordParent' => (($taxCatId) > 0 ? $taxCatId : 0),
            'newRecordBtnAttrs' => [
                'attr' => [
                    'onclick' => 'addNew(' . $taxCatId . ')',
                ]
            ]
        ]);
        $this->set('actionItemsData', $actionItemsData);
        $this->getListingData($taxCatId);
        $this->_template->addCss(['css/select2.min.css']);
        $this->_template->addJs([
            'js/select2.js',
            'tax-categories-rule/page-js/index.js'
        ]);
        $this->set('postedData', ['taxrule_taxcat_id' => $taxCatId]);
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_RULE_NAME', $this->siteLangId));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = [], $taxCatId = 0)
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'taxrule_name');
        }

        $frm->addHiddenField('', 'taxrule_taxcat_id', $taxCatId);
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tax-categories-rule/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData($ruleId = 0)
    {
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
        $searchForm = $this->getSearchForm($fields, $ruleId);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = TaxRule::getSearchObject();
        $srch->joinTable(TaxRule::DB_RATES_TBL, 'INNER JOIN', TaxRule::tblFld('id') . '=' . TaxRule::DB_RATES_TBL_PREFIX . TaxRule::tblFld('id') . ' and ' . TaxRule::DB_RATES_TBL_PREFIX . 'user_id = 0');
        $srch->joinTable(TaxStructure::DB_TBL, 'LEFT JOIN', 'taxstr_id = taxrule_taxstr_id');
        $srch->joinTable(TaxStructure::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxstr_id = taxstrlang_taxstr_id and taxstrlang_lang_id = ' . $this->siteLangId);
        $srch->joinTable(Tax::DB_TBL, 'INNER JOIN', 'taxcat_id = taxrule_taxcat_id AND taxcat_deleted = ' . applicationConstants::NO);
        $srch->joinTable(Tax::DB_TBL_LANG, 'LEFT JOIN', 'taxrule_taxcat_id = taxcatlang_taxcat_id and taxcatlang_lang_id = ' . $this->siteLangId);
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $srch->addCondition('taxrule_name', 'LIKE', "%" . $post['keyword'] . "%");
        }

        if (!empty($post['taxrule_taxcat_id'])) {
            $srch->addCondition('taxrule_taxcat_id', '=', $post['taxrule_taxcat_id']);
        } else if (!empty($ruleId)) {
            $srch->addCondition('taxrule_taxcat_id', '=', $ruleId);
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array('taxrule_id', 'taxrule_name', 'trr_rate', 'IFNULL(taxstr_name, taxstr_identifier) as taxstr_name', 'taxrule_taxcat_id', 'taxcat_name', 'taxcat_identifier'));
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet()));
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditTax();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $taxCatId = FatApp::getPostedData('taxCatId', FatUtility::VAR_INT, 0);
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
        if (0 < $taxCatId) {
            $frm->fill(['taxrule_taxcat_id' => $taxCatId]);
        }
        $this->set('languages', []);
        $this->set('includeTabs', false);
        $this->set('ruleLocations', $ruleLocations ?? []);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditBrandRequests();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_TAX_CATEGORIES_RULE_SETUP', $this->siteLangId));
        $this->checkMediaExist = false;
    }

    public function setup()
    {
        $this->objPrivilege->canEditTax();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $post['taxruleloc_to_state_id'] = FatApp::getPostedData('taxruleloc_to_state_id');
        $post['taxruleloc_from_state_id'] = FatApp::getPostedData('taxruleloc_from_state_id');
        $combinedTaxDetails = FatApp::getPostedData('combinedTaxDetails') ?? [];
        if (!empty($combinedTaxDetails)) {
            $totalCombinedTax = 0;
            array_walk($combinedTaxDetails, function ($value) use (&$totalCombinedTax) {
                $totalCombinedTax += $value['taxruledet_rate'];
            });
            if ($totalCombinedTax != $post['trr_rate']) {
                LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_COMBINED_TAX_COMBINATION', $this->siteLangId), true);
            }
        }

        $ruleId = $post['taxrule_id'];
        $taxRuleObj = new TaxRule($ruleId);

        $oldTaxStrId = 0;
        if (0 < $ruleId) {
            $oldTaxStrId =  $taxRuleObj::getAttributesById($ruleId, 'taxrule_taxstr_id');
        }


        $this->validateStateCountry($post);

        unset($post['taxrule_id']);
        $taxRuleObj->assignValues($post);
        if (!$taxRuleObj->save()) {
            LibHelper::exitWithError($taxRuleObj->getError(), true);
        }


        if (!$taxRuleObj->addUpdateRate($post['trr_rate'])) {
            LibHelper::exitWithError($taxRuleObj->getError(), true);
        }

        $ruleId = $taxRuleObj->getMainTableRecordId();
        /* [ update location data */
        if (!$taxRuleObj->addUpdateLocationData($ruleId, $post)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Unable_to_Update_Location_Data', $this->siteLangId), true);
        }

        /* ] */

        /** [ deleting all combined rates and rule rate of sellers if rule taxstr_id changed */
        if (0 < $ruleId) {
            if (0 < $oldTaxStrId) {
                if ($oldTaxStrId != $post['taxrule_taxstr_id']) {
                    if (!FatApp::getDb()->deleteRecords(
                        TaxRule::DB_RATES_TBL,
                        array(
                            'smt' => TaxRule::DB_RATES_TBL_PREFIX . 'taxrule_id = ? and ' . TaxRule::DB_RATES_TBL_PREFIX . 'user_id != ?',
                            'vals' => array($ruleId, 0)
                        )
                    )) {
                        LibHelper::exitWithError(FatApp::getDb()->getError(), true);
                    }

                    if (!FatApp::getDb()->deleteRecords(
                        TaxRule::DB_DETAIL_TBL,
                        array(
                            'smt' => TaxRule::DB_DETAIL_TBL_PREFIX . 'taxrule_id = ?',
                            'vals' => array($ruleId)
                        )
                    )) {
                        LibHelper::exitWithError(FatApp::getDb()->getError(), true);
                    }
                }
            }
        }

        /* ] */

        /* [ UPDATE COMBINED TAX DETAILS */
        if (!$taxRuleObj->addUpdateCombinedData($combinedTaxDetails, $ruleId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Unable_to_Update_Combined_Tax_Data', $this->siteLangId), true);
        }
        /* ] */

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $taxRuleObj->getMainTableRecordId());
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
                $key = $post['taxruleloc_from_country_id'] . "-" . $fromState . "-" . $post['taxruleloc_to_country_id'] . "-" . $toState . "-" . $post['taxruleloc_type'];

                if (in_array($key, $combination)) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_COMBINATION_OF_COUNTRY_STATE_AND_STATE_TYPE_ALREADY_EXIST_IN_CATEGORY', $this->siteLangId), true);
                }
            }
        }
    }

    public function getCombinedTaxes($taxStrId, $ruleId = 0)
    {
        $taxStrId = FatUtility::int($taxStrId);
        $ruleId = FatUtility::int($ruleId);
        $this->set('taxStrId', $taxStrId);
        $this->set('combTaxes', (new TaxStructure($taxStrId))->getCombinedTaxesByParent($this->siteLangId, $ruleId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditTax();
        $post = FatApp::getPostedData();
        if ($post == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatUtility::int($post['recordId']);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $taxRule = new TaxRule($recordId);
        if (!$taxRule->deleteRelatedRecord()) {
            LibHelper::exitWithError($taxRule->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmTaxLang', array('id' => 'frmTaxLang'));
        $frm->addHiddenField('', 'taxcat_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $lang_id);
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_CATEGORY_NAME', $langId), 'taxcat_name');
        return $frm;
    }

    protected function getForm()
    {
        $this->objPrivilege->canEditTax();
        $frm = new Form('frmTaxRule');
        $frm->addHiddenField('', 'taxrule_taxcat_id');

        /* [ TAX CATEGORY RULE FORM */
        $frm->addHiddenField('', 'taxrule_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_RULE_NAME', $this->siteLangId), 'taxrule_name');
        $fld = $frm->addFloatField(Labels::getLabel('FRM_TAX_RATE(%)', $this->siteLangId), 'trr_rate', '');
        $fld->requirements()->setPositive();
        $fld->requirements()->setRange(0, 100);

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
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_FROM_STATE', $this->siteLangId), 'taxruleloc_from_state_id[]', [-1 => Labels::getLabel('FRM_ALL', $this->siteLangId)], '', array(), '');
        $fld->requirements()->setRequired();
        $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_HOLD_DOWN_THE_CTRL_(WINDOWS)_OR_COMMAND_(MAC)_BUTTON_TO_SELECT_MULTIPLE_OPTIONS.', $this->siteLangId) . '</span>';

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TO_COUNTRY', $this->siteLangId), 'taxruleloc_to_country_id', $countriesOptions, '', array(), Labels::getLabel('FRM_SELECT_COUNTRY', $this->siteLangId));
        $fld->requirements()->setRequired();
        $locattionTypeOtions = TaxRule::getTypeOptions($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TO_STATE_TYPE', $this->siteLangId), 'taxruleloc_type', $locattionTypeOtions, '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->requirements()->setRequired();
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TO_STATES', $this->siteLangId), 'taxruleloc_to_state_id[]', [-1 => Labels::getLabel('FRM_ALL', $this->siteLangId)], '', array(), '');
        $fld->requirements()->setRequired();
        $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('LBL_HOLD_DOWN_THE_CTRL_(WINDOWS)_OR_COMMAND_(MAC)_BUTTON_TO_SELECT_MULTIPLE_OPTIONS.', $this->siteLangId) . '</span>';
        /* ] */

        $taxStructures = TaxStructure::getAllAssoc($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELECT_TAX_STRUCTURE', $this->siteLangId), 'taxrule_taxstr_id', $taxStructures, '', array(), Labels::getLabel('FRM_Select_Tax', $this->siteLangId));
        $fld->requirements()->setRequired();

        /* [ TAX GROUP RULE COMBINED DETAILS FORM */
        $frm->addHTML('', 'combinedTaxDetails', '<div class="combinedTaxDetails"></div>');
        /* ] */
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('taxCatTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'taxrule_name' => Labels::getLabel('LBL_RULE_NAME', $this->siteLangId),
            'taxcat_identifier' => Labels::getLabel('LBL_CATEGORY_NAME', $this->siteLangId),
            'trr_rate' => Labels::getLabel('LBL_TAX_RATE(%)', $this->siteLangId),
            'taxstr_name' => Labels::getLabel('LBL_TAX_STRUCTURE_NAME', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('taxCatTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'taxrule_name',
            'taxcat_identifier',
            'trr_rate',
            'taxstr_name',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['trr_rate', 'taxstr_name', 'taxcat_identifier'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        $parentData = PageLanguageData::getAttributesByKey('MANAGE_TAX_CATEGORIES', $this->siteLangId);
        $parentTitle = $parentData['plang_title'] ?? Labels::getLabel('NAV_TAX_CATEGORIES', $this->siteLangId);
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $taxCatId = current(FatApp::getParameters());
                if (0 < $taxCatId) {
                    $taxCat = Tax::getAttributesByLangId($this->siteLangId, $taxCatId, ['COALESCE(taxcat_name, taxcat_identifier) as taxcat_name'], applicationConstants::JOIN_LEFT);
                    $this->nodes = [
                        ['title' => $parentTitle, 'href' => UrlHelper::generateUrl('TaxCategories')],
                        ['title' => $pageTitle, 'href' => UrlHelper::generateUrl('TaxCategoriesRule')],
                        ['title' => $taxCat['taxcat_name']]
                    ];
                } else {
                    $this->nodes = [
                        ['title' => $parentTitle, 'href' => UrlHelper::generateUrl('TaxCategories')],
                        ['title' => $pageTitle]
                    ];
                }
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
