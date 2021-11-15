<?php

class SellerApprovalRequestsController extends ListingBaseController {

    protected $modelClass = 'User';
    protected $pageKey = 'MANAGE_SELLER_APPROVAL_REQUEST';
    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerApprovalRequests();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void {
        $this->objPrivilege->canEditSellerApprovalRequests();
        $this->modelObj = (new ReflectionClass('User'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_Manage_Seller_Approval_Requests_Setup', $this->siteLangId));
        $this->checkMediaExist = true;
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->set('canEdit', $this->objPrivilege->canEditSellerApprovalRequests($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', $pageTitle); 
        $this->getListingData();
        $this->_template->render();
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'usuprequest_status');
        }
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'status', ['-1' => Labels::getLabel('LBL_All', $this->siteLangId)] + User::getSupplierReqStatusArr($this->siteLangId), '', array(), '');
        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'seller-approval-requests/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $this->objPrivilege->canEditProductCategories();
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $userObj = new User();
        $srch = $userObj->getUserSupplierRequestsObj();
        $srch->addFld('tusr.*');
        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('tusr.usuprequest_reference', '=', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('u.user_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('uc.credential_email', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('uc.credential_username', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('tusr.usuprequest_reference', 'like', '%' . $post['keyword'] . '%', 'OR');
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
        $this->set('reqStatusArr', User::getSupplierReqStatusArr($this->siteLangId));
        $this->set('canEdit', $this->objPrivilege->canEditSellerApprovalRequests($this->admin_id, true));
    }

    public function form() {
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
        $this->set('languages', []);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup() {
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
            LibHelper::exitWithError($this->str_invalid_request);
        }

        $statusArr = array(User::SUPPLIER_REQUEST_APPROVED, User::SUPPLIER_REQUEST_CANCELLED);
        if (!in_array($post['usuprequest_status'], $statusArr)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Status_Request', $this->siteLangId));
        }

        if (in_array($post['usuprequest_status'], $statusArr) && in_array($supplierRequest['usuprequest_status'], $statusArr)) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Status_Request', $this->siteLangId));
        }

        FatApp::getDb()->startTransaction();
        if (!$userObj->updateSupplierRequest(['request_id' => $supplierRequest['usuprequest_id'], 'status' => $post['usuprequest_status']])) {
            FatApp::getDb()->rollbackTransaction();
            LibHelper::exitWithError($userObj->getError());
        }

        if ($post['usuprequest_status'] == User::SUPPLIER_REQUEST_APPROVED && $supplierRequest['usuprequest_status'] != User::SUPPLIER_REQUEST_APPROVED) {
            $userObj->setMainTableRecordId($supplierRequest['usuprequest_user_id']);
            if (!$userObj->activateSupplier(applicationConstants::ACTIVE)) {
                FatApp::getDb()->rollbackTransaction();
                LibHelper::exitWithError($userObj->getError());
            }
        }

        $email = new EmailHandler();
        $supplierRequest['usuprequest_status'] = $post['usuprequest_status'];
        $supplierRequest['usuprequest_comments'] = $post['comments'];
        if (!$email->sendSupplierRequestStatusChangeNotification($this->siteLangId, $supplierRequest)) {
            FatApp::getDb()->rollbackTransaction();
            LibHelper::exitWithError(Labels::getLabel('LBL_Email_Could_Not_Be_Sent', $this->siteLangId));
        }
        FatApp::getDb()->commitTransaction();
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function viewSellerRequest($requestId) {
        $this->objPrivilege->canViewSellerApprovalRequests();
        $requestId = FatUtility::int($requestId);
        if (1 > $requestId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $userObj = new User();
        $srch = $userObj->getUserSupplierRequestsObj($requestId, false);
        $srch->addFld('tusr.*');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $supplierRequest = FatApp::getDb()->fetch($srch->getResultSet());
        if ($supplierRequest == false) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $supplierRequest["field_values"] = $userObj->getSupplierRequestFieldsValueArr($requestId, $this->siteLangId);
        $this->set('reqStatusArr', User::getSupplierReqStatusArr($this->siteLangId));
        $this->set('supplierRequest', $supplierRequest);
        $this->_template->render(false, false);
    }

    private function getForm() {
        $frm = new Form('frmapproval', array('id' => 'frmapproval'));
        $frm->addHiddenField('', 'usuprequest_id');
        $statusArr = User::getSupplierReqStatusArr($this->siteLangId);
        unset($statusArr[User::SUPPLIER_REQUEST_PENDING]);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'usuprequest_status', $statusArr, '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirements()->setRequired();
        $frm->addTextArea('', 'comments', '');
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    private function getFormColumns(): array {
        $shopsTblHeadingCols = CacheHelper::get('approvalRequestTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'usuprequest_reference' => Labels::getLabel('LBL_Reference_Number', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_Name', $this->siteLangId),
            'user_details' => Labels::getLabel('LBL_Username/Email', $this->siteLangId),
            'usuprequest_date' => Labels::getLabel('LBL_Requested_On', $this->siteLangId),
            'usuprequest_status' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('approvalRequestTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array {
        return [
            'listSerial',
            'usuprequest_reference',
            'user_name',
            'user_details',
            'usuprequest_status',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['user_details', 'usuprequest_reference'], Common::excludeKeysForSort());
    }

}
