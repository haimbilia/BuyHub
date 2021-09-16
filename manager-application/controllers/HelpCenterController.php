<?php

class HelpCenterController extends AdminBaseController
{   
    /**
     * __construct
     *
     * @param  string $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }
    
    /**
     * getContent
     *
     * @param  string $controller
     * @param  string $action
     * @return void
     */
    public function getContent(string $controller, string $action = "")
    {        
        $db = FatApp::getDb();

        $srch = new HelpCenterSearch($this->adminLangId);
        $srch->addCondition(HelpCenter::tblFld('user_type'), '=', HelpCenter::USER_TYPE_ADMIN);
        $srch->addCondition(HelpCenter::tblFld('controller'), '=', $controller);

        if (!empty($action)) {
            $srch->addCondition(HelpCenter::tblFld('action'), '=', $action);
        }

        $srch->addMultipleFields([
            'COALESCE(' . HelpCenter::DB_TBL_LANG_PREFIX . 'title' . ', ' . HelpCenter::DB_TBL_PREFIX . 'default_title) as ' . HelpCenter::DB_TBL_PREFIX . 'title',
            'COALESCE(' . HelpCenter::DB_TBL_LANG_PREFIX . 'description, ' . HelpCenter::DB_TBL_PREFIX . 'default_description) as ' . HelpCenter::DB_TBL_PREFIX . 'description',
        ]);
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        $record = $db->fetch($srch->getResultSet());
        if (false === $record) {
            LibHelper::exitWithError($db->getError(), true);
        }

        $this->set('record', $record);
        $json['html'] = $this->_template->render(false, false, 'help-center/get-content.php', true, false);
        $json['status'] = applicationConstants::SUCCESS;
        $json['msg'] = Labels::getLabel('MSG_SUCCESS', $this->adminLangId);
        FatUtility::dieJsonSuccess($json);
    }
}
