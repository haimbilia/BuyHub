<?php

class LanguagesController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewLanguage();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey('MANAGE_LANGUAGES', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['statusButtons'] = true;
        $actionItemsData['performBulkAction'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_LANGUAGE_CODE_AND_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'languages/search.php', true),
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
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = Language::getSearchObject(false, $this->siteLangId);

        $srch->addFld('l.*');

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('l.language_code', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('l.language_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

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
        $this->set('canEdit', $this->objPrivilege->canEditLanguage($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditLanguage();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = Language::getAttributesById($recordId, array('language_id', 'language_code', 'language_name', 'language_active', 'language_layout_direction', 'language_country_code'));

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $langId = 1 > $recordId ? $this->siteLangId : $recordId;

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_LANGUAGE_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditLanguage();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatApp::getPostedData('language_id', FatUtility::VAR_INT, 0);
        unset($post['language_id']);

        $status = FatApp::getPostedData('language_active', FatUtility::VAR_INT, 0);
        if ($status == applicationConstants::INACTIVE && 1 > count(Language::getAllNames())) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_MAINTAIN_ATLEAST_ONE_ACTIVE_LANGUAGE', $this->siteLangId), true);
        }

        $record = new Language($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError(Labels::getLabel('ERR_This_language_code_is_not_available', $this->siteLangId), true);
        }

        $msg = Labels::getLabel('MSG_ADDED_SUCCESSFULLY', $this->siteLangId);
        if (0 < $recordId) {
            $msg = Labels::getLabel('LBL_UPDATED_SUCCESSFULLY', $this->siteLangId);
        }
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }


    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $siteLangId = $this->siteLangId;
        if (0 < $recordId) {
            $siteLangId = $recordId;
        }

        $frm = new Form('frmLanguage');
        $frm->addHiddenField('', 'language_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_LANGUAGE_NAME', $siteLangId), 'language_name');
        $frm->addRequiredField(Labels::getLabel('FRM_LANGUAGE_CODE', $siteLangId), 'language_code');      
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE_LAYOUT_DIRECTION', $siteLangId), 'language_layout_direction', applicationConstants::getLayoutDirections($siteLangId), '', array(),'');
        $fld->requirement->setRequired(true);

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($siteLangId, true, 'country_code');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_COUNTRY', $siteLangId), 'language_country_code', $countriesArr, '', array(), Labels::getLabel('FRM_SELECT', $siteLangId));
        $fld->requirement->setRequired(true);
        
        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'language_active', applicationConstants::ACTIVE, array(), false, applicationConstants::INACTIVE);
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditLanguage();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1) == $recordId && applicationConstants::INACTIVE == $status) {
            LibHelper::exitWithError(Labels::getLabel('ERR_YOU_CANNOT_TURN_OFF_DEFAULT_LANGUAGE', $this->siteLangId), true);
        }

        if ($status == applicationConstants::INACTIVE && 1 == count(Language::getAllNames())) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_MAINTAIN_ATLEAST_ONE_ACTIVE_LANGUAGE', $this->siteLangId), true);
        }

        $this->changeStatus($recordId, $status);

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_STATUS_UPDATED', $this->siteLangId));
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditStates();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('language_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($status == applicationConstants::INACTIVE && count($recordIdsArr) >= count(Language::getAllNames())) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_MAINTAIN_ATLEAST_ONE_ACTIVE_LANGUAGE', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_STATUS_UPDATED', $this->siteLangId));
    }

    protected function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $countryObj = new Language($recordId);
        if (!$countryObj->changeStatus($status)) {
            LibHelper::exitWithError($countryObj->getError(), true);
        }
        if ($status == applicationConstants::INACTIVE && ($recordId == FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1) || $recordId ==  FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1))) {
            $srch = Language::getSearchObject();
            $srch->addFld('language_id');
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $firstActivelangData = FatApp::getDb()->fetch($srch->getResultSet());
            if (!empty($firstActivelangData)) {
                $configuration = new Configurations();
                $dataToUpdate = [];
                if (FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1)  == $recordId) {
                    $dataToUpdate['CONF_DEFAULT_SITE_LANG'] = $firstActivelangData['language_id'];
                }
                if (FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1)  == $recordId) {
                    $dataToUpdate['CONF_ADMIN_DEFAULT_LANG'] = $firstActivelangData['language_id'];
                    $_COOKIE['defaultAdminSiteLang'] = $firstActivelangData['language_id'];
                }
                if (!$configuration->update($dataToUpdate)) {
                    LibHelper::exitWithError($configuration->getError(), true);
                }
            }
        }
    }

    protected function getFormColumns(): array
    {
        $languagesTblHeadingCols = CacheHelper::get('languagesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($languagesTblHeadingCols) {
            return json_decode($languagesTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'language_code' => Labels::getLabel('LBL_Language_Code', $this->siteLangId),
            'language_name' => Labels::getLabel('LBL_Language_Name', $this->siteLangId),
            'language_active' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('languagesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'language_code',
            'language_name',
            'language_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['language_active'], Common::excludeKeysForSort());
    }
}
