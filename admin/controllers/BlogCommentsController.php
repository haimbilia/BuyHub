<?php

class BlogCommentsController extends ListingBaseController
{
    protected $pageKey = 'BLOG_COMMENTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBlogComments();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $actionItemsData['performBulkAction'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_AUTHOR_NAME,_EMAIL_AND_POST_TITLE', $this->siteLangId));
        $this->getListingData();

        $this->_template->render(true, true, '_partial/listing/index.php');
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

    private function getListingData()
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = BlogComment::getSearchObject(true, $this->siteLangId); 
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $keywordCond = $srch->addCondition('bpcomment_author_name', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bpcomment_author_email', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('post_title', 'like', '%' . $post['keyword'] . '%');
        }

        if (isset($post['bpcomment_approved']) && $post['bpcomment_approved'] != '') {
            $srch->addCondition('bpcomment_approved', '=', $post['bpcomment_approved']);
        }        

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        $commentId = FatApp::getPostedData('bpcomment_id', FatUtility::VAR_INT, $recordId);
        if (0 < $commentId) {
            $srch->addCondition('bpcomment_id', '=', $commentId);
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords(); 
        $srch->addMultipleFields(array('bpcomment_id', 'bpcomment_author_name', 'bpcomment_author_email', 'bpcomment_approved', 'bpcomment_added_on', 'post_id', 'ifnull(post_title,post_identifier) post_title'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);  
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet())); 
        $this->set('postedData', $post); 
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBlogComments($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getForm($recordId);
        $srch = BlogComment::getSearchObject(true, $this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('bpcomment_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        $data = FatApp::getDb()->fetch($srch->getResultSet());
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm->fill($data);
        $statusArr = BlogComment::getBlogCommentStatusArr($this->siteLangId);

        $this->set('statusArr', $statusArr);
        $this->set('data', $data);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
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
            $srch = BlogComment::getSearchObject(true, $this->siteLangId);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $srch->addCondition('bpcomment_id', '=', 'mysql_func_' . $recordId, 'AND', true);
            $newData = FatApp::getDb()->fetch($srch->getResultSet());
            $this->sendEmail($newData);
        }
        CalculativeDataRecord::updateBlogCommentRequestCount();
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
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new BlogComment($recordId);
        if (!$obj->canMarkRecordDelete($recordId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Unauthorized_Access', $this->siteLangId), true);
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
        $emailObj->sendBlogCommentStatusChangeEmail($this->siteLangId, $data);
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmBlogComment', array('id' => 'frmBlogComment'));     
        $frm->addTextArea(Labels::getLabel('FRM_BLOG_COMMENT', $this->siteLangId), 'bpcomment_content');
        $frm->addHiddenField('', 'bpcomment_id', $recordId);
        $statusArr = BlogComment::getBlogCommentStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_COMMENT_STATUS', $this->siteLangId), 'bpcomment_approved', $statusArr, '', [], Labels::getLabel('LBL_Select', $this->siteLangId));
        return $frm;
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'bpcomment_id');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'bpcomment_author_name');
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $statusArr = BlogComment::getBlogCommentStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_COMMENT_STATUS', $this->siteLangId), 'bpcomment_approved', $statusArr, '', array(), Labels::getLabel('LBL_SELECT_COMMENT_STATUS', $this->siteLangId));
        $frm->addHiddenField('', 'total_record_count'); 
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $blogCommentsTblHeadingCols = CacheHelper::get('blogCommentsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($blogCommentsTblHeadingCols) {
            return json_decode($blogCommentsTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'bpcomment_author_name' => Labels::getLabel('LBL_AUTHOR_NAME', $this->siteLangId),
            'bpcomment_author_email' => Labels::getLabel('LBL_AUTHOR_EMAIL', $this->siteLangId),
            'bpcomment_approved' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'post_title' => Labels::getLabel('LBL_POST_TITLE', $this->siteLangId),
            'bpcomment_added_on' => Labels::getLabel('LBL_POSTED_ON', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('blogCommentsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'bpcomment_author_name',
            'bpcomment_author_email',
            'bpcomment_approved',
            'post_title',
            'bpcomment_added_on',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
