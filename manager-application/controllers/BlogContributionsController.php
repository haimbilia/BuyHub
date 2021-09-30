<?php

class BlogContributionsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBlogContributions();

    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_BLOG_CONTRIBUTIONS', $this->adminLangId));
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

        $srch = BlogContribution::getSearchObject();

        if (!empty($post['keyword'])) {
            $keywordCond = $srch->addCondition('bcontributions_author_first_name', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bcontributions_author_last_name', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bcontributions_author_email', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bcontributions_author_phone', 'like', '%' . $post['keyword'] . '%');
        }

        if (isset($post['bcontributions_status']) && $post['bcontributions_status'] != '') {
            $srch->addCondition('bcontributions_status', '=', $post['bcontributions_status']);
        }
        if (isset($post['bcontributions_id']) && $post['bcontributions_id'] != '') {
            $srch->addCondition('bcontributions_id', '=', $post['bcontributions_id']);
        }
        $srch->addMultipleFields(array('*', 'concat(bcontributions_author_first_name," ",bcontributions_author_last_name) author_name', 'bcontributions_id as listSerial'));
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
            'listingHtml' => $this->_template->render(false, false, 'blog-contributions/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
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
            LibHelper::exitWithError(Labels::getLabel('MSG_Invalid_Request', $this->adminLangId), true);
        }
        $frm->fill($data);
        $statusArr = BlogContribution::getBlogContributionStatusArr($this->adminLangId);
        if ($attachedFile = AttachedFile::getAttachment(AttachedFile::FILETYPE_BLOG_CONTRIBUTION, $recordId)) {
            $this->set('attachedFile', $attachedFile['afile_name']);
        }

        $this->set('statusArr', $statusArr);
        $this->set('data', $data);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('formLayout', Language::getLayoutDirection($this->adminLangId));
        $this->_template->render(false, false);
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
        $emailObj->sendBlogContributionStatusChangeEmail($this->adminLangId, $data);
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmBlogContribution', array('id' => 'frmBlogContribution'));
        $frm->addHiddenField('', 'bcontributions_id', $recordId);
        $statusArr = BlogContribution::getBlogContributionStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Contribution_Status', $this->adminLangId), 'bcontributions_status', $statusArr, '', array(), '');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'bcontributions_id');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword', '', array('class' => 'search-input'));
        $statusArr = BlogContribution::getBlogContributionStatusArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Contribution_Status', $this->adminLangId), 'bcontributions_status', $statusArr, '', array(), Labels::getLabel('LBL_Select', $this->adminLangId));        
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        return $frm;
    }

    private function getFormColumns(): array
    {
        $blogContributionTblHeadingCols = CacheHelper::get('blogContributionTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($blogContributionTblHeadingCols) {
            return json_decode($blogContributionTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'author_name' => Labels::getLabel('LBL_Author_Name', $this->adminLangId),
            'bcontributions_author_email' => Labels::getLabel('LBL_Author_Email', $this->adminLangId),
            'bcontributions_author_phone' => Labels::getLabel('LBL_Author_Phone', $this->adminLangId),
            'bcontributions_status' => Labels::getLabel('LBL_Status', $this->adminLangId),
            'bcontributions_added_on' => Labels::getLabel('LBL_Posted_On', $this->adminLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->adminLangId),
        ];
        CacheHelper::create('blogContributionTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'author_name',
            'bcontributions_author_email',
            'bcontributions_author_phone',
            'bcontributions_status',
            'bcontributions_added_on',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
