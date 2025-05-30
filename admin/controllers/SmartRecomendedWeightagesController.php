<?php

class SmartRecomendedWeightagesController extends ListingBaseController
{
    protected $pageKey = 'MANAGE_WEIGHTAGES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewRecomendedWeightages();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_EVENT', $this->siteLangId));
        $this->getListingData();
        
        $this->_template->addJs(['smart-recomended-weightages/page-js/index.js']);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'smart-recomended-weightages/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
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

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = SmartWeightageSettings::getSearchObject(); 
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $srch->addCondition('sws.swsetting_name', 'like', '%' . $post['keyword'] . '%');
        }
        
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(['sws.*']);
        $srch->addOrder($sortBy, $sortOrder); 
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);   
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet())); 
        $this->set('postedData', $post); 
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditRecomendedWeightages($this->admin_id, true));
        
    }

    public function setup()
    {
        $this->objPrivilege->canEditRecomendedWeightages();
        $swsetting_key = FatApp::getPostedData('swsetting_key');
        if (1 > $swsetting_key) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $weightage = FatApp::getPostedData('weightage', FatUtility::VAR_FLOAT, 0);

        $weightageKeyArr = SmartWeightageSettings::getWeightageKeyArr();
        if (!array_key_exists($swsetting_key, $weightageKeyArr)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj = new SmartWeightageSettings($swsetting_key);

        $obj->assignValues(
            array(
            SmartWeightageSettings::tblFld('weightage') => $weightage,
            SmartWeightageSettings::tblFld('name') => $weightageKeyArr[$swsetting_key])
        );
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array
    {
        $smartRecWeightagesTblHeadingCols = CacheHelper::get('smartRecWeightagesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($smartRecWeightagesTblHeadingCols) {
            return json_decode($smartRecWeightagesTblHeadingCols, true);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'swsetting_name' => Labels::getLabel('LBL_Event', $this->siteLangId),
            'swsetting_weightage' => Labels::getLabel('LBL_Weightage', $this->siteLangId),
        ];

        if(count(Language::getAllNames()) < 2 ){
            unset($arr['language_name']);
        }

        CacheHelper::create('smartRecWeightagesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [    
            /* 'listSerial', */
            'swsetting_name',
            'swsetting_weightage',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
