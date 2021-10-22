<?php

class StatesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewStates();
    }

    protected function setLangTemplateData(array $constructorArgs = []): void
    {        
        $this->objPrivilege->canEditStates();
        $this->modelObj = (new ReflectionClass('States'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_STATE_SETUP', $this->siteLangId));
    }    

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('canEdit', $this->objPrivilege->canEditStates($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_STATES', $this->siteLangId));
        $this->getListingData();

        $this->_template->render();
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId, true);

        $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->siteLangId), 'country', $countriesArr, '', [], Labels::getLabel('LBL_SELECT_COUNTRY', $this->siteLangId));
        
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'states/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

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

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm($fields);
        
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = States::getSearchObject(false, $this->siteLangId);
        $countrySearchObj = Countries::getSearchObject(true, $this->siteLangId);
        $countrySearchObj->doNotCalculateRecords();
        $countrySearchObj->doNotLimitRecords();
        $countriesDbView = $countrySearchObj->getQuery();

        $srch->joinTable(
            "($countriesDbView)",
            'INNER JOIN',
            'st.' . States::DB_TBL_PREFIX . 'country_id = c.' . Countries::tblFld('id'),
            'c'
        );

        $srch->addMultipleFields(array('st.*', 'st_l.state_name', 'c.country_name', 'st.state_id as listSerial'));

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('st.state_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('st_l.state_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $condition->attachCondition('st.state_code', 'like', $post['keyword'], 'OR');
        }
        if (!empty($post['country'])) {
            $condition = $srch->addCondition('st.state_country_id', '=', $post['country']);
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
        $this->set('canEdit', $this->objPrivilege->canEditStates($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditStates();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm();

        if (0 < $recordId) {            
            $data = States::getAttributesByLangId($this->getDefaultFormLangId(), $recordId, null, true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_STATE_SETUP', $this->siteLangId));
        $this->_template->render(false, false, '_partial/listing/form.php');
    }

    public function setup()
    {
        $this->objPrivilege->canEditStates();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['state_id'];
        unset($post['state_id']);

        $recordObj = new States($recordId);
        $post['state_identifier'] = $post['state_name'];
        $recordObj->assignValues($post);

        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]]);

        CacheHelper::clear(CacheHelper::TYPE_ZONE);
        Product::updateMinPrices(0, 0, 0, 0, $recordId);       
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm()
    {
        $frm = new Form('frmState');
        $frm->addHiddenField('', 'state_id');
        $frm->addRequiredField(Labels::getLabel('LBL_State_Name', $this->siteLangId), 'state_name');
        //$frm->addRequiredField(Labels::getLabel('LBL_State_Identifier', $this->siteLangId), 'state_identifier');
        $frm->addRequiredField(Labels::getLabel('LBL_State_Code', $this->siteLangId), 'state_code');
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId, true);

        $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->siteLangId), 'state_country_id', $countriesArr, '', array(), '');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'state_active', $activeInactiveArr, '', array(), '');
        
        $languageArr = Language::getDropDownList();        
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, ''); 
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        } 
        return $frm;
    }

    protected function getLangForm($recordId = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewStates();
        $frm = new Form('frmStateLang');
        $frm->addHiddenField('', 'state_id', $recordId);   
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList($this->getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_State_Name', $this->siteLangId), 'state_name');
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditStates();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);
        Product::updateMinPrices(0, 0, 0, 0, $recordId);
        FatUtility::dieJsonSuccess($this->str_update_record);
    }
    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditStates();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('state_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        Product::updateMinPrices();
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        $stateObj = new States($recordId);
        if (!$stateObj->changeStatus($status)) {
            LibHelper::exitWithError($stateObj->getError(), true);
        }
        CacheHelper::clear(CacheHelper::TYPE_ZONE);
    }

    private function getFormColumns(): array
    {
        $statesTblHeadingCols = CacheHelper::get('statesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($statesTblHeadingCols) {
            return json_decode($statesTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),          
            'state_name' => Labels::getLabel('LBL_State_Name', $this->siteLangId),
            'state_code' => Labels::getLabel('LBL_State_Code', $this->siteLangId),
            'country_name' => Labels::getLabel('LBL_Country_Name', $this->siteLangId),
            'state_active' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('statesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'state_identifier',
            'state_name',
            'state_code',
            'country_name',
            'state_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['state_active'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_STATES', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
