<?php

class SystemLogController extends AdminBaseController
{
    private $canView;
    
    public function __construct($action)
    {   
        $ajaxCallArray = array();
        if (!FatUtility::isAjaxCall() && in_array($action, $ajaxCallArray)) {
            die($this->str_invalid_Action);
        }
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewSystemLog($this->admin_id, true);
        $this->set("canView", $this->canView);
    }

    public function index()
    {
        $this->objPrivilege->canViewSystemLog();
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewSystemLog();
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $post = $searchForm->getFormDataFromArray($data);
        //echo '<pre>'; print_r($post); die('123');
        $srch = SystemLog::getSearchObject();
        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $srch->addCondition('slog_content', 'like', '%' . $keyword . '%');
        }
        
        $log_type = FatApp::getPostedData('log_type', FatUtility::VAR_INT, -1);
        if ($log_type > -1) {
            $srch->addCondition('slog_type', '=', $log_type);
        }

        $module_type = FatApp::getPostedData('module_type', FatUtility::VAR_INT, -1);
        if ($module_type > -1) {
            $srch->addCondition('slog_module_type', '=', $module_type);
        }
        
        $moduleTypes = SystemLog::getModuleTypes();
        $types = SystemLog::getTypes();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('moduleTypes', $moduleTypes);
        $this->set('types', $types);
        $this->_template->render(false, false);
    }

    
    private function getSearchForm()
    {
        $this->objPrivilege->canViewSystemLog();
        $frm = new Form('frmSyslogSearch');
        $f1 = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword', '');
        $frm->addSelectBox(Labels::getLabel('LBL_Type', $this->adminLangId), 'log_type', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->adminLangId)) + SystemLog::getTypes(), -1, array(), ''); 
        $frm->addSelectBox(Labels::getLabel('LBL_Module_Type', $this->adminLangId), 'module_type', array('-1' => Labels::getLabel('LBL_Does_Not_Matter', $this->adminLangId)) + SystemLog::getModuleTypes(), -1, array(), '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

}
