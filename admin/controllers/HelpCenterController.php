<?php

class HelpCenterController extends ListingBaseController
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
        $controller = strtolower($controller);
        $action = strtolower($action);
        $cacheKey = $controller .  $action . $this->siteLangId;

        $content = CacheHelper::get($cacheKey, CONF_DEF_CACHE_TIME, '.txt');
        if ($content) {
            die(json_decode($content, true));
        }
            
        $db = FatApp::getDb();

        $srch = new HelpCenterSearch($this->siteLangId);
        $srch->addCondition(HelpCenter::tblFld('user_type'), '=', HelpCenter::USER_TYPE_ADMIN);
        $srch->addCondition(HelpCenter::tblFld('controller'), '=', $controller);

        if (!empty($action)) {
            $srch->addCondition(HelpCenter::tblFld('action'), '=', $action);
        } else {
            $cnd = $srch->addCondition(HelpCenter::tblFld('action'), '=', 'index');
            $cnd->attachCondition(HelpCenter::tblFld('action'), '=', '');
        }

        $srch->addMultipleFields([
            'COALESCE(' . HelpCenter::DB_TBL_LANG_PREFIX . 'title' . ', ' . HelpCenter::DB_TBL_PREFIX . 'default_title) as ' . HelpCenter::DB_TBL_PREFIX . 'title',
            'COALESCE(' . HelpCenter::DB_TBL_LANG_PREFIX . 'description, ' . HelpCenter::DB_TBL_PREFIX . 'default_description) as ' . HelpCenter::DB_TBL_PREFIX . 'description',
        ]);
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        
        $record = (array) $db->fetch($srch->getResultSet());
        if (empty($record)) {
            $msg = empty($db->getError()) ? Labels::getLabel('MSG_NO_RECORD_FOUND', $this->siteLangId) : $db->getError();
            LibHelper::exitWithError($msg, true);
        }

        $this->set('record', $record);
        $json['html'] = $this->_template->render(false, false, 'help-center/get-content.php', true, true);
        $json['status'] = applicationConstants::SUCCESS;
        $json['msg'] = Labels::getLabel('MSG_SUCCESS', $this->siteLangId);

        CacheHelper::create($cacheKey, json_encode($json), CacheHelper::TYPE_HELP_CENTER);
        LibHelper::dieJsonSuccess($json);
    }
}
