<?php

class LanguagesController extends AdminBaseController
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

        $this->set('canEdit', $this->objPrivilege->canEditLanguage($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_STATES', $this->adminLangId));
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

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm($fields);
        
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = Language::getSearchObject(false, $this->adminLangId);

        $srch->addFld('l.*, l.language_id as listSerial');

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('l.language_code', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('l.language_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));
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
            'listingHtml' => $this->_template->render(false, false, 'languages/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
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

        $langId = 1 > $recordId ? $this->adminLangId : $recordId;

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
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
        if($status == applicationConstants::INACTIVE && 1 > count(Language::getAllNames()) ){
            LibHelper::exitWithError(Labels::getLabel('MSG_PLEASE_MAINTAIN_ATLEAST_ONE_ACTIVE_LANGUAGE', $this->adminLangId), true);
        }

        $record = new Language($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError(Labels::getLabel('MSG_This_language_code_is_not_available', $this->adminLangId), true);
        }

        $msg = Labels::getLabel('MSG_ADDED_SUCCESSFULLY', $this->adminLangId);
        if (0 < $recordId) {
            $msg = Labels::getLabel('LBL_UPDATED_SUCCESSFULLY', $this->adminLangId);
        }
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }


    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        
        $adminLangId = $this->adminLangId;
        if (0 < $recordId) {
            $adminLangId = $recordId;
        }

        $frm = new Form('frmLanguage');
        $frm->addHiddenField('', 'language_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('LBL_Language_code', $adminLangId), 'language_code');
        $frm->addRequiredField(Labels::getLabel('LBL_Language_name', $adminLangId), 'language_name');
        $fld = $frm->addRadioButtons(
            Labels::getLabel("LBL_Language_Layout_Direction", $adminLangId),
            'language_layout_direction',
            applicationConstants::getLayoutDirections($adminLangId),
            '',
            array('class' => 'list-inline')
        );

		$countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($adminLangId, true, 'country_code');
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $adminLangId), 'language_country_code', $countriesArr, '', array(), Labels::getLabel('LBL_Select', $adminLangId));
        $fld->requirement->setRequired(true);

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $adminLangId), 'language_active', $activeInactiveArr, '', array(), '');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $adminLangId));
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditLanguage();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Language::getAttributesById($recordId, array('language_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }            

        $status = ($data['language_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->changeStatus($recordId, $status);

        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditStates();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('language_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        
        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    private function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if($status == applicationConstants::INACTIVE && 1 > count(Language::getAllNames()) ){
            LibHelper::exitWithError(Labels::getLabel('MSG_PLEASE_MAINTAIN_ATLEAST_ONE_ACTIVE_LANGUAGE', $this->adminLangId), true);
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
                if(FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1)  == $recordId){
                    $dataToUpdate['CONF_DEFAULT_SITE_LANG'] = $firstActivelangData['language_id']; 
                }
                if(FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1)  == $recordId){
                    $dataToUpdate['CONF_ADMIN_DEFAULT_LANG'] = $firstActivelangData['language_id']; 
                    $_COOKIE['defaultAdminSiteLang'] = $firstActivelangData['language_id'];
                }
                if (!$configuration->update($dataToUpdate)) {
                    LibHelper::exitWithError($configuration->getError(), true);
                }
            }
        }
    }

    private function getFormColumns(): array
    {
        $languagesTblHeadingCols = CacheHelper::get('languagesTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($languagesTblHeadingCols) {
            return json_decode($languagesTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'language_code' => Labels::getLabel('LBL_Language_Code', $this->adminLangId),
            'language_name' => Labels::getLabel('LBL_Language_Name', $this->adminLangId),
            'language_active' => Labels::getLabel('LBL_Status', $this->adminLangId),
            'action' =>  '',
        ];
        CacheHelper::create('languagesTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'language_code',
            'language_name',
            'language_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['language_active'], Common::excludeKeysForSort());
    }
}
