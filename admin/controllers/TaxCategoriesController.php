<?php

class TaxCategoriesController extends ListingBaseController
{

    protected string $modelClass = 'Tax';
    protected $pageKey = 'MANAGE_TAX_CATEGORIES';

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

    public function index()
    {
        $fields = $this->getFormColumns();
        // $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageData['plang_title'] ?? LibHelper::getControllerName(true));
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($fields));
        $this->set('actionItemsData', HtmlHelper::getDefaultActionItems($fields, $this->modelObj));
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_CATEGORY_NAME', $this->siteLangId));
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'taxcat_identifier');
        }
        $frm->addHiddenField('', 'total_record_count'); 
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'tax-categories/search.php', true),
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

        $srch = Tax::getSearchObject($this->siteLangId, false);
        $srch->addCondition('taxcat_deleted', '=', 0);
        $srch->addCondition('taxcat_plugin_id', '=', Tax::getActivatedServiceId());
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('t.taxcat_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('t_l.taxcat_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cnd->attachCondition('t.taxcat_code', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addMultipleFields(["COALESCE(t_l.taxcat_name, t.taxcat_identifier) as taxcat_name", 't.*']);
        $srch->addOrder($sortBy, $sortOrder);  
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet())); 
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditTax($this->admin_id, true));
        $this->set('isTaxPluginActive', 0 < Tax::getActivatedServiceId());
        
    }

    public function form()
    {
        $this->objPrivilege->canEditTax();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 < $recordId) {
            $data = Tax::getAttributesByLangId(
                CommonHelper::getDefaultFormLangId(),
                $recordId,
                [
                    'taxcat_id',
                    'taxcat_code',
                    'taxcat_parent',
                    'taxcat_plugin_id',
                    'taxcat_active',
                    'taxcat_deleted',
                    'taxcat_name',
                    'taxcat_identifier'
                ],
                true
            );
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
        HtmlHelper::addIdentierToFrm($frm->getField($this->modelClass::tblFld('name')), ($data[$this->modelClass::tblFld('identifier')] ?? ''));

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
        $this->set('formTitle', Labels::getLabel('LBL_TAX_CATEGORY_SETUP', $this->siteLangId));
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
        $recordId = $post['taxcat_id'];
        unset($post['taxcat_id']);
        $data = $post;
        $data['taxcat_identifier'] = $data['taxcat_name'];
        $tax = new Tax($recordId);
        $tax->assignValues($data);
        if (!$tax->save()) {
            $msg = $tax->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $this->setLangData($tax, [$tax::tblFld('name') => $post[$tax::tblFld('name')]]);
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $tax->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php');
    }

    public function autoComplete()
    {
        $pagesize = 20;
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, $this->siteLangId);
        $keyword = FatApp::getPostedData('keyword');
        $srch = Tax::getSearchObject($langId, true);
        $srch->addCondition('taxcat_deleted', '=', 0);
        $activatedTaxServiceId = Tax::getActivatedServiceId();

        $srch->addFld('taxcat_id');
        if ($activatedTaxServiceId) {
            $srch->addFld('concat(IFNULL(taxcat_name,taxcat_identifier), " (",taxcat_code,")") as taxcat_name');
        } else {
            $srch->addFld('IFNULL(taxcat_name,taxcat_identifier)as taxcat_name');
        }
        $srch->addCondition('taxcat_plugin_id', '=', $activatedTaxServiceId);

        if (!empty($keyword)) {
            $srch->addCondition('taxcat_name', 'LIKE', '%' . $keyword . '%')
                ->attachCondition('taxcat_identifier', 'LIKE', '%' . $keyword . '%')
                ->attachCondition('taxcat_code', 'LIKE', '%' . $keyword . '%');
        }
        $srch->setPageSize($pagesize);
        $srch->setPageNumber($page);
        $taxCategories = FatApp::getDb()->fetchAll($srch->getResultSet(), 'taxcat_id');
        $json = array(
            'pageCount' => $srch->pages(),
            'results' => [],
        );
        foreach ($taxCategories as $key => $taxCategory) {
            $taxCatName = strip_tags(html_entity_decode($taxCategory['taxcat_name'], ENT_QUOTES, 'UTF-8'));
            $json['results'][] = array(
                'id' => $key,
                'text' => $taxCatName
            );
        }
        die(FatUtility::convertToJson($json));
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmTaxLang', array('id' => 'frmTaxLang'));
        $frm->addHiddenField('', 'taxcat_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId);
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_CATEGORY_NAME', $langId), 'taxcat_name');
        return $frm;
    }

    protected function getForm($taxcat_id = 0)
    {
        $this->objPrivilege->canEditTax();
        $frm = new Form('frmTax', array('id' => 'frmTax'));
        $frm->addHiddenField('', 'taxcat_id', FatUtility::int($taxcat_id));
        $frm->addRequiredField(Labels::getLabel('FRM_TAX_CATEGORY_NAME', $this->siteLangId), 'taxcat_name');
        $activatedTaxServiceId = Tax::getActivatedServiceId();
        if ($activatedTaxServiceId) {
            $frm->addHiddenField('', 'taxcat_plugin_id', $activatedTaxServiceId)->requirements()->setRequired();
        }

        if ($activatedTaxServiceId || FatApp::getConfig('CONF_TAX_CATEGORIES_CODE', FatUtility::VAR_INT, 1)) {
            $frm->addRequiredField(Labels::getLabel('FRM_TAX_CODE', $this->siteLangId), 'taxcat_code');
        }

        $frm->addCheckBox(Labels::getLabel('FRM_ACTIVE', $this->siteLangId), 'taxcat_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $taxTblHeadingCols = CacheHelper::get('taxTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($taxTblHeadingCols) {
            return json_decode($taxTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
           /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'taxcat_name' => Labels::getLabel('LBL_CATEGORY_NAME', $this->siteLangId),
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
            /* 'listSerial', */
            'taxcat_name',
            'taxcat_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['taxcat_active'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => $pageTitle]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
