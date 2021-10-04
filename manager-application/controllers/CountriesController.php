<?php

class CountriesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewCountries();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_COUNTRIES', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
    }

    private function getListingData()
    {
        $db = FatApp::getDb();

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
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $srch = Countries::getSearchObject(false, $this->adminLangId);
        $srch->addMultipleFields(['c.* , COALESCE(c_l.country_name, c.country_code) as country_name', 'c.country_id as listSerial']);

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('c.country_code', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('c_l.country_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->removeFld(['select_all', 'action']);
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditCountries($this->admin_id, true));
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'countries/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $this->objPrivilege->canEditCountries();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm();

        if (0 < $recordId) {     
            $data = Countries::getAttributesByLangId(FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1), $recordId, null, true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getDropDownList(true));
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditCountries();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
                
        $recordId = $post['country_id'];
        unset($post['country_id']);

        $record = new Countries($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $recordId = $record->getMainTableRecordId();
        
        $defaultLang = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (!$record->updateLangData($defaultLang, ['country_name' => $post['country_name']])) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataObj = new TranslateLangData(Countries::DB_TBL_LANG);
            if (false === $updateLangDataObj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataObj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getDropDownList(true);
        if (0 < count($languages)) {           
            foreach ($languages as $langId => $langName) {
                if (!$row = Countries::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }
        Product::updateMinPrices(0, 0, 0, $recordId);
        $this->set('msg', Labels::getLabel('LBL_UPDATED_SUCCESSFULLY', $this->adminLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->objPrivilege->canEditCountries();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('langId', FatUtility::VAR_INT, FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));

        if (1 > $recordId || 1 > $lang_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($recordId, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataObj = new TranslateLangData(Countries::DB_TBL_LANG);
            $translatedData = $updateLangDataObj->getTranslatedData($recordId, $lang_id);
            if (false === $translatedData) {            
                LibHelper::exitWithError($updateLangDataObj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Countries::getAttributesByLangId($lang_id, $recordId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getDropDownList(true));
        $this->set('recordId', $recordId);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('formTitle', Labels::getLabel('LBL_COUNTRY_SETUP', $this->adminLangId));
        $this->_template->render(false, false, '_partial/listing/lang-form.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditCountries();
        $post = FatApp::getPostedData();

        $recordId = $post['country_id'];
        $languages = Language::getAllNames();

        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }


        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['country_id']);
        unset($post['lang_id']);

        $data = array(
            'countrylang_lang_id' => $lang_id,
            'countrylang_country_id' => $recordId,
            'country_name' => $post['country_name']
        );

        $countryObj = new Countries($recordId);

        if (!$countryObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($countryObj->getError(), true);
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!Countries::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm()
    {        
        $frm = new Form('frmCountry');
        $frm->addHiddenField('', 'country_id');

        $zoneArr = Zone::getAllZones($this->adminLangId, true);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_ZONE', $this->adminLangId), 'country_zone_id', $zoneArr, '', [], Labels::getLabel('LBL_SELECT', $this->adminLangId));
        $fld->requirements()->setRequired();

        $frm->addRequiredField(Labels::getLabel('LBL_COUNTRY_NAME', $this->adminLangId), 'country_name');

        $currencyArr = Currency::getCurrencyNameWithCode($this->adminLangId);
        $currencyId = FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1);
        $currencyData = Currency::getAttributesById($currencyId, array('currency_code'));
        $defaultCurrentySelect = Labels::getLabel('LBL_DEFAULT', $this->adminLangId) . '(' . $currencyData['currency_code'] . ')';
        $frm->addSelectBox(Labels::getLabel('LBL_CURRENCY', $this->adminLangId), 'country_currency_id', $currencyArr, '', [], $defaultCurrentySelect);

        $frm->addRequiredField(Labels::getLabel('LBL_COUNTRY_CODE', $this->adminLangId), 'country_code');
        $frm->addRequiredField(Labels::getLabel('LBL_COUNTRY_ALPHA3_CODE', $this->adminLangId), 'country_code_alpha3');
        
        $languageArr = Language::getDropDownList();
        if (1 < count($languageArr)) {
            $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'country_language_id', $languageArr, '', array(), '');
        } else {
            $frm->addHiddenField('', 'country_language_id', FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));
        }    

        $frm->addSelectBox(Labels::getLabel('LBL_STATUS', $this->adminLangId), 'country_active', applicationConstants::getActiveInactiveArr($this->adminLangId), '', array(), '');    
        
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, ''); 
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        } 
        
        return $frm;
    }

    private function getLangForm($recordId = 0, $lang_id = 0)
    {
        $frm = new Form('frmCountryLang');
        $frm->addHiddenField('', 'country_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', Language::getDropDownList(true), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_COUNTRY_NAME', $this->adminLangId), 'country_name');
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditCountries();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);
        Product::updateMinPrices(0, 0, 0, $recordId);
        LibHelper::dieJsonSuccess(['msg' => $this->str_update_record]);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditCountries();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('country_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        Product::updateMinPrices();
        LibHelper::dieJsonSuccess(['msg' => $this->str_update_record]);
    }

    private function changeStatus(int $recordId, int $status)
    {
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new Countries($recordId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');

        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        return $frm;
    }

    private function getFormColumns(): array
    {
        $countriesTblHeadingCols = CacheHelper::get('countriesTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($countriesTblHeadingCols) {
            return json_decode($countriesTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'country_code' => Labels::getLabel('LBL_COUNTRY_CODE', $this->adminLangId),
            'country_code_alpha3' => Labels::getLabel('LBL_COUNTRY_ALPHA3_CODE', $this->adminLangId),
            'country_name' => Labels::getLabel('LBL_COUNTRY_NAME', $this->adminLangId),
            'country_active' => Labels::getLabel('LBL_STATUS', $this->adminLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->adminLangId),
        ];
        CacheHelper::create('countriesTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['select_all', 'listSerial', 'country_name', 'country_code', 'country_code_alpha3',  'country_active', 'action'];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['country_active'], Common::excludeKeysForSort());
    }
}
