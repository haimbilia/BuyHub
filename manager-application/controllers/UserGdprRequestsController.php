<?php

class UserGdprRequestsController extends ListingBaseController {

    protected string $modelClass = 'UserGdprRequest';
    protected $pageKey = 'MANAGE_USER_REQUEST';

    public function __construct($action) {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->objPrivilege->canViewUserRequests();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditUserRequests($this->admin_id, true));
        $this->set("frmSearch", $this->getSearchForm($fields));
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), [
            'newRecordBtn' => false
        ]);
        $this->set('actionItemsData', $actionItemsData);
        $this->getListingData();
         $this->_template->addCss(['css/select2.min.css']);
        $this->_template->addJs(['js/select2.js', 'user-gdpr-requests/page-js/index.js']); 
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'user-gdpr-requests/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $this->objPrivilege->canEditUserRequests();
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
        $srch = new UserGdprRequestSearch();
        $srch->joinUser();
        $srch->addMultipleFields(array('user_id', 'user_name', 'user_phone_dcode', 'user_phone', 'credential_email', 'credential_username', 'ureq_id', 'ureq_status', 'ureq_type', 'ureq_date'));
        $srch->addCondition('ureq_deleted', '=', applicationConstants::NO);
        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, -1);
        if ($user_id > 0) {
            $srch->addCondition('user_id', '=', $user_id);
        } else {
            $keyword = FatApp::getPostedData('keyword', null, '');
            if (!empty($keyword)) {
                $cond = $srch->addCondition('uc.credential_username', 'like', '%' . $keyword . '%');
                $cond->attachCondition('uc.credential_email', 'like', '%' . $keyword . '%', 'OR');
                $cond->attachCondition('u.user_name', 'like', '%' . $keyword . '%');
            }
        }
        $request_type = FatApp::getPostedData('request_type', FatUtility::VAR_INT, -1);
        if ($request_type > -1) {
            $srch->addCondition('ureq_type', '=', $request_type);
        }
        $user_request_from = FatApp::getPostedData('user_request_from', FatUtility::VAR_DATE, '');
        if (!empty($user_request_from)) {
            $srch->addCondition('ureq_date', '>=', $user_request_from . ' 00:00:00');
        }

        $user_request_to = FatApp::getPostedData('user_request_to', FatUtility::VAR_DATE, '');
        if (!empty($user_request_to)) {
            $srch->addCondition('ureq_date', '<=', $user_request_to . ' 23:59:59');
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
        $this->set("arrListing", $records);
        $this->set("userRequestTypeArr", UserGdprRequest::getUserRequestTypesArr($this->siteLangId));
        $this->set("userRequestStatusArr", UserGdprRequest::getUserRequestStatusesArr($this->siteLangId));
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('reqStatusArr', User::getSupplierReqStatusArr($this->siteLangId));
        $this->set('canEdit', $this->objPrivilege->canEditSellerApprovalRequests($this->admin_id, true));
    }

    public function updateRequestStatus() {
        $this->objPrivilege->canEditUserRequests();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $userReqId = FatUtility::int($post['reqId']);
        $status = FatUtility::int($post['status']);
        if (1 > $userReqId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->gdprRequestStatusUpdate($userReqId, $this->siteLangId)) {
            LibHelper::exitWithError($emailNotificationObj->getError(), true);
        }

        $userRequest = new UserGdprRequest($userReqId);
        if (!$userRequest->updateRequestStatus($status)) {
            LibHelper::exitWithError($userRequest->getError(), true);
        }
        $this->set('msg', Labels::getLabel('LBL_Updated_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function viewUserRequest($userReqId) {
        $userReqId = FatUtility::int($userReqId);
        if (1 > $userReqId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = new UserGdprRequestSearch();
        $srch->joinUser();
        $srch->addMultipleFields(array('user_name', 'user_phone_dcode', 'user_phone', 'credential_email', 'credential_username', 'ureq_date', 'ureq_purpose'));
        $srch->addCondition('ureq_id', '=', $userReqId);
        $srch->addCondition('ureq_deleted', '=', applicationConstants::NO);
        $rs = $srch->getResultSet();
        $userRequest = FatApp::getDb()->fetch($rs);
        if ($userRequest == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $this->set('userRequest', $userRequest);
        $this->_template->render(false, false);
    }

    public function truncateUserData() {
        $this->objPrivilege->canEditUserRequests();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $userId = FatUtility::int($post['userId']);
        $userReqId = FatUtility::int($post['reqId']);

        $userObj = new User($userId);
        if (!$userObj->truncateUserInfo()) {
            LibHelper::exitWithError(Labels::getLabel("ERR_USER_INFO_COULD_NOT_BE_DELETED", $this->siteLangId) . $userObj->getError(), true);
        }

        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->gdprRequestStatusUpdate($userReqId, $this->siteLangId)) {
            LibHelper::exitWithError($emailNotificationObj->getError(), true);
        }

        $userReqObj = new UserGdprRequest($userReqId);
        $userReqObj->assignValues(['ureq_status' => UserGdprRequest::STATUS_COMPLETE, 'ureq_approved_date' => date('Y-m-d H:i:s')]);
        if (!$userReqObj->save()) {
            LibHelper::exitWithError($userReqObj->getError(), true);
        }
        /* ] */

        $this->set('userReqId', $userReqId);
        $this->set('msg', Labels::getLabel('LBL_Successfully_Deleted_User_data', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'ureq_date');
        }         
        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL', $this->siteLangId), 'user_id', [], '',
                [
                    'class' => 'form-control',
                    'id' => 'searchFrmUserIdJs',
                    'placeholder' => Labels::getLabel('FRM_SELLER_NAME_OR_EMAIL', $this->siteLangId)
                ]
        );
        $requestType = array('-1' => Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId)) + UserGdprRequest::getUserRequestTypesArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_TYPE', $this->siteLangId), 'request_type', $requestType, -1, array(), '');
        $frm->addDateField(Labels::getLabel('FRM_REG._DATE_FROM', $this->siteLangId), 'user_request_from', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_REG._DATE_TO', $this->siteLangId), 'user_request_to', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getFormColumns(): array {
        $shopsTblHeadingCols = CacheHelper::get('gdprRequestTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'user' => Labels::getLabel('LBL_User', $this->siteLangId),
            'ureq_type' => Labels::getLabel('LBL_Request_Type', $this->siteLangId),
            'ureq_date' => Labels::getLabel('LBL_Request_Date', $this->siteLangId),
            'ureq_status' => Labels::getLabel('LBL_Request_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('gdprRequestTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array {
        return [
            'listSerial',
            'user',
            'ureq_date',
            'ureq_type',
            'ureq_status',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['user'], Common::excludeKeysForSort());
    }

}
