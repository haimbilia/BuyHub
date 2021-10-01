<?php

class BlogCommentsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBlogComments();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_BLOG_COMMENTS', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
    }


    private function getListingData()
    {
        $db = FatApp::getDb();

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
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $srch = BlogComment::getSearchObject(true, $this->adminLangId);

        if (!empty($post['keyword'])) {
            $keywordCond = $srch->addCondition('bpcomment_author_name', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bpcomment_author_email', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('post_title', 'like', '%' . $post['keyword'] . '%');
        }

        if (isset($post['bpcomment_approved']) && $post['bpcomment_approved'] != '') {
            $srch->addCondition('bpcomment_approved', '=', $post['bpcomment_approved']);
        }
        if (isset($post['bpcomment_id']) && $post['bpcomment_id'] != '') {
            $srch->addCondition('bpcomment_id', '=', $post['bpcomment_id']);
        }
        $srch->addMultipleFields(array('bpcomment_id', 'bpcomment_author_name', 'bpcomment_author_email', 'bpcomment_approved', 'bpcomment_added_on', 'post_id', 'ifnull(post_title,post_identifier) post_title', 'bpcomment_id as listSerial'));
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
        $this->set('canEdit', $this->objPrivilege->canEditCountries($this->admin_id, true));
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'blog-comments/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getForm($recordId);
        $srch = BlogComment::getSearchObject(true, $this->adminLangId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('bpcomment_id', '=', $recordId);
        $data = FatApp::getDb()->fetch($srch->getResultSet());
        if ($data === false) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Invalid_Request', $this->adminLangId), true);
        }
        $frm->fill($data);
        $statusArr = BlogComment::getBlogCommentStatusArr($this->adminLangId);

        $this->set('statusArr', $statusArr);
        $this->set('data', $data);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('formLayout', Language::getLayoutDirection($this->adminLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBlogComments();

        $recordId = FatApp::getPostedData('bpcomment_id', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getForm($recordId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['bpcomment_id']);
        unset($post['bpcomment_id']);

        $oldData = BlogComment::getAttributesById($recordId);
        $record = new BlogComment($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        if ($oldData['bpcomment_approved'] != $post['bpcomment_approved']) {
            $srch = BlogComment::getSearchObject(true, $this->adminLangId);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $srch->addCondition('bpcomment_id', '=', $recordId);
            $newData = FatApp::getDb()->fetch($srch->getResultSet());
            $this->sendEmail($newData);
        }

        LibHelper::dieJsonSuccess(['msg' => $this->str_update_record]);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditBlogComments();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBlogComments();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('bpcomment_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }
        $obj = new BlogComment($recordId);
        if (!$obj->canMarkRecordDelete($recordId)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Unauthorized_Access', $this->adminLangId), true);
        }

        $obj->assignValues(array(BlogComment::tblFld('deleted') => 1));

        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }


    private function sendEmail($data)
    {
        if (empty($data)) {
            return false;
        }
        $emailObj = new EmailHandler();
        $emailObj->sendBlogCommentStatusChangeEmail($this->adminLangId, $data);
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmBlogComment', array('id' => 'frmBlogComment'));
        $frm->addHiddenField('', 'bpcomment_id', $recordId);
        $statusArr = BlogComment::getBlogCommentStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Comment_Status', $this->adminLangId), 'bpcomment_approved', $statusArr, '', [], Labels::getLabel('LBL_Select', $this->adminLangId));
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'bpcomment_id');        
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld->overrideFldType('search');

        $statusArr = BlogComment::getBlogCommentStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Comment_Status', $this->adminLangId), 'bpcomment_approved', $statusArr, '', array(), Labels::getLabel('LBL_Select', $this->adminLangId));
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        return $frm;
    }

    private function getFormColumns(): array
    {
        $blogCommentsTblHeadingCols = CacheHelper::get('blogCommentsTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($blogCommentsTblHeadingCols) {
            return json_decode($blogCommentsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'bpcomment_author_name' => Labels::getLabel('LBL_AUTHOR_NAME', $this->adminLangId),
            'bpcomment_author_email' => Labels::getLabel('LBL_AUTHOR_EMAIL', $this->adminLangId),
            'bpcomment_approved' => Labels::getLabel('LBL_STATUS', $this->adminLangId),
            'post_title' => Labels::getLabel('LBL_POST_TITLE', $this->adminLangId),
            'bpcomment_added_on' => Labels::getLabel('LBL_POSTED_ON', $this->adminLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->adminLangId),
        ];
        CacheHelper::create('blogCommentsTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'bpcomment_author_name',
            'bpcomment_author_email',
            'bpcomment_approved',
            'post_title',
            'bpcomment_added_on',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
