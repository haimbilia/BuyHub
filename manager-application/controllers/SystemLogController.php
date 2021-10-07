<?php

class SystemLogController extends AdminBaseController
{
    public function __construct($action)
    {   
        parent::__construct($action);
        $this->objPrivilege->canViewSystemLog();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_SYSTEM_LOG', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
    }

    private function getListingData()
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

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $attr = array(
            'sylog.*',
            'slog_id as listSerial'
        );
        $srch = SystemLog::getSearchObject();
        $srch->addMultipleFields($attr);
        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('slog_content', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('slog_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        
        $log_type = FatApp::getPostedData('log_type', FatUtility::VAR_INT, -1);
        if ($log_type > -1) {
            $srch->addCondition('slog_type', '=', $log_type);
        }

        $module_type = FatApp::getPostedData('module_type', FatUtility::VAR_INT, -1);
        if ($module_type > -1) {
            $srch->addCondition('slog_module_type', '=', $module_type);
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
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
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditCommissionSettings($this->admin_id, true));

        $moduleTypes = SystemLog::getModuleTypes();
        $types = SystemLog::getTypes();
        $this->set('moduleTypes', $moduleTypes);
        $this->set('types', $types);
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

    
    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld->overrideFldType('search');
        $frm->addSelectBox(Labels::getLabel('LBL_Type', $this->adminLangId), 'log_type', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->adminLangId)) + SystemLog::getTypes(), -1, array(), ''); 
        $frm->addSelectBox(Labels::getLabel('LBL_Module_Type', $this->adminLangId), 'module_type', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->adminLangId)) + SystemLog::getModuleTypes(), -1, array(), '');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        
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
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        
        if (false == $row) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }    
        
        $moduleTypes = SystemLog::getModuleTypes();
        $types = SystemLog::getTypes();
        $this->set('moduleTypes', $moduleTypes);
        $this->set('types', $types);
        $this->set("detail", $row);
        $this->_template->render(false, false, null, false, false);
    }

    private function getFormColumns(): array
    {
        $systemLogTblHeadingCols = CacheHelper::get('systemLogTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($systemLogTblHeadingCols) {
            return json_decode($systemLogTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'slog_title' => Labels::getLabel('LBL_Title', $this->adminLangId),
            'slog_content' => Labels::getLabel('LBL_Content', $this->adminLangId),
            'slog_response' => Labels::getLabel('LBL_Response', $this->adminLangId),
            'slog_type'    => Labels::getLabel('LBL_Log_Type', $this->adminLangId),
            'slog_module_type' => Labels::getLabel('LBL_Module_Type', $this->adminLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->adminLangId),
        ];
        CacheHelper::create('systemLogTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'slog_title',
            'slog_content',
            'slog_response',
            'slog_type'   ,
            'slog_module_type',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

}
