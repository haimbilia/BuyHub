<?php

class SuccessStoriesController extends ListingBaseController
{
    private $canView;
    private $canEdit;
    
    public function __construct($action)
    {
        $ajaxCallArray = array('deleteRecord', 'form', 'langForm', 'search', 'setup', 'langSetup');
        if (!FatUtility::isAjaxCall() && in_array($action, $ajaxCallArray)) {
            die($this->str_invalid_Action);
        }
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewSuccessStories($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditSuccessStories($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }
    
    public function index()
    {
        $this->objPrivilege->canViewSuccessStories();
        
        $srchFrm = $this->getSearchForm();
        $this->set("srchFrm", $srchFrm);
        $this->_template->render();
    }
    
    public function search()
    {
        $this->objPrivilege->canViewSuccessStories();
        
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        
        $srch = SuccessStories::getSearchObject($this->siteLangId);
        $srch->addCondition('sstory_deleted', '=', 0);
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('ss.sstory_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('ss_l.sstory_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        //	$srch->setPageSize($pagesize);
        $srch->addOrder('sstory_active', 'DESC');
        $srch->addOrder('sstory_display_order', 'asc');
    
        $rs = $srch->getResultSet();
        
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }
        
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function form($sstory_id = 0)
    {
        $this->objPrivilege->canViewSuccessStories();
        
        $sstory_id = FatUtility::int($sstory_id);
        
        $frm = $this->getForm();
        $frm->fill(array( 'sstory_id' => $sstory_id ));

        if (0 < $sstory_id) {
            $srch = SuccessStories::getSearchObject($this->siteLangId, false);
            $srch->addCondition('sstory_id', '=', $sstory_id);
            $rs = $srch->getResultSet();
            $data = FatApp::getDb()->fetch($rs);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
    
        $this->set('languages', Language::getAllNames());
        $this->set('sstory_id', $sstory_id);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function setup()
    {
        $this->objPrivilege->canEditSuccessStories();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        
        $sstory_id = FatUtility::int($post['sstory_id']);
        unset($post['sstory_id']);
        
        $record = new SuccessStories($sstory_id);
        
        if ($sstory_id == 0) {
            $display_order = $record->getMaxOrder();
            $post['sstory_display_order'] = $display_order;
            $post['sstory_added_on'] = date('Y-m-d H:i:s');
        }
        
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($sstory_id > 0) {
            $sstory_id = $sstory_id;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = SuccessStories::getAttributesByLangId($langId, $sstory_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $sstory_id = $record->getMainTableRecordId();
            $newTabLangId = $this->siteLangId;
        }
        
        $this->set('msg', Labels::getLabel('MSG_CATEGORY_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('sstoryId', $sstory_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function langForm($sstory_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewSuccessStories();
        
        $sstory_id = FatUtility::int($sstory_id);
        $lang_id = FatUtility::int($lang_id);
        
        if ($sstory_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        
        $langFrm = $this->getLangForm($lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(SuccessStories::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($sstory_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = SuccessStories::getAttributesByLangId($lang_id, $sstory_id);
        }
        
        $langData['sstory_id'] = $sstory_id;
        $langData['lang_id'] = $lang_id;
        
        if ($langData) {
            $langFrm->fill($langData);
        }
        
        $this->set('languages', Language::getAllNames());
        $this->set('sstory_id', $sstory_id);
        $this->set('sstory_lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function langSetup()
    {
        $this->objPrivilege->canEditSuccessStories();
        $post = FatApp::getPostedData();

        $sstory_id = $post['sstory_id'];
        $lang_id = $post['lang_id'];

        if ($sstory_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['sstory_id']);
        unset($post['lang_id']);
        $data = array(
        'sstorylang_lang_id' => $lang_id,
        'sstorylang_sstory_id' => $sstory_id,
        'sstory_title' => $post['sstory_title'],
        'sstory_name' => $post['sstory_name'],
        'sstory_content' => $post['sstory_content'],
        );

        $obj = new SuccessStories($sstory_id);
        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(SuccessStories::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($sstory_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = SuccessStories::getAttributesByLangId($langId, $sstory_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
                
        $this->set('msg', $this->str_setup_successful);
        $this->set('sstoryId', $sstory_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function updateOrder()
    {
        $this->objPrivilege->canEditSuccessStories();

        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $obj = new SuccessStories();
            if (!$obj->updateOrder($post['stories'])) {
                LibHelper::exitWithError($obj->getError(), true);
            }
            FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Order_Updated_Successfully', $this->siteLangId));
        }
    }
    
    public function deleteRecord()
    {
        $this->objPrivilege->canEditSuccessStories();
        
        $sstory_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($sstory_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $res = SuccessStories::getAttributesById($sstory_id, array('sstory_id'));
        if ($res == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $obj = new SuccessStories($sstory_id);
        $obj->assignValues(array(SuccessStories::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }
    
    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmSearch');
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
    
    private function getForm()
    {
        $frm = new Form('frmStories');
        $frm->addHiddenField('', 'sstory_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'sstory_identifier');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SITE_DOMAIN', $this->siteLangId), 'sstory_site_domain');
        $fld->htmlAfterField = Labels::getLabel('FRM_EXAMPLE_:_sitename.com', $this->siteLangId);
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'sstory_active', $activeInactiveArr, '', array(), '');
        $frm->addCheckBox(Labels::getLabel('FRM_FEATURED', $this->siteLangId), 'sstory_featured', 1, array(), false, 0);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
    
    private function getLangForm($lang_id)
    {
        $frm = new Form('frmStories');
        $frm->addHiddenField('', 'sstory_id');
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'sstory_title');
        $frm->addTextBox(Labels::getLabel('FRM_NAME', $this->siteLangId), 'sstory_name');
        $frm->addTextArea(Labels::getLabel('FRM_CONTENT', $this->siteLangId), 'sstory_content');
        
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }
}
