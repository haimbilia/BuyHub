<?php

class BlogContributionsController extends ListingBaseController
{
    protected $pageKey = 'BLOG_CONTRIBUTION';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBlogContributions();
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
        $actionItemsData['searchFrmTemplate'] = 'blog-contributions/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_AUTHOR_NAME_EMAIL_AND_PHONE_WITHOUT_CODE', $this->siteLangId));
        $this->getListingData();

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'blog-contributions/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'bcontributions_added_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'bcontributions_added_on';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = BlogContribution::getSearchObject();

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $keywordCond = $srch->addCondition('bcontributions_author_first_name', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bcontributions_author_last_name', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('mysql_func_concat(bcontributions_author_first_name," ",bcontributions_author_last_name)', 'like', '%' . $post['keyword'] . '%','or',true);
            $keywordCond->attachCondition('bcontributions_author_email', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bcontributions_author_phone', 'like', '%' . $post['keyword'] . '%');
        }

        if (isset($post['bcontributions_status']) && $post['bcontributions_status'] != '') {
            $srch->addCondition('bcontributions_status', '=', $post['bcontributions_status']);
        }        

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        $contributionId = FatApp::getPostedData('bcontributions_id', FatUtility::VAR_INT, $recordId);
        if (0 < $contributionId) {
            $srch->addCondition('bcontributions_id', '=', $contributionId);
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords(); 
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize); 
        $srch->addOrder($sortBy, $sortOrder); 
        $srch->addMultipleFields(array('*', 'concat(bcontributions_author_first_name," ",bcontributions_author_last_name) author_name'));
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet())); 
        $this->set('postedData', $post); 
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBlogContributions($this->admin_id, true));
    }

    public function downloadAttachedFile($recordId, $recordSubid = 0)
    {
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_BLOG_CONTRIBUTION, $recordId, $recordSubid);

        if (false == $file_row) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileName = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file_row['afile_name']);
    }

    public function form()
    {
        $this->objPrivilege->canEditBlogContributions();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getForm($recordId);
        $data = BlogContribution::getAttributesById($recordId);
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm->fill($data);
        $statusArr = BlogContribution::getBlogContributionStatusArr($this->siteLangId);
        if ($attachedFile = AttachedFile::getAttachment(AttachedFile::FILETYPE_BLOG_CONTRIBUTION, $recordId)) {
            $this->set('attachedFile', $attachedFile['afile_name']);
        }

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
        $this->objPrivilege->canEditBlogContributions();

        $recordId = FatApp::getPostedData('bcontributions_id', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getForm($recordId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $oldData = BlogContribution::getAttributesById($recordId);
        $record = new BlogContribution($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        /* code for sending email on changing status [
        */
        $newData = BlogContribution::getAttributesById($recordId);
        if ($oldData['bcontributions_status'] != $newData['bcontributions_status']) {
            $this->sendEmail($newData);
        }
        /*
        ] */
        CalculativeDataRecord::updateBlogContributionRequestCount();
        LibHelper::dieJsonSuccess(['msg' => $this->str_update_record]);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditBlogContributions();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBlogContributions();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('bcontributions_ids'));

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
        $obj = new BlogContribution($recordId);
        if (!$obj->deleteRecord()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function sendEmail($data)
    {
        if (empty($data)) {
            return false;
        }
        $emailObj = new EmailHandler();
        $emailObj->sendBlogContributionStatusChangeEmail($this->siteLangId, $data);
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmBlogContribution', array('id' => 'frmBlogContribution'));
        $frm->addHiddenField('', 'bcontributions_id', $recordId);
        $statusArr = BlogContribution::getBlogContributionStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_CONTRIBUTION_STATUS', $this->siteLangId), 'bcontributions_status', $statusArr, '', array(), '');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'bcontributions_id');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'bcontributions_added_on', applicationConstants::SORT_DESC);
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $statusArr = BlogContribution::getBlogContributionStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_CONTRIBUTION_STATUS', $this->siteLangId), 'bcontributions_status', $statusArr, '', array(), Labels::getLabel('LBL_SELECT_CONTRIBUTION_STATUS', $this->siteLangId));        
        $frm->addHiddenField('', 'total_record_count'); 
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $blogContributionTblHeadingCols = CacheHelper::get('blogContributionTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($blogContributionTblHeadingCols) {
            return json_decode($blogContributionTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'author_name' => Labels::getLabel('LBL_AUTHOR_NAME', $this->siteLangId),
            'bcontributions_author_email' => Labels::getLabel('LBL_AUTHOR_EMAIL', $this->siteLangId),
            'bcontributions_author_phone' => Labels::getLabel('LBL_AUTHOR_PHONE', $this->siteLangId),
            'bcontributions_status' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'bcontributions_added_on' => Labels::getLabel('LBL_POSTED_ON', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('blogContributionTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'author_name',
            'bcontributions_author_email',
            'bcontributions_author_phone',
            'bcontributions_status',
            'bcontributions_added_on',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
