<?php
class OrderCancellationRequestsController extends ListingBaseController
{
    protected $modelClass = 'OrderCancelRequest';
    protected $pageKey = 'ORDER_CANCELLATION_REQUESTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrderCancellationRequests();
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
            $this->set("canEdit", $this->objPrivilege->canEditOrderCancellationRequests($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditOrderCancellationRequests();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['newRecordBtn'] = false;
        $this->set('actionItemsData', $actionItemsData);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_INVOICE_NUMBER_AND_COMMENT', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/select2.js', 'order-cancellation-requests/page-js/index.js']);
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'ocrequest_date', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_STATUS', $this->siteLangId), 'ocrequest_status', OrderCancelRequest::getRequestStatusArr($this->siteLangId), '', [], Labels::getLabel('FRM_ALL', $this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_ORDER_PAYMENT_STATUS', $this->siteLangId), 'op_status_id', Orders::getOrderProductStatusArr($this->siteLangId), '', array(), Labels::getLabel('FRM_ALL_ORDER_PAYMENT_STATUS', $this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_CANCEL_REASON', $this->siteLangId), 'ocrequest_ocreason_id', OrderCancelReason::getOrderCancelReasonArr($this->siteLangId), '', array(), Labels::getLabel('FRM_ALL_ORDER_CANCEL_REASON', $this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER_DETAILS', $this->siteLangId), 'buyer', [], '', ['id' => 'buyerJs', 'placeholder' => Labels::getLabel('LBL_SEARCH', $this->siteLangId)]);
        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_DETAILS', $this->siteLangId), 'seller', [], '', ['id' => 'sellerJs', 'placeholder' => Labels::getLabel('LBL_SEARCH', $this->siteLangId)]);

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));

        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'ocrequest_id', 0);
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'order-cancellation-requests/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $seller = FatApp::getPostedData('seller', FatUtility::VAR_INT, 0);

        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'ocrequest_date');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'ocrequest_date';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data);

        $srch = new OrderCancelRequestSearch($this->siteLangId);
        $srch->joinOrderProducts();
        $srch->joinSellerProducts();
        $srch->joinOrders();
        $srch->joinOrderBuyerUser();
        if (0 <  $seller) {
            $srch->joinOrderSellerUser();
        }
        $srch->joinOrderProductStatus($this->siteLangId);
        $srch->joinOrderCancelReasons();
        $srch->addOrderProductCharges();

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('op_invoice_number', '=', $keyword);
            $cnd->attachCondition('op_order_id', '=', $keyword);
            $cnd->attachCondition('ocrequest_message', 'LIKE', "%" . $keyword . "%");
        }

        if (isset($post['ocrequest_status']) && $post['ocrequest_status'] != '') {
            $ocrequest_status = FatUtility::int($post['ocrequest_status']);
            $srch->addCondition('ocrequest_status', '=', $ocrequest_status);
        }

        if (isset($post['op_status_id']) && $post['op_status_id'] != '') {
            $op_status_id = FatUtility::int($post['op_status_id']);
            $srch->addCondition('op_status_id', '=', $op_status_id);
        }

        $reasonId = FatApp::getPostedData('ocrequest_ocreason_id', FatUtility::VAR_INT, 0);
        if (0 < $reasonId) {
            $srch->addCondition('ocrequest_ocreason_id', '=', $reasonId);
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        $reasonId = FatApp::getPostedData('ocrequest_id', FatUtility::VAR_INT, $recordId);
        if (0 < $reasonId) {
            $srch->addCondition('ocrequest_id', '=', $reasonId);
        }

        $buyer = FatApp::getPostedData('buyer', FatUtility::VAR_INT, 0);
        if (0 < $buyer) {
            $srch->addCondition('buyer.user_id', '=', $buyer);
        }

        if (0 < $seller) {
            $srch->addCondition('seller.user_id', '=', $seller);
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
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $srch->addMultipleFields(
            array(
                'ocrequest_id', 'ocrequest_message', 'ocrequest_date', 'ocrequest_status',
                'buyer.user_name as user_name', 'buyer_cred.credential_username as credential_username', 'buyer_cred.credential_email as credential_email', 'op_invoice_number', 'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name',
                'IFNULL(ocreason_title, ocreason_identifier) as ocreason_title', 'op_qty', 'op_unit_price',
                'order_tax_charged', 'op_other_charges', 'op_rounding_off', 'op_id', 'buyer.user_id AS user_id',
                'buyer.user_updated_on AS user_updated_on', 'op_shop_id', 'op_shop_name', 'op_selprod_id',
                'op_product_name', 'op_selprod_title', 'op_brand_name', 'selprod_product_id', 'ocrequest_admin_comment', 'order_payment_status', 'order_pmethod_id', 'orderstatus_color_class'
            )
        );
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('requestStatusArr', OrderCancelRequest::getRequestStatusArr($this->siteLangId));
        $this->set('statusClassArr', OrderCancelRequest::getStatusClassArr());
        $this->set('orderStatusArr', Orders::getOrderStatusArr($this->siteLangId));
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set("arrListing", $records);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set('canViewShops', $this->objPrivilege->canViewShops($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $srch = new OrderCancelRequestSearch();
        $srch->joinOrderProducts();
        $srch->joinOrders();
        $srch->addCondition('ocrequest_id', '=', $recordId);
        $srch->joinOrderProductChargesByType(OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields(array('order_reward_point_used', 'order_pmethod_id', 'opcharge_amount', 'order_reward_point_value'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (1 > $recordId || !$row) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $orderRewardUsed = 0;
        if (!empty($row) && $row['order_reward_point_used'] > 0) {
            //$orderRewardUsed = $row['order_reward_point_used'];
            $orderRewardUsed = -1 * ($row['order_reward_point_used'] / $row['order_reward_point_value']) * $row['opcharge_amount'];
        }

        $canRefundToCard = false;
        $pluginKey = Plugin::getAttributesById($row['order_pmethod_id'], 'plugin_code');
        $paymentMethodObj = new PaymentMethods();
        if (true === $paymentMethodObj->canRefundToCard($pluginKey, $this->siteLangId)) {
            $canRefundToCard = true;
        }
        $frm = $this->getForm($recordId, $this->siteLangId, $canRefundToCard);

        // $fld->setFieldTagAttribute('id', 'buyerJs');

        $this->set('orderRewardUsed', $orderRewardUsed);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('includeTabs', false);
        $this->set('displayLangTab', false);
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_CANCELLATION_REQUEST_UPDATE', $this->siteLangId));

        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($recordId, $langId, $canRefundToCard = false)
    {
        $frm = new Form('frmUpdateStatus');
        $frm->addHiddenField('', 'ocrequest_id', $recordId);
        $statusFld = $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'ocrequest_status', OrderCancelRequest::getRequestStatusArr($langId), '', ['class' => 'fieldsVisibilityJs'], '');
        $statusFld->requirement->setRequired(true);

        $moveRefundLocationArr = PaymentMethods::moveRefundLocationsArr($this->siteLangId);
        if (false == $canRefundToCard) {
            unset($moveRefundLocationArr[PaymentMethods::MOVE_TO_CUSTOMER_CARD]);
        } else {
            unset($moveRefundLocationArr[PaymentMethods::MOVE_TO_CUSTOMER_WALLET]);
        }
        $frm->addRadioButtons(Labels::getLabel('FRM_TRANSFER_REFUND', $this->siteLangId), 'ocrequest_refund_in_wallet', $moveRefundLocationArr, PaymentMethods::MOVE_TO_ADMIN_WALLET, array('class' => 'list-radio'));
        $fld1 = new FormFieldRequirement('ocrequest_refund_in_wallet', Labels::getLabel('FRM_TRANSFER_REFUND', $langId));
        $fld1->setRequired(false);
        $reqFld1 = new FormFieldRequirement('ocrequest_refund_in_wallet', Labels::getLabel('FRM_TRANSFER_REFUND', $langId));
        $reqFld1->setRequired(true);

        $fld = $frm->addTextarea(Labels::getLabel('FRM_COMMENT', $this->siteLangId), 'ocrequest_admin_comment');
        $fld->requirement->setRequired(true);
        $fld2 = new FormFieldRequirement('ocrequest_admin_comment', Labels::getLabel('FRM_COMMENT', $langId));
        $fld2->setRequired(false);
        $reqFld2 = new FormFieldRequirement('ocrequest_admin_comment', Labels::getLabel('FRM_COMMENT', $langId));
        $reqFld2->setRequired(true);

        $statusFld->requirements()->addOnChangerequirementUpdate(OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED, 'eq', 'ocrequest_refund_in_wallet', $reqFld1);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING, 'eq', 'ocrequest_refund_in_wallet', $fld1);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderCancelRequest::CANCELLATION_REQUEST_STATUS_DECLINED, 'eq', 'ocrequest_refund_in_wallet', $fld1);

        $statusFld->requirements()->addOnChangerequirementUpdate(OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED, 'eq', 'ocrequest_admin_comment', $reqFld2);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING, 'eq', 'ocrequest_admin_comment', $fld2);
        $statusFld->requirements()->addOnChangerequirementUpdate(OrderCancelRequest::CANCELLATION_REQUEST_STATUS_DECLINED, 'eq', 'ocrequest_admin_comment', $fld2);

        return $frm;
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('ocrequest_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId, $this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false == $post) {
            LibHelper::exitWithError($frm->getValidationErrors(), true);
        }
        $postStatus = FatApp::getPostedData('ocrequest_status', FatUtility::VAR_INT, 0);

        $srch = new OrderCancelRequestSearch($this->siteLangId);
        $srch->joinOrderProducts();
        $srch->joinOrders();
        $srch->addCondition('ocrequest_id', '=', $recordId);
        $srch->addCondition('ocrequest_status', '=', OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields(array('op_id', 'ocrequest_id', 'ocrequest_status', 'ocrequest_op_id', 'o.order_language_id', 'op_status_id', 'order_pmethod_id', 'op_selprod_id', 'op_order_id'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!$row) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_OR_STATUS_IS_ALREADY_APPROVED_OR_DECLINED', $this->siteLangId));
        }

        if ($postStatus == $row['ocrequest_status']) {
            $str = Labels::getLabel('MSG_ALREADY_PENDING', $this->siteLangId);
            if ($postStatus == OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED) {
                $str = Labels::getLabel('MSG_ALREADY_APPROVED', $this->siteLangId);
            } else if ($postStatus == OrderCancelRequest::CANCELLATION_REQUEST_STATUS_DECLINED) {
                $str = Labels::getLabel('MSG_ALREADY_DECLINED', $this->siteLangId);
            }
            LibHelper::exitWithError($str);
        }

        $db = FatApp::getDb();
        $db->startTransaction();

        $msgString = Labels::getLabel('MSG_CANCELLATION_REQUEST_HAS_BEEN_{updatedStatus}_SUCCESSFULLY.', $this->siteLangId);
        switch ($post['ocrequest_status']) {
            case OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED:
                $notAllowedStatusChangeArr = array_merge(
                    unserialize(FatApp::getConfig("CONF_PROCESSING_ORDER_STATUS")),
                    unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")),
                    (array) FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS")
                );
                $notAllowedStatusChangeArr = array_diff($notAllowedStatusChangeArr, (array) FatApp::getConfig("CONF_DEFAULT_INPROCESS_ORDER_STATUS"));
                $status = Orders::getOrderStatusArr($this->siteLangId);
                if (in_array($row['op_status_id'], $notAllowedStatusChangeArr)) {
                    $errMsg = Labels::getLabel(str_replace('{currentStatus}', $status[$row['op_status_id']], 'MSG_THIS_ORDER_IS_{currentStatus}_NOW,_SO_NOT_ELIGIBLE_FOR_CANCELLATION'), $this->siteLangId);
                    LibHelper::exitWithError($errMsg, true);
                }

                $transferTo = FatApp::getPostedData('ocrequest_refund_in_wallet', FatUtility::VAR_INT, 0);
                $dataToUpdate = array('ocrequest_status' => OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED, 'ocrequest_refund_in_wallet' => $transferTo, 'ocrequest_admin_comment' => $post['ocrequest_admin_comment']);
                $successMsgString = str_replace(strToLower('{updatedStatus}'), OrderCancelRequest::getRequestStatusArr($this->siteLangId)[OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED], $msgString);
                $oObj = new Orders();
                if (true == $oObj->addChildProductOrderHistory($row['ocrequest_op_id'], $row['order_language_id'], FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS"), Labels::getLabel('MSG_CANCELLATION_REQUEST_APPROVED', $row['order_language_id']), true, '', 0, $transferTo)) {
                    if ((PaymentMethods::MOVE_TO_CUSTOMER_CARD == $transferTo)) {
                        $pluginKey = Plugin::getAttributesById($row['order_pmethod_id'], 'plugin_code');

                        $paymentMethodObj = new PaymentMethods();
                        if (true === $paymentMethodObj->canRefundToCard($pluginKey, $row['order_language_id'])) {
                            if (false == $paymentMethodObj->initiateRefund($row, PaymentMethods::REFUND_TYPE_CANCEL)) {
                                $db->rollbackTransaction();
                                LibHelper::exitWithError($paymentMethodObj->getError(), true);
                            }
                            $resp = $paymentMethodObj->getResponse();
                            if (empty($resp)) {
                                $db->rollbackTransaction();
                                LibHelper::exitWithError(Labels::getLabel('LBL_UNABLE_TO_PLACE_GATEWAY_REFUND_REQUEST', $row['order_language_id']), true);
                            }
                            $dataToUpdate['ocrequest_payment_gateway_req_id'] = $resp->id ?? 0;

                            // Debit from wallet if plugin/payment method support's direct payment to card.
                            if (!empty($resp->id)) {
                                $childOrderInfo = $oObj->getOrderProductsByOpId($row['ocrequest_op_id'], $this->siteLangId);
                                $txnAmount = $paymentMethodObj->getTxnAmount();
                                $comments = Labels::getLabel('LBL_TRANSFERED_TO_YOUR_CARD._INVOICE_#{invoice-no}', $this->siteLangId);
                                $comments = CommonHelper::replaceStringData($comments, ['{invoice-no}' => $childOrderInfo['op_invoice_number']]);
                                Transactions::debitWallet($childOrderInfo['order_user_id'], Transactions::TYPE_ORDER_REFUND, $txnAmount, $this->siteLangId, $comments, $row['ocrequest_op_id'], $resp->id);
                            }
                        }
                    }
                }
                break;
            case OrderCancelRequest::CANCELLATION_REQUEST_STATUS_DECLINED:
                $successMsgString = str_replace(strToLower('{updatedStatus}'), OrderCancelRequest::getRequestStatusArr($this->siteLangId)[OrderCancelRequest::CANCELLATION_REQUEST_STATUS_DECLINED], $msgString);
                $dataToUpdate = array('ocrequest_status' => OrderCancelRequest::CANCELLATION_REQUEST_STATUS_DECLINED);
                break;
            case OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING:
                $successMsgString = str_replace(strToLower('{updatedStatus}'), OrderCancelRequest::getRequestStatusArr($this->siteLangId)[OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING], $msgString);
                $dataToUpdate = array('ocrequest_status' => OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING);
                break;
        }
        $whereArr = array('smt' => 'ocrequest_id = ?', 'vals' => array($row['ocrequest_id']));
        $db = FatApp::getDb();
        if (!empty($dataToUpdate)) {
            if (!$db->updateFromArray(OrderCancelRequest::DB_TBL, $dataToUpdate, $whereArr)) {
                $db->rollbackTransaction();
                Message::addErrorMessage($db->getError());
                CommonHelper::redirectUserReferer();
            }
        }
        $emailObj = new EmailHandler();
        if (!$emailObj->sendOrderCancellationRequestUpdateNotification($row['ocrequest_id'], $this->siteLangId)) {
            Message::addErrorMessage(Labels::getLabel('ERR_EMAIL_SENDING_ERROR', $this->siteLangId) . " " . $emailObj->getError());
            CommonHelper::redirectUserReferer();
        }
        $db->commitTransaction();
        CalculativeDataRecord::updateOrderCancelRequestCount();
        FatUtility::dieJsonSuccess($successMsgString);
    }

    public function viewComment($ocrequestId)
    {
        $ocrequestId = FatUtility::int($ocrequestId);
        $srch = new OrderCancelRequestSearch($this->siteLangId);
        $srch->joinOrderCancelReasons();
        $srch->joinOrderProducts();
        $srch->joinOrderSellerUser();
        $srch->addMultipleFields(['IFNULL(ocreason_title, ocreason_identifier) as ocreason_title', 'ocrequest_message', 'seller.user_name as seller_name', 'seller_cred.credential_username', 'seller_cred.credential_email', 'op_shop_id', 'op_shop_name']);
        $srch->addCondition('ocrequest_id', '=', $ocrequestId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        $this->set('row', $row);
        $this->set('canViewShops', $this->objPrivilege->canViewShops($this->admin_id, true));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function viewAdminComment($ocrequestId)
    {
        $ocrequestId = FatUtility::int($ocrequestId);
        $this->set('comment', OrderCancelRequest::getAttributesById($ocrequestId, 'ocrequest_admin_comment'));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    /************** */
    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('orderCancellationRequestsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            /* 'listSerial' => Labels::getLabel('LBL_ID', $this->siteLangId), */
            'reuqest_detail' => Labels::getLabel('LBL_PRODUCT', $this->siteLangId),
            'buyer_detail' => Labels::getLabel('LBL_BUYER', $this->siteLangId),
            'vendor_detail' => Labels::getLabel('LBL_SELLER', $this->siteLangId),
            'amount' => Labels::getLabel('LBL_AMOUNT', $this->siteLangId),
            'ocrequest_date' => Labels::getLabel('LBL_DATE', $this->siteLangId),
            'orderstatus_name' => Labels::getLabel('LBL_ORDER_STATUS', $this->siteLangId),
            'ocrequest_status' => Labels::getLabel('LBL_REQUEST_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId)
        ];
        CacheHelper::create('orderCancellationRequestsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            /* 'listSerial', */
            'reuqest_detail',
            'buyer_detail',
            /*'vendor_detail',*/
            'amount',
            'orderstatus_name',
            'ocrequest_date',
            'ocrequest_status',
            'action'
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['reuqest_detail', 'amount'], Common::excludeKeysForSort());
    }
}
