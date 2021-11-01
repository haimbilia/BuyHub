<?php

class CurrencyManagementController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewCurrencyManagement();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditCurrencyManagement();
        $this->modelObj = (new ReflectionClass('Currency'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_CURRENCY_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('canEdit', $this->objPrivilege->canEditCurrencyManagement($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_CURRENCIES', $this->siteLangId));
        $this->_template->addJs('js/jquery.tablednd.js');
        $this->getListingData();

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'currency-management/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'currency_display_order');
        if (!array_key_exists($sortBy, $fields) && 'currency_display_order' != $sortBy) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortBy = 'currency_code' == $sortBy ? 'currency_name' : $sortBy;

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = Currency::getSearchObject($this->siteLangId, false);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        if (!empty($post['keyword'])) {
            $srch->addCondition('curr_l.currency_name', 'like', '%' . $post['keyword'] . '%');
        }

        $srch->addMultipleFields(['curr.*', 'curr_l.*', 'curr.currency_id as listSerial']);
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $defaultCurrencyId = FatApp::getConfig("CONF_CURRENCY", FatUtility::VAR_INT, 1);
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("defaultCurrencyId", $defaultCurrencyId);
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
        $this->set('canEdit', $this->objPrivilege->canEditCurrencyManagement($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $data = [];
        $defaultCurrency = 0;
        if ($recordId > 0) {
            $data = Currency::getAttributesByLangId(
                    $this->getDefaultFormLangId(),
                    $recordId,
                    array('currency_id', 'currency_code', 'currency_active', 'currency_symbol_left', 'currency_symbol_right', 'currency_value','currency_name'),
                    true
                );
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $defaultCurrency = ($data['currency_id'] == FatApp::getConfig("CONF_CURRENCY", FatUtility::VAR_INT, 1)) ? 1 : 0;
        }
        $frm = $this->getForm($defaultCurrency);
        $frm->fill($data);        
    
        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);    
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_CURRENCY_SETUP', $this->siteLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditCurrencyManagement();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['currency_id']);
        unset($post['currency_id']);
        if ($recordId > 0) {
            $defaultCurrencyId = FatApp::getConfig("CONF_CURRENCY", FatUtility::VAR_INT, 1);
            if ($recordId == $defaultCurrencyId) {
                unset($post['currency_value']);
            }
        }
        $recordObj = new Currency($recordId);
        $post['currency_date_modified'] = date('Y-m-d H:i:s');    
        $recordObj->assignValues($post);

        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]]); 
        
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->objPrivilege->canEditCurrencyManagement();

        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $currencyObj = new Currency();
            if (!$currencyObj->updateOrder($post['currencyIds'])) {
                LibHelper::exitWithError($currencyObj->getError(), true);
            }

            $this->set('msg', Labels::getLabel('LBL_Order_Updated_Successfully', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    private function getForm( int $defaultCurrency = 0)
    {
        $frm = new Form('frmCurrency');
        $frm->addHiddenField('', 'currency_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Currency_Name', $this->siteLangId), 'currency_name');
        $frm->addRequiredField(Labels::getLabel('LBL_Currency_code', $this->siteLangId), 'currency_code');
        $frm->addTextbox(Labels::getLabel('LBL_Currency_Symbol_Left', $this->siteLangId), 'currency_symbol_left');
        $frm->addTextbox(Labels::getLabel('LBL_Currency_Symbol_Right', $this->siteLangId), 'currency_symbol_right');
        $fld = $frm->addFloatField(Labels::getLabel('LBL_Currency_Conversion_Value', $this->siteLangId), 'currency_value');
        if ($defaultCurrency) {
            $fld->htmlAfterField = '<small>' . Labels::getLabel('LBL_This_is_your_default_currency', $this->siteLangId) . '</small>';
        }

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'currency_active', $activeInactiveArr, '', array(), '');

        $languageArr = Language::getDropDownList();        
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, ''); 
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        } 

        return $frm;
    }

    protected function getLangForm($currencyId = 0, $lang_id = 0)
    {
        $frm = new Form('frmCurrencyLang');
        $frm->addHiddenField('', 'currency_id', $currencyId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList($this->getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Currency_Name', $this->siteLangId), 'currency_name');
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditCurrencyManagement();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Currency::getAttributesById($recordId, array('currency_id', 'currency_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = ($data['currency_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->changeStatus($recordId, $status);

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditCurrencyManagement();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('currency_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
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

        $obj = new Currency($recordId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getFormColumns(): array
    {
        $currencyTblHeadingCols = CacheHelper::get('currencyTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($currencyTblHeadingCols) {
            return json_decode($currencyTblHeadingCols);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'currency_code' => Labels::getLabel('LBL_Currency', $this->siteLangId),
            'currency_symbol_left' => Labels::getLabel('LBL_Symbol_Left', $this->siteLangId),
            'currency_symbol_right' => Labels::getLabel('LBL_Symbol_Right', $this->siteLangId),
            'currency_active' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('currencyTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'dragdrop',
            'select_all',
            'listSerial',
            'currency_code',
            'currency_symbol_left',
            'currency_symbol_right',
            'currency_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [
            'dragdrop',
            'currency_active',
            'currency_symbol_left',
            'currency_symbol_right'
        ], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_CURRENCY', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
