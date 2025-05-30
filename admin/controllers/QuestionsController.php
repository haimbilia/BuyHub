<?php

class QuestionsController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewQuestions($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditQuestions($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }
    
    public function getBreadcrumbNodes($action)
    {
        $nodes = array();
        $parameters = FatApp::getParameters();
        switch ($action) {
        case 'index':
            $nodes[] = array('title' => Labels::getLabel('LBL_QUESTION_BANKS', $this->siteLangId), 'href' => UrlHelper::generateUrl('QuestionBanks'));
            $nodes[] = array('title' => Labels::getLabel('LBL_QUESTION', $this->siteLangId));
            break;
        }
        return $nodes;
    }
    
    public function index($qbank_id = 0)
    {
        $this->objPrivilege->canViewQuestions();
        $qbank_id = FatUtility::int($qbank_id);
        
        $frmSearch = $this->getSearchForm();
        $frmSearch->getField('qbank_id')->value = $qbank_id;
        $this->set("qbank_id", $qbank_id);
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }
    
    public function search()
    {
        $this->objPrivilege->canViewQuestions();
        
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        
        $srch = Questions::getSearchObject($this->siteLangId, false);
        
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        
        if ($qbank_id = FatUtility::int($post['qbank_id'])) {
            $srch->addCondition('question_qbank_id', '=', $qbank_id);
        }
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('q_l.question_title', 'like', '%' . $post['keyword'] . '%');
            $cond->attachCondition('q.question_identifier', 'like', '%' . $post['keyword'] . '%');
        }
        $srch->addOrder('q.question_active', 'desc');
        $srch->addOrder('q_l.' . Questions::DB_TBL_PREFIX . 'title', 'ASC');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs, 'question_id');
        
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
        $this->objPrivilege->canEditQuestions();
        
        $qbank_id = FatApp::getPostedData('qbank_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($qbank_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $question_id = $post['question_id'];
        unset($post['question_id']);
        
        $record = new Questions($question_id);
        $record->assignValues($post);
        
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        
        $newTabLangId = 0;
        if ($question_id > 0) {
            $questionId = $question_id;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Questions::getAttributesByLangId($langId, $question_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $questionId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        
        
        $this->set('msg', $this->str_setup_successful);
        $this->set('questionId', $questionId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function form($qbank_id, $question_id)
    {
        $this->objPrivilege->canViewQuestions();
        
        $question_id = FatUtility::int($question_id);
        
        $frm = $this->getForm($qbank_id);
        
        $data = array('question_id' => $question_id);
        if ($question_id > 0) {
            $data = Questions::getAttributesById($question_id);
            if ($data == false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }
        
        $frm->fill($data);
        
        $this->set('qbank_id', $qbank_id);
        $this->set('question_id', $question_id);
        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function setupLang()
    {
        $this->objPrivilege->canEditQuestions();
        $post = FatApp::getPostedData();
        
        $question_id = $post['question_id'];
        $lang_id = $post['lang_id'];
        
        if ($question_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $frm = $this->getLangForm($question_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['question_id']);
        unset($post['lang_id']);
        $data = array(
        'questionlang_lang_id' => $lang_id,
        'questionlang_question_id' => $question_id,
        'question_title' => $post['question_title']
        );
        
        if (!empty($post['question_options'])) {
            $data['question_options'] = $post['question_options'];
        }
        
        $obj = new Questions($question_id);
        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Questions::getAttributesByLangId($langId, $question_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        
        $this->set('msg', $this->str_setup_successful);
        $this->set('questionId', $question_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function langForm($question_id = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewQuestions();
        
        $question_id = FatUtility::int($question_id);
        $lang_id = FatUtility::int($lang_id);
        
        if ($question_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        
        $langFrm = $this->getLangForm($question_id, $lang_id);
        $langData = Questions::getAttributesByLangId($lang_id, $question_id);
        $questData = Questions::getAttributesById($question_id);
        
        if ($langData) {
            $langFrm->fill($langData);
        }
        
        $this->set('languages', Language::getAllNames());
        $this->set('question_id', $question_id);
        $this->set('qbank_id', $questData['question_qbank_id']);
        $this->set('question_lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function deleteRecord()
    {
        $this->objPrivilege->canEditQuestions();
        
        $question_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($question_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Questions::getAttributesById($question_id);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $obj = new Questions($question_id);
        $obj->assignValues(array(Questions::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }
    
    private function getForm($qbank_id)
    {
        $this->objPrivilege->canViewQuestions();
        $qbank_id = FatUtility::int($qbank_id);
        
        $frm = new Form('frmQuestion');
        $frm->addHiddenField('', 'question_id', 0);
        $frm->addHiddenField('', 'question_qbank_id', $qbank_id);
        
        $questionTypesArr = Questions::getQuestionTypesArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'question_type', $questionTypesArr, '', array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'question_identifier');
        
        $frm->addCheckBox(Labels::getLabel('FRM_IS_REQUIRED', $this->siteLangId), 'question_required', 1, array(), false, 0);
        
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'question_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
    
    private function getLangForm($question_id = 0, $lang_id = 0)
    {
        $question_id = FatUtility::int($question_id);
        $questData = Questions::getAttributesById($question_id);
        
        $frm = new Form('frmQuestionLang');
        $frm->addHiddenField('', 'question_id', $question_id);
        $frm->addHiddenField('', 'lang_id', $lang_id);
        $frm->addRequiredField(Labels::getLabel('FRM_QUESTION_TITLE', $this->siteLangId), 'question_title');
        if ($questData['question_type'] == Questions::TYPE_SINGLE_CHOICE || $questData['question_type'] == Questions::TYPE_MULTIPLE_CHOICE) {
            $fld = $frm->addTextarea(Labels::getLabel('FRM_QUESTION_OPTIONS', $this->siteLangId), 'question_options');
            $fld->requirements()->setRequired();
            $fld->htmlAfterField = Labels::getLabel('FRM_ENTER_EACH_OPTION_IN_A_NEW_LINE.', $this->siteLangId);
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }
    
    public function getSearchForm(array $fields = [])
    {
        $this->objPrivilege->canViewQuestions();
        $frm = new Form('frmQuestionSearch');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $frm->addHiddenField('', 'qbank_id', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
}
