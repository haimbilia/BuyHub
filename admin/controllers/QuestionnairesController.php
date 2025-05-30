<?php

class QuestionnairesController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewQuestionnaires($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditQuestionnaires($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewQuestionnaires();
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewQuestionnaires();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->countQuestions();
        $srch->countResponse();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('questionnaire_l.questionnaire_name', 'like', '%' . $post['keyword'] . '%');
            $cond->attachCondition('questionnaire.questionnaire_identifier', 'like', '%' . $post['keyword'] . '%');
        }
        if (!empty($post['from_date'])) {
            $srch->addCondition('questionnaire.questionnaire_start_date', '>=', $post['from_date']);
        }
        if (!empty($post['to_date'])) {
            $srch->addCondition('questionnaire.questionnaire_end_date', '<=', $post['to_date']);
        }
        $srch->addOrder('questionnaire.questionnaire_active', 'desc');
        $srch->addOrder('questionnaire_l.questionnaire_name', 'ASC');

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs, 'questionnaire_id');

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
        $this->objPrivilege->canEditQuestionnaires();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $questionnaire_id = $post['questionnaire_id'];
        unset($post['questionnaire_id']);

        $record = new Questionnaires($questionnaire_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($questionnaire_id > 0) {
            $questionnaireId = $questionnaire_id;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Questionnaires::getAttributesByLangId($langId, $questionnaire_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $questionnaireId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }


        $this->set('msg', $this->str_setup_successful);
        $this->set('questionnaireId', $questionnaireId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function form($questionnaire_id)
    {
        $this->objPrivilege->canViewQuestionnaires();

        $questionnaire_id = FatUtility::int($questionnaire_id);

        $frm = $this->getForm();

        $data = array('questionnaire_id' => $questionnaire_id);
        if ($questionnaire_id > 0) {
            $data = Questionnaires::getAttributesById($questionnaire_id);
            if ($data == false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }

        $frm->fill($data);

        $this->set('questionnaire_id', $questionnaire_id);
        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setupLang()
    {
        $this->objPrivilege->canEditQuestionnaires();
        $post = FatApp::getPostedData();

        $questionnaire_id = $post['questionnaire_id'];
        $lang_id = $post['lang_id'];

        if ($questionnaire_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($questionnaire_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['questionnaire_id']);
        unset($post['lang_id']);
        $data = array(
            'questionnairelang_lang_id' => $lang_id,
            'questionnairelang_questionnaire_id' => $questionnaire_id,
            'questionnaire_name' => $post['questionnaire_name'],
            'questionnaire_description' => $post['questionnaire_description'],
        );

        $obj = new Questionnaires($questionnaire_id);
        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Questionnaires::getAttributesByLangId($langId, $questionnaire_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('questionnaireId', $questionnaire_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($questionnaire_id = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewQuestionnaires();

        $questionnaire_id = FatUtility::int($questionnaire_id);
        $lang_id = FatUtility::int($lang_id);

        if ($questionnaire_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($questionnaire_id, $lang_id);
        $langData = Questionnaires::getAttributesByLangId($lang_id, $questionnaire_id);

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('questionnaire_id', $questionnaire_id);
        $this->set('questionnaire_lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditQuestionnaires();

        $questionnaire_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($questionnaire_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Questionnaires::getAttributesById($questionnaire_id);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj = new Questionnaires($questionnaire_id);
        $obj->assignValues(array(Questionnaires::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function searchLinkedQuestions()
    {
        $this->objPrivilege->canViewQuestionnaires();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getLinkedQuestionsSearchForm(FatApp::getPostedData('questionnaire_id', FatUtility::VAR_INT, 0));
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $questionnaireId = FatUtility::int($post['questionnaire_id']);
        if ($questionnaireId <= 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->joinQuestionnarieToQuestions();
        $srch->joinQuestions($this->siteLangId);
        $srch->joinQuestionBanks($this->siteLangId);
        $srch->addCondition('questionnaire_id', '=', $questionnaireId);

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->addOrder('qtq.qtq_display_order');

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function questions($questionnaireId)
    {
        $questionnaireId = FatUtility::int($questionnaireId);
        if ($questionnaireId <= 0) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl('Questionnaires'));
        }
        $this->objPrivilege->canViewQuestionnaires();

        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->addCondition('questionnaire_id', '=', $questionnaireId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        $this->set('questionnaireData', $record);
        $frmSearch = $this->getLinkedQuestionsSearchForm($questionnaireId);
        $this->set('frmSearch', $frmSearch);
        $this->set('questionnaireId', $questionnaireId);
        $this->_template->render();
    }

    public function viewReport($questionnaireId)
    {
        $questionnaireId = FatUtility::int($questionnaireId);
        if ($questionnaireId <= 0) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl('Questionnaires'));
        }
        $this->objPrivilege->canViewQuestionnaires();

        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->addCondition('questionnaire_id', '=', $questionnaireId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);

        $frmSearch = $this->getFeedbackSearchForm($questionnaireId);
        $this->set('frmSearch', $frmSearch);
        $this->set('questionnaireData', $record);
        $this->set('questionnaireId', $questionnaireId);
        $this->_template->render();
    }

    public function searchFeedbacks()
    {
        $this->objPrivilege->canViewQuestionnaires();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getFeedbackSearchForm(FatApp::getPostedData('questionnaire_id', FatUtility::VAR_INT, 0));
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $questionnaireId = FatUtility::int($post['questionnaire_id']);
        if ($questionnaireId <= 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->joinFeedbacks();
        $srch->addCondition('questionnaire_id', '=', $questionnaireId);
        $srch->addCondition('qfeedback_id', 'is not', 'mysql_func_null', 'and', true);
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('qfeedback_user_name', 'like', "%$post[keyword]%");
            $cond->attachCondition('qfeedback_user_email', 'like', "%$post[keyword]%");
        }
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->addOrder('qfeedback_added_on', 'desc');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function viewFeedback($feedbackId, $page = 1)
    {
        $data = FatApp::getPostedData();
        $feedbackId = FatUtility::int($feedbackId);
        $feedbackId = !empty($data['feedbackId']) ? $data['feedbackId'] : $feedbackId;
        if ($feedbackId <= 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $pagesize = 5;
        $page = ($page < 1) ? 1 : $page;

        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->joinFeedbacks();
        $srch->joinFeedbackToQuestions();
        $srch->joinFeedbackQuestionsToQuestions($this->siteLangId);
        $srch->addCondition('qta.qta_qfeedback_id', '=', $feedbackId);
        $srch->addMultipleFields(array('fq.question_type', 'fq_l.question_title', 'qta.qta_answers'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set('questions', $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', array('page' => $page, 'feedbackId' => $feedbackId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function generateLink($questionnaireId)
    {
        $this->objPrivilege->canViewQuestionnaires();
        $questionnaireId = FatUtility::int($questionnaireId);
        if ($questionnaireId <= 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = new QuestionnairesSearch($this->siteLangId, false);
        $srch->addCondition('questionnaire_id', '=', $questionnaireId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        $this->set('questionnaireData', $record);

        $this->set('link', UrlHelper::generateFullUrl('Questionnaire', 'view', array($questionnaireId), CONF_WEBROOT_FRONT_URL));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function searchQuestionsToLink()
    {
        $this->objPrivilege->canViewQuestions();

        $questionnaire_id = FatApp::getPostedData('questionnaire_id', FatUtility::VAR_INT, 0);
        $searchForm = $this->getLinkQuestionForm($questionnaire_id);
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $pagesize = 5;
        $post = $searchForm->getFormDataFromArray($data);
        $qbank_id = FatUtility::int($post['qbank']);
        $srch = Questions::getSearchObject($this->siteLangId, false);
        $srch->joinTable('tbl_questionnaires_to_question', 'left outer join', 'qtq.qtq_question_id= q.question_id and qtq.qtq_questionnaire_id=' . $questionnaire_id, 'qtq');
        $srch->addOrder('q_l.' . Questions::DB_TBL_PREFIX . 'title', 'ASC');
        $srch->addCondition('question_qbank_id', '=', $qbank_id);
        /* $srch->addCondition('qtq.qtq_question_id','is','mysql_func_null','and',true); */
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet(), 'question_id');
        $this->set("questionnaire_id", $questionnaire_id);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function linkQuestionsForm($questionnaire_id)
    {
        $this->objPrivilege->canViewQuestionnaires();
        $questionnaire_id = FatUtility::int($questionnaire_id);
        $frm = $this->getLinkQuestionForm($questionnaire_id);
        $data = array('questionnaire_id' => $questionnaire_id);
        $frm->fill($data);
        $this->set('questionnaire_id', $questionnaire_id);
        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function addQuestion()
    {
        $post = FatApp::getPostedData();
        if (empty($post['questionnaireId']) || empty($post['questionId'])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $questionnaireId = FatUtility::int($post['questionnaireId']);
        $questionId = FatUtility::int($post['questionId']);
        $dataToSave = array('qtq_question_id' => $questionId, 'qtq_questionnaire_id' => $questionnaireId);
        $questionnaireObj = new Questionnaires();
        if (!$questionnaireObj->addQuestionToQuestionnaire($dataToSave)) {
            LibHelper::exitWithError($questionnaireObj->getError(), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_QUESTION_ADDED_SUCCESSFULLY', $this->siteLangId));
    }

    public function removeQuestion()
    {
        $post = FatApp::getPostedData();
        if (empty($post['questionnaireId']) || empty($post['questionId'])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $questionnaireId = FatUtility::int($post['questionnaireId']);
        $questionId = FatUtility::int($post['questionId']);
        $whereCond = array('smt' => 'qtq_question_id = ? and qtq_questionnaire_id = ?', 'vals' => array($questionId, $questionnaireId));
        $db = FatApp::getDb();
        if (!$db->deleteRecords(Questionnaires::DB_TBL_QUESTIONNAIRE_TO_QUESTION, $whereCond)) {
            LibHelper::exitWithError($db->getError(), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('SCU_QUESTION_REMOVED_SUCCESSFULLY', $this->siteLangId));
    }

    public function updateQuestionsOrder()
    {
        $this->objPrivilege->canEditQuestionnaires();

        $post = FatApp::getPostedData();

        $questionnaireId = FatApp::getPostedData('questionnaire_id', FatUtility::VAR_INT, 0);
        $order = FatApp::getPostedData('linkedQuestions');
        if ($questionnaireId > 0 && is_array($order) && sizeof($order) > 0) {
            foreach ($order as $i => $id) {
                if (FatUtility::int($id) < 1) {
                    continue;
                }

                FatApp::getDb()->updateFromArray(
                    Questionnaires::DB_TBL_QUESTIONNAIRE_TO_QUESTION,
                    array(
                        Questionnaires::DB_TBL_QUESTIONNAIRE_TO_QUESTION_PREFIX . 'display_order' => $i
                    ),
                    array(
                        'smt' => Questionnaires::DB_TBL_QUESTIONNAIRE_TO_QUESTION_PREFIX . 'question_id = ? and ' . Questionnaires::DB_TBL_QUESTIONNAIRE_TO_QUESTION_PREFIX . 'questionnaire_id = ?',
                        'vals' => array($id, $questionnaireId)
                    )
                );
            }
            FatUtility::dieJsonSuccess(Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId));
        }
    }

    public function getSearchForm(array $fields = [])
    {
        $this->objPrivilege->canViewQuestionnaires();
        $frm = new Form('frmQuestionnaireSearch');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $frm->addDateField(Labels::getLabel('FRM_FROM_DATE', $this->siteLangId), 'from_date', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_TO_DATE', $this->siteLangId), 'to_date', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getLinkedQuestionsSearchForm($questionnaire_id)
    {
        $this->objPrivilege->canViewQuestionnaires();
        $frm = new Form('frmLinkedQuestionsSearch');
        $frm->addHiddenField('', 'questionnaire_id', $questionnaire_id);
        $frm->addHiddenField('', 'page');
        return $frm;
    }

    private function getLinkQuestionForm($questionnaire_id)
    {
        $this->objPrivilege->canViewQuestionnaires();
        $frm = new Form('frmLinkQuestions');
        $frm->addHiddenField('', 'questionnaire_id', $questionnaire_id);
        $frm->addHiddenField('', 'page');
        $questionBanksArr = QuestionBanks::getQuestionBankForSelectBox($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'qbank', $questionBanksArr, '', array(), '');
        return $frm;
    }

    private function getFeedbackSearchForm($questionnaire_id)
    {
        $this->objPrivilege->canViewQuestionnaires();
        $frm = new Form('frmFeedbackSearch');
        $frm->addHiddenField('', 'questionnaire_id', $questionnaire_id);
        $frm->addHiddenField('', 'page');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm($questionnaire_id = 0)
    {
        $this->objPrivilege->canViewQuestionnaires();
        $questionnaire_id = FatUtility::int($questionnaire_id);

        $frm = new Form('frmQuestionnaire');
        $frm->addHiddenField('', 'questionnaire_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'questionnaire_identifier');
        $frm->addDateField(Labels::getLabel('FRM_START_DATE', $this->siteLangId), 'questionnaire_start_date', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_END_DATE', $this->siteLangId), 'questionnaire_end_date', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'questionnaire_active', $activeInactiveArr, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($questionnaire_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmQuestionnaireLang');
        $frm->addHiddenField('', 'questionnaire_id', $questionnaire_id);
        $frm->addHiddenField('', 'lang_id', $lang_id);
        $frm->addRequiredField(Labels::getLabel('FRM_QUESTIONNAIRE_NAME', $this->siteLangId), 'questionnaire_name');
        $frm->addTextarea(Labels::getLabel('FRM_QUESTIONNAIRE_DESCRIPTION', $this->siteLangId), 'questionnaire_description')->requirements()->setRequired(true);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }

    private function getQuestionsForm($questionnaire_id = 0)
    {
        $frm = new Form('frmQuestionnaireQuestions');
        $frm->addHiddenField('', 'questionnaire_id', $questionnaire_id);
        $frm->addRequiredField(Labels::getLabel('FRM_QUESTIONNAIRE_NAME', $this->siteLangId), 'questionnaire_name');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }
}
