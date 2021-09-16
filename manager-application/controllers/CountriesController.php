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
        $this->_template->addJs('js/report.js');
        $this->_template->render();
    }

    public function search()
    {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
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

        switch ($sortBy) {
            default:
                $srch->addOrder($sortBy, $sortOrder);
                break;
        }

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
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));
        $this->set('canEdit', $this->objPrivilege->canEditCountries($this->admin_id, true));
        $this->_template->render(false, false);
    }

    public function form($countryId)
    {
        $this->objPrivilege->canEditCountries();

        $countryId = FatUtility::int($countryId);

        $frm = $this->getForm($countryId);

        if (0 < $countryId) {
            $data = Countries::getAttributesById($countryId);

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('country_id', $countryId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditCountries();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['country_language_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['country_language_id'] = $lang_id;
        }



        $countryId = $post['country_id'];
        unset($post['country_id']);

        $record = new Countries($countryId);
        $record->assignValues($post);

        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $newTabLangId = 0;
        if ($countryId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Countries::getAttributesByLangId($langId, $countryId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $countryId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        Product::updateMinPrices(0, 0, 0, $countryId);
        $this->set('msg', Labels::getLabel('LBL_Updated_Successfully', $this->adminLangId));
        $this->set('countryId', $countryId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($countryId = 0, $lang_id = 0, $autoFillLangData = 0)
    {

        $countryId = FatUtility::int($countryId);
        $lang_id = FatUtility::int($lang_id);

        if ($countryId == 0 || $lang_id == 0) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $langFrm = $this->getLangForm($countryId, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Countries::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($countryId, $lang_id);
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = Countries::getAttributesByLangId($lang_id, $countryId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('countryId', $countryId);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditCountries();
        $post = FatApp::getPostedData();

        $countryId = $post['country_id'];
        $languages = Language::getAllNames();

        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }


        if ($countryId == 0 || $lang_id == 0) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $frm = $this->getLangForm($countryId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['country_id']);
        unset($post['lang_id']);

        $data = array(
            'countrylang_lang_id' => $lang_id,
            'countrylang_country_id' => $countryId,
            'country_name' => $post['country_name']
        );

        $countryObj = new Countries($countryId);

        if (!$countryObj->updateLangData($lang_id, $data)) {
            Message::addErrorMessage($countryObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Countries::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($countryId)) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Countries::getAttributesByLangId($langId, $countryId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('countryId', $countryId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($countryId = 0)
    {
        $countryId = FatUtility::int($countryId);

        $frm = new Form('frmCountry');
        $frm->addHiddenField('', 'country_id', $countryId);
        $frm->addRequiredField(Labels::getLabel('LBL_Country_code', $this->adminLangId), 'country_code');
        $frm->addRequiredField(Labels::getLabel('LBL_COUNTRY_ALPHA3_CODE', $this->adminLangId), 'country_code_alpha3');

        $zoneArr = Zone::getAllZones($this->adminLangId, true);
        $frm->addSelectBox(Labels::getLabel('LBL_Zone', $this->adminLangId), 'country_zone_id', $zoneArr, '', [], Labels::getLabel('LBL_Select', $this->adminLangId));

        $currencyArr = Currency::getCurrencyNameWithCode($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Currency', $this->adminLangId), 'country_currency_id', $currencyArr, '', [], Labels::getLabel('LBL_Select', $this->adminLangId));


        $languageArr = Language::getAllNames();

        if (count($languageArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->adminLangId), 'country_language_id', $languageArr, '', array(), '');
        } else {
            $lang_id = array_key_first($languageArr);
            $frm->addHiddenField('', 'country_language_id', $lang_id);
        }



        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);

        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->adminLangId), 'country_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getLangForm($countryId = 0, $lang_id = 0)
    {
        $frm = new Form('frmCountryLang');
        $frm->addHiddenField('', 'country_id', $countryId);


        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $frm->addRequiredField(Labels::getLabel('LBL_Country_Name', $this->adminLangId), 'country_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    public function changeStatus()
    {
        $this->objPrivilege->canEditCountries();
        $countryId = FatApp::getPostedData('countryId', FatUtility::VAR_INT, 0);
        if (0 >= $countryId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $data = Countries::getAttributesById($countryId, array('country_active'));

        if ($data == false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $status = ($data['country_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updateCountryStatus($countryId, $status);
        Product::updateMinPrices(0, 0, 0, $countryId);
        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditCountries();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $countryIdsArr = FatUtility::int(FatApp::getPostedData('country_ids'));
        if (empty($countryIdsArr) || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        foreach ($countryIdsArr as $countryId) {
            if (1 > $countryId) {
                continue;
            }

            $this->updateCountryStatus($countryId, $status);
        }
        Product::updateMinPrices();
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateCountryStatus($countryId, $status)
    {
        $status = FatUtility::int($status);
        $countryId = FatUtility::int($countryId);
        if (1 > $countryId || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        $countryObj = new Countries($countryId);
        if (!$countryObj->changeStatus($status)) {
            Message::addErrorMessage($countryObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    public function deleteRecord()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        if (1 >  $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $country = new Countries($recordId);
        $country->assignValues(array(Countries::tblFld('deleted') => 1));
        if (!$country->save()) {
            LibHelper::exitWithError($country->getError(), true);
        }

        LibHelper::dieJsonSuccess(['msg' => $this->str_update_record]);
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page');

        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'listSerial');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_DESC);
            $frm->addHiddenField('', 'reportColumns', '');
            $frm->addHiddenField('', 'pageSize', FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        return $frm;
    }

    private function getFormColumns(): array
    {
        $countryManagementCacheVar = CacheHelper::get('countryManagementCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$countryManagementCacheVar) {
            $arr = [
                'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->adminLangId),
                'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
                'country_code' => Labels::getLabel('LBL_COUNTRY_CODE', $this->adminLangId),
                'country_code_alpha3' => Labels::getLabel('LBL_COUNTRY_ALPHA3_CODE', $this->adminLangId),
                'country_name' => Labels::getLabel('LBL_COUNTRY_NAME', $this->adminLangId),
                'country_active' => Labels::getLabel('LBL_STATUS', $this->adminLangId),
                'action' => Labels::getLabel('LBL_ACTION', $this->adminLangId),
            ];
            CacheHelper::create('countryManagementCacheVar' . $this->adminLangId, serialize($arr), CacheHelper::TYPE_LABELS);
        } else {
            $arr =  unserialize($countryManagementCacheVar);
        }
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['select_all', 'listSerial', 'country_name', 'country_code', 'country_code_alpha3',  'country_active', 'action'];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['select_all', 'action']);
    }
}
