<?php

class QuestionBanksController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewQuestionBanks($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditQuestionBanks($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }
    
    public function index()
    {
        $this->objPrivilege->canViewQuestionBanks();
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }
    
    public function search()
    {
        $this->objPrivilege->canViewQuestionBanks();
        
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        
        $srch = QuestionBanks::getSearchObject($this->siteLangId, false);
        
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('qb_l.qbank_name', 'like', '%' . $post['keyword'] . '%');
            $cond->attachCondition('qb.qbank_identifier', 'like', '%' . $post['keyword'] . '%');
        }
        $srch->addOrder('qb.qbank_active', 'desc');
        $srch->addOrder('qb_l.' . QuestionBanks::DB_TBL_PREFIX . 'name', 'ASC');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs, 'qbank_id');
        
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function setup()
    {
        $this->objPrivilege->canEditQuestionBanks();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $qbank_id = $post['qbank_id'];
        unset($post['qbank_id']);
        
        $record = new QuestionBanks($qbank_id);
        $record->assignValues($post);
        
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        
        $newTabLangId = 0;
        if ($qbank_id > 0) {
            $qbankId = $qbank_id;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = QuestionBanks::getAttributesByLangId($langId, $qbank_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $qbankId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        
        
        $this->set('msg', $this->str_setup_successful);
        $this->set('qbankId', $qbankId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function form($qbank_id)
    {
        $this->objPrivilege->canViewQuestionBanks();
        
        $qbank_id = FatUtility::int($qbank_id);
        
        $frm = $this->getForm();
        
        $data = array('qbank_id' => $qbank_id);
        if ($qbank_id > 0) {
            $data = QuestionBanks::getAttributesById($qbank_id);
            if ($data == false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }
        
        $frm->fill($data);
        
        $this->set('qbank_id', $qbank_id);
        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function setupLang()
    {
        $this->objPrivilege->canEditQuestionBanks();
        $post = FatApp::getPostedData();
        
        $qbank_id = $post['qbank_id'];
        $lang_id = $post['lang_id'];
        
        if ($qbank_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $frm = $this->getLangForm($qbank_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['qbank_id']);
        unset($post['lang_id']);
        $data = array(
        'qbanklang_lang_id' => $lang_id,
        'qbanklang_qbank_id' => $qbank_id,
        'qbank_name' => $post['qbank_name']
        );
        
        $obj = new QuestionBanks($qbank_id);
        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(QuestionBanks::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($qbank_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = QuestionBanks::getAttributesByLangId($langId, $qbank_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        
        $this->set('msg', $this->str_setup_successful);
        $this->set('qbankId', $qbank_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function langForm($qbank_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewQuestionBanks();
        
        $qbank_id = FatUtility::int($qbank_id);
        $lang_id = FatUtility::int($lang_id);
        
        if ($qbank_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        
        $langFrm = $this->getLangForm($qbank_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(QuestionBanks::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($qbank_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = QuestionBanks::getAttributesByLangId($lang_id, $qbank_id);
        }
        
        if ($langData) {
            $langFrm->fill($langData);
        }
        
        $this->set('languages', Language::getAllNames());
        $this->set('qbank_id', $qbank_id);
        $this->set('qbank_lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function deleteRecord()
    {
        $this->objPrivilege->canEditQuestionBanks();
        
        $qbank_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($qbank_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = QuestionBanks::getAttributesById($qbank_id);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $obj = new QuestionBanks($qbank_id);
        $obj->assignValues(array(QuestionBanks::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }
    
    public function getSearchForm(array $fields = [])
    {
        $this->objPrivilege->canViewQuestionBanks();
        $frm = new Form('frmQuestionBankSearch');
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
    
    private function getForm($qbank_id = 0)
    {
        $this->objPrivilege->canViewQuestionBanks();
        $qbank_id = FatUtility::int($qbank_id);
        
        $frm = new Form('frmQuestionBank');
        $frm->addHiddenField('', 'qbank_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'qbank_identifier');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'qbank_active', $activeInactiveArr, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
    
    private function getLangForm($qbank_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmQuestionBankLang');
        $frm->addHiddenField('', 'qbank_id', $qbank_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_QUESTION_BANK_NAME', $this->siteLangId), 'qbank_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
                
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }
}
