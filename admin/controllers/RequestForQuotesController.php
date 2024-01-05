<?php
class RequestForQuotesController extends ListingBaseController
{
    protected string $modelClass = 'RequestForQuote';
    protected $pageKey = 'MANAGE_REQUEST_FOR_QUOTE';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewRequestForQuote();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditRequestForQuote($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditRequestForQuote();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['newRecordBtn'] = false;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE_OR_RFQ_NUMBER', $this->siteLangId));
        $this->set('autoTableColumWidth', false);
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'request-for-quotes/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $this->checkEditPrivilege(true);

        $fields = $this->getFormColumns();
        $this->setCustomColumnWidth();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'rfq_added_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'rfq_added_on';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getAdminPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new RequestForQuoteSearch();
        $srch->joinBuyer();
        $dbFlds = array_merge(RequestForQuote::FIELDS, ['buc.credential_username as credential_username', 'bu.user_id as user_id', 'bu.user_updated_on', 'credential_email', 'bu.user_name', '0 as totalOffers', '0 as rejectedOffers', '0 as acceptedOffers']);
        $srch->addMultipleFields($dbFlds);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cond = $srch->addCondition('rfq_title', 'like', '%' . $keyword . '%');
            $cond->attachCondition('rfq_number', 'like', '%' . $keyword . '%');
        }

        $userId = FatApp::getPostedData('rfq_user_id', FatUtility::VAR_INT, 0);
        if (0 < $userId) {
            $srch->addCondition('rfq_user_id', '=', $userId);
        }

        $sellerId = FatApp::getPostedData('rfq_seller_id', FatUtility::VAR_INT, 0);
        if (0 < $sellerId) {
            $srch->joinSellers('INNER', $sellerId);
            $srch->addCondition('rfqts_user_id', '=', $sellerId);
        }

        $approved = $post['rfq_approved'] ?? -1;
        if (-1 < $approved) {
            $srch->addCondition('rfq_approved', '=', $approved);
        }
        $status = $post['rfq_status'] ?? -1;
        if (-1 < $status) {
            $srch->addCondition('rfq_status', '=', $status);
        }
        $srch->addCondition('rfq_deleted', '=', applicationConstants::NO);

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);

        $srch->addOrder($sortBy, $sortOrder);
        $srch->addGroupBy('rfq_id');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $arrListing = FatApp::getDb()->fetchAll($srch->getDataResultSet(), 'rfq_id');
        if (!empty($arrListing)) {
            $rfqIds = array_keys($arrListing);
            $srch = new SearchBase(RfqOffers::DB_RFQ_LATEST_OFFER, 'rlo');
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addCondition('rlo_rfq_id', 'IN', $rfqIds);
            $srch->addCondition('rlo_deleted', '=', applicationConstants::NO);
            $srch->addGroupBy('rlo_rfq_id');
            $srch->addMultipleFields(['rlo_rfq_id', 'rlo_status', 'COUNT(rlo_rfq_id) as totalOffers', 'SUM(IF(rlo_status =' . RfqOffers::STATUS_REJECTED . ',1,0)) as rejectedOffers', 'SUM(IF(rlo_status =' . RfqOffers::STATUS_ACCEPTED . ',1,0)) as acceptedOffers']);
            $arr = FatApp::getDb()->fetchAll($srch->getResultSet(), 'rlo_rfq_id');
            foreach ($arr as $key => $rfqVal) {
                $arrListing[$key]['totalOffers'] = $rfqVal['totalOffers'];
                $arrListing[$key]['acceptedOffers'] = $rfqVal['acceptedOffers'];
                $arrListing[$key]['rejectedOffers'] = $rfqVal['rejectedOffers'];
            }
        }

        $this->set("arrListing", $arrListing);
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set("approvalStatusArr", RequestForQuote::getApprovalStatusArr($this->siteLangId));
        $this->set("statusArr", RequestForQuote::getStatusArr($this->siteLangId));
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
    }

    public function view(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = new RequestForQuoteSearch();
        $srch->joinBuyer();
        $srch->joinBuyerAddress($this->siteLangId);
        $srch->joinCountry(true);
        $srch->joinState(true);

        $dbFlds = array_merge(RequestForQuote::FIELDS, ['addr_name', 'addr_address1', 'addr_address2', 'addr_city', 'state_name', 'country_name', 'addr_zip', 'addr_phone_dcode', 'addr_phone', 'buc.credential_username as credential_username', 'bu.user_id as user_id', 'bu.user_updated_on', 'credential_email', 'bu.user_name', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name']);
        $srch->addMultipleFields($dbFlds);

        $srch->addCondition('rfq_id', '=', $recordId);
        $this->set("rfqData", FatApp::getDb()->fetch($srch->getDataResultSet()));
        $this->set("approvalStatusArr", RequestForQuote::getApprovalStatusArr($this->siteLangId));
        $this->set("statusArr", RequestForQuote::getStatusArr($this->siteLangId));
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set('recordId', $recordId);

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm(): Form
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'rfq_id');

        $approvalStatusArr = RequestForQuote::getApprovalStatusArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL', $this->siteLangId), 'rfq_approved', $approvalStatusArr, '', [], '');
        $fld->requirement->setRequired(true);
        return $frm;
    }

    public function form()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();
        $data = RequestForQuote::getAttributesById($recordId, ['rfq_id', 'rfq_approved', 'rfq_status']);
        $frm->fill($data);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_REQUEST_FOR_QUOTE_FORM', $this->siteLangId));
        $this->set('callback', 'closeForm');

        $this->set('html', $this->_template->render(false, false, '_partial/listing/form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatApp::getPostedData('rfq_id', FatUtility::VAR_INT, 0);

        $rfq = new RequestForQuote($recordId);
        if (false == $rfq->add($post)) {
            LibHelper::exitWithError($rfq->getError(), true);
        }

        CalculativeDataRecord::updateRfqCount();

        $attr = [
            'rfq_title', 'rfq_number', 'rfq_approved', 'rfq_user_id', 'rfq_quantity', 'rfq_quantity_unit', 'rfq_delivery_date', 'rfq_description', 'rfq_added_on', 'ba.*', 'selprod_id', 'selprod_title', 'selprod_user_id', 'selprod_product_id', 'selprod_updated_on', 'shop_name', 'bu.user_name', 'buc.credential_username', 'buc.credential_email', 'bu.user_phone_dcode', 'bu.user_phone', 'rfqts_user_id as seller_id', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name'
        ];
        $rfqData = $rfq->get($this->siteLangId, $attr);
        if (empty($rfqData)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST'), true);
        }

        $approval = FatApp::getPostedData('rfq_approved', FatUtility::VAR_INT, 0);
        if (in_array($approval, [RequestForQuote::APPROVED, RequestForQuote::REJECTED])) {
            $emailHandler = new EmailHandler();
            if (false === $emailHandler->sendApprovalStatusRfqNotification($this->siteLangId, $rfqData)) {
                $msg = $emailHandler->getError();
                $msg = empty($msg) ? Labels::getLabel('ERR_UNABLE_TO_NOTIFY._NOTIFICATION_LOGGED_TO_THE_SYSTEM.') : $msg;
                LibHelper::exitWithError($msg, true);
            }
        }

        $this->set('record_id', $rfq->getMainTableRecordId());
        $this->set('msg', Labels::getLabel('MGS_UPDATED_SUCCESSFULLY.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getAssignSellerForm(): Form
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'rfq_id');
        $frm->addHiddenField('', 'rfq_product_id');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELLER'), 'rfqts_user_id', []);
        $fld->requirement->setRequired(true);
        return $frm;
    }

    private function getShopUser($userId): array
    {
        if (empty($userId)) {
            return '';
        }
        $userIds = is_array($userId) ? $userId : [$userId];
        $srch = Shop::getSearchObject(true, $this->siteLangId);
        $srch->addCondition(Shop::tblFld('user_id'), 'IN', $userIds, 'AND', true);
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'su.user_id = s.shop_user_id', 'su');
        $srch->addMultipleFields(['shop_user_id', 'CONCAT(user_name, " (", COALESCE(s_l.shop_name, s.shop_identifier), ")") as shopuser']);
        return (array)FatApp::getDb()->fetchAllAssoc($srch->getResultSet(), Shop::tblFld('user_id'));
    }

    public function assignSellerForm(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $rfqData = RequestForQuote::getAttributesById($recordId, ['rfq_id', 'rfq_product_id']);
        if (!$rfqData) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $sellerData = RequestForQuote::getSellersByRecordId($recordId);
        $selectedSellers = [];
        if (!empty($sellerData)) {
            $sellerIds = array_column($sellerData, 'rfqts_user_id');
            $selectedSellers = $this->getShopUser($sellerIds);
        }

        $frm = $this->getAssignSellerForm();
        $frm->fill($rfqData);
        $this->set('frm', $frm);
        $this->set('selectedSellers', $selectedSellers);
        $this->set('recordId', $recordId);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_ASSIGN_SELLER', $this->siteLangId));
        $this->set('callback', 'closeForm');
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function assignSeller()
    {
        $this->checkEditPrivilege();

        $frm = $this->getAssignSellerForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatApp::getPostedData('rfq_id', FatUtility::VAR_INT, 0);
        $sellerId = FatApp::getPostedData('rfqts_user_id', FatUtility::VAR_INT, 0);
        if (1 > $recordId || 1 > $sellerId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $rfqData = RequestForQuote::getAttributesById($recordId, ['rfq_approved']);

        if (false == $rfqData || $rfqData['rfq_approved'] != RequestForQuote::APPROVED) {
            LibHelper::exitWithError(Labels::getLabel('ERR_RFQ_STATUS_IS_NOT_APPROVED'), true);
        }

        /* RVSI */
        $selProdId = 0;
        /* $selProdId = RequestForQuote::getSellerProductId($recordId, $sellerId);
        if (1 > $selProdId) {
            LibHelper::exitWithError(Labels::getLabel('LBL_SELLER_INVENTORY_NOT_FOUND_OF_THIS_SELLER.'), true);
        } */

        $db = FatApp::getDb();
        $db->startTransaction();
        $rfq = new RequestForQuote($recordId);
        $data = [
            'rfqts_user_id' => $sellerId,
        ];
        if (false == $rfq->linkToSeller($data)) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($rfq->getError(), true);
        }

        $db->commitTransaction();
        $this->set('record_id', $rfq->getMainTableRecordId());
        $this->set('msg', Labels::getLabel('MGS_ASSIGNED_SUCCESSFULLY.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'rfq_added_on', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER', $this->siteLangId), 'rfq_user_id', []);
        $frm->addSelectBox(Labels::getLabel('FRM_SELLER', $this->siteLangId), 'rfq_seller_id', []);

        $approvalArr = RequestForQuote::getApprovalStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL', $this->siteLangId), 'rfq_approved', $approvalArr);

        $statusArr = RequestForQuote::getStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'rfq_status', $statusArr);

        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function updateStatus()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);

        if (1 > $recordId || 0 > $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!RequestForQuote::getAttributesById($recordId, 'rfq_id')) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->changeStatus($recordId, $status);
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->checkEditPrivilege();

        $recordIdsArr = FatUtility::int(FatApp::getPostedData('rfq_ids'));
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (false === RequestForQuote::getAttributesById($recordId, 'rfq_id')) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->checkEditPrivilege();

        $recordIdsArr = FatUtility::int(FatApp::getPostedData('rfq_ids'));
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

    protected function markAsDeleted(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $rfq = new RequestForQuote($recordId);
        if (!$rfq->delete()) {
            LibHelper::exitWithError($rfq->getError(), true);
        }
        CalculativeDataRecord::updateRfqCount();
        $attr = [
            'rfq_title', 'rfq_number', 'rfq_approved', 'rfq_user_id', 'rfq_quantity', 'rfq_quantity_unit', 'rfq_delivery_date', 'rfq_description', 'rfq_added_on', 'ba.*', 'selprod_id', 'selprod_title', 'selprod_user_id', 'selprod_product_id', 'selprod_updated_on', 'shop_name', 'bu.user_name', 'buc.credential_username', 'buc.credential_email', 'bu.user_phone_dcode', 'bu.user_phone', 'rfqts_user_id as seller_id', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name'
        ];
        $rfqData = $rfq->get($this->siteLangId, $attr);
        if (!empty($rfqData)) {
            $emailHandler = new EmailHandler();
            if (false === $emailHandler->sendDeletionRfqNotification($this->siteLangId, $rfqData)) {
                $msg = $emailHandler->getError();
                $msg = empty($msg) ? Labels::getLabel('ERR_RECORD_DELTED_BUT_UNABLE_TO_NOTIFY._NOTIFICATION_LOGGED_TO_THE_SYSTEM.') : $msg;
                LibHelper::exitWithError($msg, true);
            }
        }
    }

    public function downloadFile(int $recordId)
    {
        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_RFQ, $recordId);
        if ($res == false || 1 > $res['afile_id']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NOT_AVAILABLE_TO_DOWNLOAD', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('RequestForQuotes'));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $res['afile_physical_path'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_FILE_NOT_FOUND', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('RequestForQuotes'));
        }

        AttachedFile::downloadAttachment($res['afile_physical_path'], $res['afile_name']);
    }

    public function getSellersByProductId()
    {
        $json = RequestForQuote::getSellersByProductId($this->siteLangId);
        die(FatUtility::convertToJson($json));
    }

    /**
     * setCustomColumnWidth
     *
     * @return void
     */
    protected function setCustomColumnWidth(): void
    {
        $arr = [
            'select_all' => [
                'width' => '5%'
            ],
            'listSerial' => [
                'width' => '5%'
            ],
            'credential_username' => [
                'width' => '50%'
            ],
            'rejectedOffers' => [
                'width' => '5%'
            ],
            'acceptedOffers' => [
                'width' => '5%'
            ],
            'rfq_approved' => [
                'width' => '20%'
            ],
            'rfq_added_on' => [
                'width' => '10%'
            ],
            'action' => [
                'width' => '10%'
            ],
        ];
        $this->set('tableHeadAttrArr', $arr);
    }

    /**
     * getFormColumns
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('requestForQuotesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'credential_username' => Labels::getLabel('LBL_REQUEST_INFO', $this->siteLangId),
            // 'rfq_title' => Labels::getLabel('LBL_REQUEST_INFO', $this->siteLangId),
            /*  'totalOffers' => Labels::getLabel('LBL_TOTAL_OFFERS', $this->siteLangId), */
            'acceptedOffers' => Labels::getLabel('LBL_ACCEPTED', $this->siteLangId),
            'rejectedOffers' => Labels::getLabel('LBL_REJECTED', $this->siteLangId),
            /*  'rfq_type' => Labels::getLabel('LBL_TYPE', $this->siteLangId), */
            // 'rfq_quantity' => Labels::getLabel('LBL_REQUESTED_QTY', $this->siteLangId),
            // 'rfq_delivery_date' => Labels::getLabel('LBL_EXPECTED_DELIVERY_DATE', $this->siteLangId),
            // 'rfq_status' => Labels::getLabel('LBL_OFFERS', $this->siteLangId),
            'rfq_approved' => Labels::getLabel('LBL_APPROVAL', $this->siteLangId),
            'rfq_added_on' => Labels::getLabel('LBL_REQUESTED_ON', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('requestForQuotesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * getDefaultColumns
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return array_keys($this->getFormColumns());
    }

    /**
     * excludeKeysForSort
     *
     * @param  mixed $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['rfq_user_id', 'rfq_type', 'credential_username', 'rfq_quantity', 'rfq_quantity_unit', 'rfq_type', 'rfq_type', 'rfq_status'], Common::excludeKeysForSort());
    }
}
