<?php

class OrderReturnRequestsController extends ListingBaseController
{

    protected string $pageKey = 'MANAGE_ORDER_RETURN_REQUESTS';

    use ShippingServices;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrderReturnRequests();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['advSearchRowItemCount'] = 3;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_REFERENCE_NUMBER', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'order-return-requests/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function requestSearchObj(): OrderReturnRequestSearch
    {
        $srch = new OrderReturnRequestSearch();
        $srch->joinOrderProducts($this->siteLangId);
        $srch->joinSellerProducts();
        $srch->joinOrderProductSettings();
        $srch->joinShippingCharges();
        $srch->joinOrders();
        $srch->joinOrderBuyerUser();
        $srch->joinOrderSellerUser();
        $srch->joinOrderReturnReasons($this->siteLangId);
        $srch->addOrderProductCharges();
        return $srch;
    }

    private function getFields()
    {
        return [
            'orrequest_id', 'orrequest_op_id', 'orrequest_qty', 'orrequest_type', 'orrequest_returnreason_id',
            'orrequest_date', 'orrequest_status', 'orrequest_reference', 'buyer.user_name as user_name', 'buyer.user_phone_dcode', 'buyer.user_phone', 'buyer_cred.credential_username as credential_username',
            'buyer_cred.credential_email as credential_email', 'seller.user_name as seller_name', 'seller_cred.credential_username as seller_username', 'seller_cred.credential_email as seller_email', 'op_product_name', 'op_selprod_title',
            'op_selprod_options', 'op_brand_name', 'op_shop_name', 'op_qty', 'op_unit_price', 'IFNULL(orreason_title, orreason_identifier) as orreason_title', 'order_tax_charged', 'op_other_charges', 'op_refund_shipping', 'op_refund_amount', 'op_commission_percentage', 'op_affiliate_commission_percentage', 'op_commission_include_shipping', 'op_commission_include_tax', 'op_free_ship_upto', 'op_actual_shipping_charges',
            'order_pmethod_id', 'op_rounding_off', 'selprod_product_id', 'order_user_id', 'op_selprod_user_id', 'op_shop_id', 'op_invoice_number', 'op_selprod_id', 'op_selprod_user_id', 'opshipping_by_seller_user_id', 'buyer.user_updated_on AS user_updated_on', 'seller.user_id AS seller_id', 'buyer.user_id AS user_id', 'seller.user_updated_on AS seller_updated_on', 'orrequest_admin_comment'
        ];
    }

    private function getRequestRow(int $recordId): array
    {
        $srch = $this->requestSearchObj();
        $srch->addMultipleFields($this->getFields());
        $srch->addCondition('orrequest_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return (is_array($row) ? $row : []);
    }

    private function getListingData()
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'orrequest_date');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'orrequest_date';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = $this->requestSearchObj();

        if (isset($post['keyword']) && $post['keyword'] != '') {
            $ref_no = FatUtility::convertToType($post['keyword'], FatUtility::VAR_STRING);
            $srch->addCondition('orrequest_reference', 'like', "%$ref_no%");
        }

        if (isset($postedData['order_user_id']) && $postedData['order_user_id'] != '') {
            $srch->addCondition('o.order_user_id', '=', $postedData['order_user_id']);
        }

        if (isset($postedData['op_selprod_user_id']) && $postedData['op_selprod_user_id'] != '') {
            $srch->addCondition('op.op_selprod_user_id', '=', $postedData['op_selprod_user_id']);
        }

        if (isset($postedData['orrequest_op_id']) && $postedData['orrequest_op_id'] != '') {
            $srch->addCondition('orrequest_op_id', '=', $postedData['orrequest_op_id']);
        }

        if (isset($post['orrequest_status']) && $post['orrequest_status'] != '') {
            $orrequest_status = FatUtility::int($post['orrequest_status']);
            $srch->addCondition('orrequest_status', '=', $orrequest_status);
        }

        if (isset($post['orrequest_type']) && $post['orrequest_type'] != '') {
            $orrequest_type = FatUtility::int($post['orrequest_type']);
            $srch->addCondition('orrequest_type', '=', $orrequest_type);
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        $requestId = FatApp::getPostedData('orrequest_id', FatUtility::VAR_INT, $recordId);
        if (0 < $requestId) {
            $srch->addCondition('orrequest_id', '=', $requestId);
        }

        $dateFrom = FatApp::getPostedData('date_from', null, '');
        if (!empty($dateFrom)) {
            $srch->addDateFromCondition($dateFrom);
        }

        $dateTo = FatApp::getPostedData('date_to', null, '');
        if (!empty($dateTo)) {
            $srch->addDateToCondition($dateTo);
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields($this->getFields());

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditOrderReturnRequests($this->admin_id, true));

        $this->set('requestStatusArr', OrderReturnRequest::getRequestStatusArr($this->siteLangId));
        $this->set('requestTypeArr', OrderReturnRequest::getRequestTypeArr($this->siteLangId));
        $this->set('requestTypeClassArr', OrderReturnRequest::getRequestStatusClass());
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set('canViewShops', $this->objPrivilege->canViewShops($this->admin_id, true));
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'orrequest_date', applicationConstants::SORT_DESC);
        }
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'orrequest_id');

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER_DETAILS', $this->siteLangId), 'order_user_id', []);
        $frm->addSelectBox(Labels::getLabel('FRM_VENDER_DETAILS', $this->siteLangId), 'op_selprod_user_id', []);
        $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'orrequest_op_id', []);
        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_STATUS', $this->siteLangId), 'orrequest_status', OrderReturnRequest::getRequestStatusArr($this->siteLangId), '', array(), Labels::getLabel('FRM_ALL_REQUEST_STATUS', $this->siteLangId));
        $requestType = OrderReturnRequest::getRequestTypeArr($this->siteLangId);
        if (count($requestType) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_TYPE', $this->siteLangId), 'orrequest_type', OrderReturnRequest::getRequestTypeArr($this->siteLangId), '', array(), Labels::getLabel('FRM_ALL_REQUEST_TYPE', $this->siteLangId));
        }
        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function downloadAttachment($recordId, $recordSubid = 0)
    {
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_BUYER_RETURN_PRODUCT, $recordId, $recordSubid);

        if (false == $file_row) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileName = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file_row['afile_name']);
    }

    public function view($recordId)
    {
        $recordId = FatUtility::int($recordId);

        $requestRow = $this->getRequestRow($recordId);
        if (!$requestRow) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl('OrderReturnRequests'));
        }

        $oObj = new Orders();
        $charges = $oObj->getOrderProductChargesArr($requestRow['orrequest_op_id']);
        $requestRow['charges'] = $charges;

        $this->set('order', $requestRow);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $pageSize = 10;
        $srch = $this->getMessageListObj();
        $srch->addCondition('orrmsg_orrequest_id', '=', $recordId);
        $srch->setPageNumber(1);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $messagesList = FatApp::getDb()->fetchAll($rs, 'orrmsg_id');

        $msgsSrchForm = $this->getMessageSearchForm();
        $msgsSrchForm->fill(array('orrequest_id' => $requestRow['orrequest_id']));
        $this->set('msgsSrchForm', $msgsSrchForm);

        $pageData = PageLanguageData::getAttributesByKey('ORDER_RETURN_REQUEST_VIEW', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageTitle', $pageTitle);
        $this->set('pageData', $pageData);
        $this->set('orrequestId', $recordId);

        $this->set('arrListing', $messagesList);
        $this->set('page', 1);
        $this->set('pageSize', $pageSize);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', ['orrequest_id' => $recordId]);
        $this->set('rowsOnly', 0);
        $this->set('canEdit', $this->objPrivilege->canEditOrderReturnRequests($this->admin_id, true));
        $this->_template->render();
    }

    public function getItem(int $recordId)
    {
        $requestRow = $this->getRequestRow($recordId);
        if ($attachedFile = AttachedFile::getAttachment(AttachedFile::FILETYPE_BUYER_RETURN_PRODUCT, $recordId)) {
            $this->set('attachedFile', $attachedFile);
        }

        $oObj = new Orders();
        $charges = $oObj->getOrderProductChargesArr($requestRow['orrequest_op_id']);
        $requestRow['charges'] = $charges;
        $this->set('order', $requestRow);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function addNewComment(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getMessageForm($this->siteLangId);
        $frm->fill(array('orrmsg_orrequest_id' => $recordId));

        $this->set('orrequestId', $recordId);
        $this->set('frm', $frm);
        $this->set('includeTabs', false);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function requestStatusForm(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $requestRow = $this->getRequestRow($recordId);
        $pluginKey = Plugin::getAttributesById($requestRow['order_pmethod_id'], 'plugin_code');

        $paymentMethodObj = new PaymentMethods();
        $canRefundToCard = $paymentMethodObj->canRefundToCard($pluginKey, $this->siteLangId);
        $oldStatus = OrderReturnRequest::getAttributesById($recordId, 'orrequest_status');

        $frm = $this->getUpdateStatusForm($recordId, $this->siteLangId, $canRefundToCard);
        $frm->fill(['orrequest_status' => $oldStatus]);

        $this->set('orrequestId', $recordId);
        $this->set('oldStatus', $oldStatus);
        $this->set('frm', $frm);
        $this->set('includeTabs', false);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function getMessageListObj(): OrderReturnRequestMessageSearch
    {
        $srch = new OrderReturnRequestMessageSearch();
        $srch->joinOrderReturnRequests();
        $srch->joinMessageUser();
        $srch->joinMessageAdmin();
        $srch->addOrder('orrmsg_id', 'DESC');
        $srch->addMultipleFields(
            array(
                'orrmsg_id', 'orrmsg_from_user_id', 'orrmsg_from_admin_id',
                'admin_name', 'admin_username', 'admin_email', 'orrmsg_msg',
                'orrmsg_date', 'msg_user.user_name as msg_user_name', 'msg_user_cred.credential_username as msg_username',
                'msg_user_cred.credential_email as msg_user_email',
                'orrequest_status'
            )
        );
        return $srch;
    }

    public function getRows()
    {
        $frm = $this->getMessageSearchForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = 10;
        $recordId = isset($post['orrequest_id']) ? FatUtility::int($post['orrequest_id']) : 0;

        $srch = $this->getMessageListObj();
        $srch->addCondition('orrmsg_orrequest_id', '=', $recordId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('recordId', $recordId);
        $this->set('postedData', FatApp::getPostedData());

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setupMessage()
    {
        $this->objPrivilege->canEditOrderReturnRequests();
        $orrmsg_orrequest_id = FatApp::getPostedData('orrmsg_orrequest_id', null, '0');

        $frm = $this->getMessageForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $orrmsg_orrequest_id = FatUtility::int($orrmsg_orrequest_id);
        $admin_id = AdminAuthentication::getLoggedAdminId();

        $srch = new OrderReturnRequestSearch($this->siteLangId);
        $srch->addCondition('orrequest_id', '=', $orrmsg_orrequest_id);
        $srch->joinOrderProducts();
        $srch->joinSellerProducts();
        $srch->joinOrderReturnReasons();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields(array('orrequest_id', 'orrequest_status', 'orrequest_user_id'));
        $rs = $srch->getResultSet();
        $requestRow = FatApp::getDb()->fetch($rs);
        if (!$requestRow) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId), true);
        }

        /* save return request message[ */
        $returnRequestMsgDataToSave = array(
            'orrmsg_orrequest_id' => $requestRow['orrequest_id'],
            'orrmsg_from_user_id' => 0,
            'orrmsg_from_admin_id' => $admin_id,
            'orrmsg_msg' => $post['orrmsg_msg'],
            'orrmsg_date' => date('Y-m-d H:i:s'),
        );
        $oReturnRequestMsgObj = new OrderReturnRequestMessage();
        $oReturnRequestMsgObj->assignValues($returnRequestMsgDataToSave);
        if (!$oReturnRequestMsgObj->save()) {
            LibHelper::exitWithError($oReturnRequestMsgObj->getError(), true);
        }
        $orrmsg_id = $oReturnRequestMsgObj->getMainTableRecordId();
        if (!$orrmsg_id) {
            LibHelper::exitWithError(Labels::getLabel('ERR_SOMETHING_WENT_WRONG,_PLEASE_CONTACT_TECHNICAL_TEAM', $this->siteLangId), true);
        }
        /* ] */

        /* sending of email notification[ */
        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendReturnRequestMessageNotification($orrmsg_id, $this->siteLangId)) {
            LibHelper::exitWithError($emailNotificationObj->getError(), true);
        }
        /* ] */


        $this->set('orrmsg_orrequest_id', $orrmsg_orrequest_id);
        $this->set('msg', Labels::getLabel('MSG_MESSAGE_SUBMITTED_SUCCESSFULLY!', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function setupUpdateStatus()
    {
        $this->objPrivilege->canEditOrderReturnRequests();

        $recordId = FatApp::getPostedData('orrequest_id', FatUtility::VAR_INT, 0);
        $frm = $this->getUpdateStatusForm($recordId, $this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false == $post) {
            LibHelper::exitWithError($frm->getValidationErrors(), true);
        }

        $srch = new OrderReturnRequestSearch($this->siteLangId);
        $srch->joinOrderProducts();
        $srch->joinOrders();
        $srch->joinShippingCharges();

        $srch->addCondition('orrequest_id', '=', $recordId);
        /* $cnd = $srch->addCondition('orrequest_status', '=', OrderReturnRequest::RETURN_REQUEST_STATUS_PENDING);
          $cnd->attachCondition('orrequest_status', '=', OrderReturnRequest::RETURN_REQUEST_STATUS_ESCALATED); */
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields(array('orrequest_id', 'op_id', 'orrequest_qty', 'order_language_id', 'orrequest_user_id', 'order_pmethod_id', 'op_selprod_user_id', 'opshipping_by_seller_user_id'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        /* if (!$row) {
          LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_OR_STATUS_IS_ALREADY_APPROVED_OR_DECLINED!', $this->siteLangId), true);
          } */

        $transferTo = isset($post['orrequest_refund_in_wallet']) ? $post['orrequest_refund_in_wallet'] : '';
        $pluginKey = Plugin::getAttributesById($row['order_pmethod_id'], 'plugin_code');

        $paymentMethodObj = new PaymentMethods();
        if (true === $paymentMethodObj->canRefundToCard($pluginKey, $this->siteLangId)) {
            $transferTo = FatApp::getPostedData('orrequest_refund_in_wallet', FatUtility::VAR_INT, 0);
        }

        $orrObj = new OrderReturnRequest();
        $user_id = 0;
        $successMsg = '';
        switch ($post['orrequest_status']) {
            case OrderReturnRequest::RETURN_REQUEST_STATUS_REFUNDED:
                if (!$orrObj->approveRequest($row['orrequest_id'], $user_id, $this->siteLangId, $transferTo, $post['orrequest_admin_comment'])) {
                    LibHelper::exitWithError($orrObj->getError(), true);
                }
                /* Update To Shipping Service */
                $this->langId = $this->siteLangId;

                /*
                $this->loadShippingService($row);
                if (false != $this->shippingService) {
                    $this->returnShipment($row['op_id'], $row['orrequest_qty']);
                }
                */
                /* Update To Shipping Service */

                $successMsg = Labels::getLabel('MSG_RETURN_REQUEST_HAS_BEEN_REFUNDED_SUCCESSFULLY.', $this->siteLangId);
                break;

            case OrderReturnRequest::RETURN_REQUEST_STATUS_WITHDRAWN:
                if (!$orrObj->withdrawRequest($row['orrequest_id'], $user_id, $this->siteLangId, $row['op_id'], $row['order_language_id'])) {
                    LibHelper::exitWithError($orrObj->getError(), true);
                }
                $successMsg = Labels::getLabel('MSG_RETURN_REQUEST_HAS_BEEN_WITHDRAWN_SUCCESSFULLY.', $this->siteLangId);
                break;
        }
        CalculativeDataRecord::updateOrderReturnRequestCount();
        $emailNotificationObj = new EmailHandler();
        if (!$emailNotificationObj->sendOrderReturnRequestStatusChangeNotification($row['orrequest_id'], $this->siteLangId)) {
            LibHelper::exitWithError($emailNotificationObj->getError(), true);
        }

        //send notification to admin
        $notificationData = array(
            'notification_record_type' => Notification::TYPE_ORDER_RETURN_REQUEST,
            'notification_record_id' => $row['orrequest_id'],
            'notification_user_id' => $row['orrequest_user_id'],
            'notification_label_key' => Notification::RETURN_REQUEST_STATUS_CHANGE_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s'),
        );
        if (!Notification::saveNotifications($notificationData)) {
            LibHelper::exitWithError(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId), true);
        }

        FatUtility::dieJsonSuccess($successMsg);
    }

    private function getMessageSearchForm()
    {
        $frm = new Form('frmMsgsSrch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'orrequest_id');
        $frm->addHiddenField('', 'reference');
        return $frm;
    }

    private function getMessageForm($langId)
    {
        $frm = new Form('frmOrderReturnRequestMessge');
        $frm->addHiddenField('', 'orrmsg_orrequest_id');

        $fld = $frm->addTextArea(Labels::getLabel('FRM_COMMENT', $this->siteLangId), 'orrmsg_msg');
        $fld->requirements()->setRequired();
        $fld->requirements()->setCustomErrorMessage(Labels::getLabel('MSG_MESSAGE_IS_MANDATORY', $langId));
        return $frm;
    }

    private function getUpdateStatusForm($recordId, $langId, $canRefundToCard = false)
    {
        $frm = new Form('frmUpdateStatus');
        $frm->addHiddenField('', 'orrequest_id', $recordId);

        $statusArr = OrderReturnRequest::getRequestStatusArr($langId);
        unset($statusArr[OrderReturnRequest::RETURN_REQUEST_STATUS_ESCALATED]);
        unset($statusArr[OrderReturnRequest::RETURN_REQUEST_STATUS_CANCELLED]);
        $statusFld = $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'orrequest_status', $statusArr, '', ['class' => 'fieldsVisibilityJs']);
        $statusFld->requirements()->setRequired(true);

        $moveRefundLocationArr = PaymentMethods::moveRefundLocationsArr($this->siteLangId);
        if (false == $canRefundToCard) {
            unset($moveRefundLocationArr[PaymentMethods::MOVE_TO_CUSTOMER_CARD]);
        } else {
            unset($moveRefundLocationArr[PaymentMethods::MOVE_TO_CUSTOMER_WALLET]);
        }

        $frm->addRadioButtons(Labels::getLabel('FRM_TRANSFER_REFUND', $this->siteLangId), 'orrequest_refund_in_wallet', $moveRefundLocationArr, PaymentMethods::MOVE_TO_ADMIN_WALLET, array('class' => 'list-radio'));
        $fld1 = new FormFieldRequirement('orrequest_refund_in_wallet', Labels::getLabel('FRM_TRANSFER_REFUND', $langId));
        $fld1->setRequired(false);
        $reqFld1 = new FormFieldRequirement('orrequest_refund_in_wallet', Labels::getLabel('FRM_TRANSFER_REFUND', $langId));
        $reqFld1->setRequired(true);

        $fld = $frm->addTextarea(Labels::getLabel('FRM_COMMENT', $this->siteLangId), 'orrequest_admin_comment');
        $fld->requirements()->setRequired(true);
        $fld2 = new FormFieldRequirement('orrequest_admin_comment', Labels::getLabel('FRM_COMMENT', $langId));
        $fld2->setRequired(false);
        $reqFld2 = new FormFieldRequirement('orrequest_admin_comment', Labels::getLabel('FRM_COMMENT', $langId));
        $reqFld2->setRequired(true);

        $statusFld->requirements()->addOnChangerequirementUpdate(OrderReturnRequest::RETURN_REQUEST_STATUS_REFUNDED, 'eq', 'orrequest_refund_in_wallet', $reqFld1);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderReturnRequest::RETURN_REQUEST_STATUS_PENDING, 'eq', 'orrequest_refund_in_wallet', $fld1);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderReturnRequest::RETURN_REQUEST_STATUS_WITHDRAWN, 'eq', 'orrequest_refund_in_wallet', $fld1);

        $statusFld->requirements()->addOnChangerequirementUpdate(OrderReturnRequest::RETURN_REQUEST_STATUS_REFUNDED, 'eq', 'orrequest_admin_comment', $reqFld2);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderReturnRequest::RETURN_REQUEST_STATUS_PENDING, 'eq', 'orrequest_admin_comment', $fld2);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderReturnRequest::RETURN_REQUEST_STATUS_WITHDRAWN, 'eq', 'orrequest_admin_comment', $fld2);

        return $frm;
    }

    public function viewAdminComment($orrequestId)
    {
        $orrequestId = FatUtility::int($orrequestId);
        $this->set('comment', OrderReturnRequest::getAttributesById($orrequestId, 'orrequest_admin_comment'));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('orderRetReqTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'orrequest_reference' => Labels::getLabel('LBL_Refernce_No.', $this->siteLangId),
            'product' => Labels::getLabel('LBL_Product', $this->siteLangId),
            'buyer_detail' => Labels::getLabel('LBL_BUYER', $this->siteLangId),
            'vendor_detail' => Labels::getLabel('LBL_SELLER', $this->siteLangId),
            'orrequest_qty' => Labels::getLabel('LBL_Qty', $this->siteLangId),
            'orrequest_date' => Labels::getLabel('LBL_Date', $this->siteLangId),
            'orrequest_status' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        CacheHelper::create('orderRetReqTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'orrequest_reference',
            'product',
            'buyer_detail',
            'vendor_detail',
            'orrequest_qty',
            'orrequest_date',
            'orrequest_status',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['buyer_detail', 'vendor_detail', 'product'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'view':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? Labels::getLabel('LBL_ORDER_RETURN_REQUESTS', $this->siteLangId);
                $this->nodes = [
                    ['title' => $pageTitle, 'href' => UrlHelper::generateUrl('OrderReturnRequests')],
                ];

                $url = FatApp::getQueryStringData('url');
                $urlParts = explode('/', $url);
                $title = Labels::getLabel('LBL_VIEW', $this->siteLangId);
                if (isset($urlParts[2])) {
                    $referenceNo = OrderReturnRequest::getAttributesById($urlParts[2], 'orrequest_reference');
                    if (!empty($referenceNo)) {
                        $this->nodes[] = ['title' => $referenceNo];
                    }
                }
                $this->nodes[] = ['title' => $title];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
