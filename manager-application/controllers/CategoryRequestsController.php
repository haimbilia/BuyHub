<?php

class CategoryRequestsController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewCategoryRequests($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditCategoryRequests($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewCategoryRequests();
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }
    
    public function search()
    {
        $this->objPrivilege->canViewCategoryRequests();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        /* $categoryReqObj = new CategoryRequest(); */
        $srch = CategoryRequest::getSearchObject($this->siteLangId);
        $srch->addFld('cat.*');

        if (!empty($post['keyword'])) {
            $srch->addCondition('cat.scategoryreq_identifier', 'like', '%' . $post['keyword'] . '%');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->addMultipleFields(array("cat_l.scategoryreq_name"));

        $rs = $srch->getResultSet();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }
        $statusArr = CategoryRequest::getCategoryReqStatusArr($this->siteLangId);
        $this->set('statusArr', $statusArr);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function form($categoryReqId = 0)
    {
        $this->objPrivilege->canEditCategoryRequests();
        $statusArr = CategoryRequest::getCategoryReqStatusArr($this->siteLangId);
        $categoryReqId = FatUtility::int($categoryReqId);
        $frm = $this->getForm($categoryReqId);

        if (0 < $categoryReqId) {
            $data = CategoryRequest::getAttributesById($categoryReqId, array('scategoryreq_id', 'scategoryreq_identifier', 'scategoryreq_seller_id', 'scategoryreq_status'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $data['status'] = $data['scategoryreq_status'];
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('categoryReqId', $categoryReqId);
        $this->set('frmCategoryReq', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($categoryReqId = 0)
    {
        $this->objPrivilege->canEditCategoryRequests();
        $categoryReqId = FatUtility::int($categoryReqId);
        $frm = new Form('frmcategoryReq', array('id' => 'frmCategoryReq'));
        $frm->addHiddenField('', 'scategoryreq_id', $categoryReqId);
        $frm->addHiddenField('', 'scategoryreq_seller_id', $categoryReqId);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_REQUEST_IDENTIFIER', $this->siteLangId), 'scategoryreq_identifier');
        $statusArr = CategoryRequest::getCategoryReqStatusArr($this->siteLangId);
        unset($statusArr[CategoryRequest::CATEGORY_REQUEST_PENDING]);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'status', $statusArr, '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirements()->setRequired();
        $frm->addTextArea('', 'comments', '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditCategoryRequests();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $categoryReqId = $post['scategoryreq_id'];
        unset($post['scategoryreq_id']);

        $creqObj = new CategoryRequest();
        $sCategoryRequest = $creqObj->getAttributesById($categoryReqId);

        if ($sCategoryRequest == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $statusArr = array(CategoryRequest::CATEGORY_REQUEST_APPROVED, CategoryRequest::CATEGORY_REQUEST_CANCELLED);
        if (!in_array($post['status'], $statusArr)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Status_Request', $this->siteLangId), true);
        }

        $db = FatApp::getDb();
        $db->startTransaction();
        if (in_array($post['status'], $statusArr)) {
            $post['request_id'] = $categoryReqId;
            if (!$creqObj->updateCategoryRequest($post)) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($creqObj->getError(), true);
            }
        }

        $db->commitTransaction();
        $this->set('msg', Labels::getLabel('LBL_Status_Updated_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($categoryReqId = 0, $lang_id = 0)
    {
        $this->objPrivilege->canEditCategoryRequests();

        $categoryReqId = FatUtility::int($categoryReqId);
        $lang_id = FatUtility::int($lang_id);

        if ($categoryReqId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $categoryReqLangFrm = $this->getLangForm($categoryReqId, $lang_id);

        $langData = CategoryRequest::getAttributesByLangId($lang_id, $categoryReqId);

        if ($langData) {
            $categoryReqLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('categoryReqId', $categoryReqId);
        $this->set('scategoryreq_lang_id', $lang_id);
        $this->set('categoryReqLangFrm', $categoryReqLangFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getLangForm($categoryReqId = 0, $lang_id = 0)
    {
        $frm = new Form('frmCategoryReqLang', array('id' => 'frmCategoryReqLang'));
        $frm->addHiddenField('', 'scategoryreq_id', $categoryReqId);
        $frm->addHiddenField('', 'lang_id', $lang_id);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_REQUEST_NAME', $this->siteLangId), 'scategoryreq_name');
        return $frm;
    }

    public function autoComplete()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();
        $this->objPrivilege->canViewCategoryRequests();

        $srch = CategoryRequest::getSearchObject();
        $srch->addOrder('categoryReqIdentifier');
        $srch->joinTable(
            CategoryRequest::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'scategoryreqlang_categoryReqId = categoryReqId AND scategoryreqlang_lang_id = ' . FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1)
        );
        $srch->addMultipleFields(array('categoryReqId, scategoryreq_name, categoryReqIdentifier'));

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('scategoryreq_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('categoryReqIdentifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $options = FatApp::getDb()->fetchAll($rs, 'categoryReqId');
        
        $json = array();
        foreach ($options as $key => $option) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($option['scategoryreq_name'], ENT_QUOTES, 'UTF-8')),
                'categoryReqIdentifier' => strip_tags(html_entity_decode($option['categoryReqIdentifier'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }
}
