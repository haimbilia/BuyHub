<?php

class CurrencyManagementController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewCurrencyManagement();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('canEdit', $this->objPrivilege->canEditCurrencyManagement($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_CURRENCIES', $this->adminLangId));
        $this->_template->addJs('js/jquery.tablednd.js');
        $this->getListingData();

        $this->_template->render();
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        return $frm;
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

        $sortBy = 'currency_code' == $sortBy ? 'currency_name' : $sortBy;

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = Currency::getSearchObject($this->adminLangId, false);
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
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));
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
        $this->set('canEdit', $this->objPrivilege->canEditStates($this->admin_id, true));
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

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getForm($recordId);
        $defaultCurrencyId = FatApp::getConfig("CONF_CURRENCY", FatUtility::VAR_INT, 1);

        $defaultCurrency = 0;
        if ($recordId > 0) {
            $data = Currency::getAttributesById($recordId, array('currency_id', 'currency_code', 'currency_active', 'currency_symbol_left', 'currency_symbol_right', 'currency_value'));

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $defaultCurrency = ($data['currency_id'] == $defaultCurrencyId) ? 1 : 0;
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('defaultCurrency', $defaultCurrency);
        $this->set('frm', $frm);
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
        $record = new Currency($recordId);
        $post['currency_date_modified'] = date('Y-m-d H:i:s');
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Currency::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Currency::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Currency::getAttributesByLangId($langId, $recordId);
        }
        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditCurrencyManagement();
        $post = FatApp::getPostedData();

        $recordId = $post['currency_id'];
        $lang_id = $post['lang_id'];

        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['currency_id']);
        unset($post['lang_id']);

        $data = array(
            'currencylang_lang_id' => $lang_id,
            'currencylang_currency_id' => $recordId,
            'currency_name' => $post['currency_name']
        );

        $currencyObj = new Currency($recordId);

        if (!$currencyObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($currencyObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Currency::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Currency::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
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

            $this->set('msg', Labels::getLabel('LBL_Order_Updated_Successfully', $this->adminLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    private function getForm($currencyId = 0)
    {
        $currencyId = FatUtility::int($currencyId);

        $frm = new Form('frmCurrency');
        $frm->addHiddenField('', 'currency_id', $currencyId);
        $frm->addRequiredField(Labels::getLabel('LBL_Currency_code', $this->adminLangId), 'currency_code');
        $frm->addTextbox(Labels::getLabel('LBL_Currency_Symbol_Left', $this->adminLangId), 'currency_symbol_left');
        $frm->addTextbox(Labels::getLabel('LBL_Currency_Symbol_Right', $this->adminLangId), 'currency_symbol_right');
        $frm->addFloatField(Labels::getLabel('LBL_Currency_Conversion_Value', $this->adminLangId), 'currency_value');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);

        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->adminLangId), 'currency_active', $activeInactiveArr, '', array(), '');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getLangForm($currencyId = 0, $lang_id = 0)
    {
        $frm = new Form('frmCurrencyLang');
        $frm->addHiddenField('', 'currency_id', $currencyId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Currency_Name', $this->adminLangId), 'currency_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditCurrencyManagement();
        $currencyId = FatApp::getPostedData('currencyId', FatUtility::VAR_INT, 0);
        if (0 >= $currencyId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Currency::getAttributesById($currencyId, array('currency_id', 'currency_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = ($data['currency_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->changeStatus($currencyId, $status);

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditCurrencyManagement();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $currencyIdsArr = FatUtility::int(FatApp::getPostedData('currency_ids'));
        if (empty($currencyIdsArr) || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }

        foreach ($currencyIdsArr as $currencyId) {
            if (1 > $currencyId) {
                continue;
            }

            $this->changeStatus($currencyId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function changeStatus($currencyId, $status)
    {
        $status = FatUtility::int($status);
        $currencyId = FatUtility::int($currencyId);
        if (1 > $currencyId || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }

        $obj = new Currency($currencyId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getFormColumns(): array
    {
        $currencyTblHeadingCols = CacheHelper::get('currencyTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($currencyTblHeadingCols) {
            return json_decode($currencyTblHeadingCols);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_Select_all', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'currency_code' => Labels::getLabel('LBL_Currency', $this->adminLangId),
            'currency_symbol_left' => Labels::getLabel('LBL_Symbol_Left', $this->adminLangId),
            'currency_symbol_right' => Labels::getLabel('LBL_Symbol_Right', $this->adminLangId),
            'currency_active' => Labels::getLabel('LBL_Status', $this->adminLangId),
            'action' => Labels::getLabel('LBL_Action', $this->adminLangId),
        ];
        CacheHelper::create('currencyTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

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
        return array_diff($fields, ['dragdrop', 'currency_active', 'currency_symbol_left', 'currency_symbol_right'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->adminLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_CURRENCY', $this->adminLangId)]
                ];
        }
        return $this->nodes;
    }
}
