<?php

class SellerApprovalRequestsController extends ListingBaseController
{

    protected string $modelClass = 'User';
    protected $pageKey = 'SELLER_APPROVAL_REQUESTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerApprovalRequests();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditSellerApprovalRequests($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($fields));
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), [
            'newRecordBtn' => false
        ]);
        $this->set('actionItemsData', $actionItemsData);
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_REFERENCE_NUMBER_OR_USER_DETAIL', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs(['seller-approval-requests/page-js/index.js']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'usuprequest_date', applicationConstants::SORT_DESC);
        }
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'status', ['-1' => Labels::getLabel('FRM_ALL', $this->siteLangId)] + User::getSupplierReqStatusArr($this->siteLangId), '', array(), '');
        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'seller-approval-requests/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $this->objPrivilege->canEditProductCategories();
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'usuprequest_date');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'usuprequest_date';
        }

        if ('user_details' == $sortBy) {
            $sortBy = 'user_name';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $userObj = new User();
        $srch = $userObj->getUserSupplierRequestsObj();
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('tusr.usuprequest_reference', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('u.user_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('uc.credential_email', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('uc.credential_username', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        if (!empty($post['date_from'])) {
            $srch->addCondition('tusr.usuprequest_date', '>=', $post['date_from'] . ' 00:00:00');
        }
        if ($post['status'] > -1 && $post['status'] != '') {
            $srch->addCondition('tusr.usuprequest_status', '=', $post['status']);
        }
        if (!empty($post['date_to'])) {
            $srch->addCondition('tusr.usuprequest_date', '<=', $post['date_to'] . ' 23:59:59');
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        if (0 < $recordId) {
            $srch->addCondition('usuprequest_id', '=', $recordId);
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addFld('tusr.*');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('reqStatusArr', User::getSupplierReqStatusArr($this->siteLangId));
        $this->set('canEdit', $this->objPrivilege->canEditSellerApprovalRequests($this->admin_id, true));
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditSellerApprovalRequests();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $userObj = new User();
        $srch = $userObj->getUserSupplierRequestsObj($recordId, false);
        $srch->addFld('tusr.*');
        $data = FatApp::getDb()->fetch($srch->getResultSet());
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm->fill($data);
        $this->set('includeTabs', false);
        $this->set('languages', []);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_SELLER_APPROVAL_REQUEST', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditSellerApprovalRequests();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $recordId = FatApp::getPostedData('usuprequest_id', FatUtility::VAR_INT, 0);
        unset($post['usuprequest_id']);
        $userObj = new User();
        $srch = $userObj->getUserSupplierRequestsObj($recordId, false);
        $srch->addFld('tusr.*');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $supplierRequest = FatApp::getDb()->fetch($srch->getResultSet());
        if ($supplierRequest == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $statusArr = array(User::SUPPLIER_REQUEST_APPROVED, User::SUPPLIER_REQUEST_CANCELLED);
        if (!in_array($post['usuprequest_status'], $statusArr)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Status_Request', $this->siteLangId), true);
        }

        if (in_array($post['usuprequest_status'], $statusArr) && in_array($supplierRequest['usuprequest_status'], $statusArr)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Status_Request', $this->siteLangId), true);
        }

        FatApp::getDb()->startTransaction();
        if (!$userObj->updateSupplierRequest(['request_id' => $supplierRequest['usuprequest_id'], 'status' => $post['usuprequest_status'], 'comments' => $post['comments']])) {
            FatApp::getDb()->rollbackTransaction();
            LibHelper::exitWithError($userObj->getError(), true);
        }

        if ($post['usuprequest_status'] == User::SUPPLIER_REQUEST_APPROVED && $supplierRequest['usuprequest_status'] != User::SUPPLIER_REQUEST_APPROVED) {
            $userObj->setMainTableRecordId($supplierRequest['usuprequest_user_id']);
            if (!$userObj->activateSupplier(applicationConstants::ACTIVE)) {
                FatApp::getDb()->rollbackTransaction();
                LibHelper::exitWithError($userObj->getError(), true);
            }

            $userObj->updateShopValidUser();
        }

        $email = new EmailHandler();
        $supplierRequest['usuprequest_status'] = $post['usuprequest_status'];
        $supplierRequest['usuprequest_comments'] = $post['comments'];
        if (!$email->sendSupplierRequestStatusChangeNotification($this->siteLangId, $supplierRequest)) {
            FatApp::getDb()->rollbackTransaction();
            LibHelper::exitWithError(Labels::getLabel('ERR_EMAIL_COULD_NOT_BE_SENT', $this->siteLangId), true);
        }
        FatApp::getDb()->commitTransaction();
        CalculativeDataRecord::updateSellerApprovalCount();
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function viewSellerRequest($requestId)
    {
        $this->objPrivilege->canViewSellerApprovalRequests();
        $requestId = FatUtility::int($requestId);
        if (1 > $requestId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $userObj = new User();
        $srch = $userObj->getUserSupplierRequestsObj($requestId, false);
        $srch->addFld('tusr.*');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $supplierRequest = FatApp::getDb()->fetch($srch->getResultSet());
        if ($supplierRequest == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $supplierRequest["field_values"] = $userObj->getSupplierRequestFieldsValueArr($requestId, $this->siteLangId);
        $this->set('reqStatusArr', User::getSupplierReqStatusArr($this->siteLangId));
        $this->set('supplierRequest', $supplierRequest);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function downloadAttachment($recordId, $recordSubid)
    {

        $recordId = FatUtility::int($recordId);
        $recordSubid = FatUtility::int($recordSubid);

        if (1 > $recordId || 1 > $recordSubid) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_SELLER_APPROVAL_FILE, $recordId, $recordSubid);

        if (false == $file_row) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($image_name, $file_row['afile_name']);
    }

    private function getForm()
    {
        $frm = new Form('frmapproval', array('id' => 'frmapproval'));
        $frm->addHiddenField('', 'usuprequest_id');
        $statusArr = User::getSupplierReqStatusArr($this->siteLangId);
        unset($statusArr[User::SUPPLIER_REQUEST_PENDING]);
        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_STATUS', $this->siteLangId), 'usuprequest_status', $statusArr, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirements()->setRequired();
        $frm->addTextArea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'comments', '');
        return $frm;
    }

    private function getFormColumns(): array
    {
        $shopsTblHeadingCols = CacheHelper::get('approvalRequestTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols, true);
        }

        $arr = [
            /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'usuprequest_reference' => Labels::getLabel('LBL_REFERENCE_NUMBER', $this->siteLangId),
            'user_details' => Labels::getLabel('LBL_USER_DETAIL', $this->siteLangId),
            'usuprequest_date' => Labels::getLabel('LBL_REQUESTED_ON', $this->siteLangId),
            'usuprequest_status' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('approvalRequestTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'usuprequest_reference',
            'user_details',
            'usuprequest_date',
            'usuprequest_status',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['usuprequest_reference'], Common::excludeKeysForSort());
    }
}
