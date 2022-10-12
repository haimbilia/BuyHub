<?php

class SystemLogController extends ListingBaseController
{
    protected string $modelClass = 'SystemLog';
    protected $pageKey = 'MANAGE_SYSTEM_LOGS';

    public function __construct($action)
    {   
        parent::__construct($action);
        $this->objPrivilege->canViewSystemLog();
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
            $this->set("canEdit", $this->objPrivilege->canEditSystemLog($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditSystemLog();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);       
        $actionItemsData['newRecordBtn'] = false;  

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->checkEditPrivilege(true);
        $this->getListingData();
        $this->_template->addJs(array('system-log/page-js/index.js'));
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_CONTENT_OR_TITLE', $this->siteLangId));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'system-log/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'slog_created_at');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'slog_created_at';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC), applicationConstants::SORT_DESC);

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData()); 

        $srch = SystemLog::getSearchObject();
        $srch->addMultipleFields(array('sylog.*'));
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('slog_content', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('slog_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $recordId = FatApp::getPostedData('slog_id', FatUtility::VAR_INT, -1);
        if ($recordId > 0) {
            $srch->addCondition('slog_id', '=', $recordId);
        }
        
        $log_type = FatApp::getPostedData('log_type', FatUtility::VAR_INT, -1);
        if ($log_type > -1) {
            $srch->addCondition('slog_type', '=', $log_type);
        }

        $module_type = FatApp::getPostedData('module_type', FatUtility::VAR_INT, -1);
        if ($module_type > -1) {
            $srch->addCondition('slog_module_type', '=', $module_type);
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);    

        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
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
        $this->checkEditPrivilege(true);

        $moduleTypes = SystemLog::getModuleTypes();
        $types = SystemLog::getTypes();
        $this->set('moduleTypes', $moduleTypes);
        $this->set('types', $types);
    }
    
    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'slog_created_at', applicationConstants::SORT_DESC);
        }
        
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'log_type', array('-1' => Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId)) + SystemLog::getTypes(), -1, array(), ''); 
        $frm->addSelectBox(Labels::getLabel('FRM_MODULE_TYPE', $this->siteLangId), 'module_type', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->siteLangId)) + SystemLog::getModuleTypes(), -1, array(), '');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        
        return $frm;
    }
    
    public function viewLog()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if(1 > $recordId){
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $srch = SystemLog::getSearchObject();
        $srch->addCondition('slog_id', '=', $recordId);
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        
        if (false == $row) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }            
     
        $this->set('moduleTypes', SystemLog::getModuleTypes());
        $this->set('types', SystemLog::getTypes());
        $this->set("detail", $row);    
        $this->set('html', $this->_template->render(false, false, null, true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function notificationList()
    {   
        $srch = SystemLog::getSearchObject();
        $srch->addMultipleFields(array('sylog.*')); 
        $srch->addOrder('slog_created_at', 'DESC');    
        $srch->setPageSize(20);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('labelArr', Notification::getLabelKeyString($this->siteLangId));
        $this->set('arrListing', $records);   
        $this->set('types', SystemLog::getTypes());

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getFormColumns(): array
    {
        $systemLogTblHeadingCols = CacheHelper::get('systemLogTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($systemLogTblHeadingCols) {
            return json_decode($systemLogTblHeadingCols, true);
        }

        $arr = [
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'slog_title' => Labels::getLabel('LBL_Title', $this->siteLangId),
            // 'slog_content' => Labels::getLabel('LBL_Content', $this->siteLangId),
            // 'slog_response' => Labels::getLabel('LBL_Response', $this->siteLangId),
            'slog_type'    => Labels::getLabel('LBL_Log_Type', $this->siteLangId),
            'slog_module_type' => Labels::getLabel('LBL_Module_Type', $this->siteLangId),
            'slog_created_at' => Labels::getLabel('LBL_CREATED_ON', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('systemLogTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'slog_title',
            // 'slog_content',
            // 'slog_response',
            'slog_type'   ,
            'slog_module_type',
            'slog_created_at',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

}
