<?php
class OrderCancellationRequestsController extends ListingBaseController
{
    protected $modelClass = 'OrderCancelRequest';
    protected $pageKey = 'MANAGE_ORDER_CANCELLATION_REQUESTS';

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
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME_OR_EMAIL', $this->siteLangId));
        $this->getListingData();

        $data = FatApp::getPostedData();
        if ($data) {
            $data['ocrequest_id'] = FatUtility::int($data['id']);
            unset($data['id']);
            $frmSearch->fill($data);
        }
        $this->_template->addJs(['js/select2.js', 'order-cancellation-requests/page-js/index.js']);
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'order_date_added', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_STATUS', $this->siteLangId), 'ocrequest_status', OrderCancelRequest::getRequestStatusArr($this->siteLangId), '', [], Labels::getLabel('FRM_ALL_REQUEST_STATUS', $this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_ORDER_PAYMENT_STATUS', $this->siteLangId), 'op_status_id', Orders::getOrderProductStatusArr($this->siteLangId), '', array(), Labels::getLabel('FRM_ALL_ORDER_PAYMENT_STATUS', $this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_CANCEL_REASON', $this->siteLangId), 'ocrequest_ocreason_id', OrderCancelReason::getOrderCancelReasonArr($this->siteLangId), '', array(), Labels::getLabel('FRM_ALL_ORDER_CANCEL_REASON', $this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER_DETAILS', $this->siteLangId), 'buyer', [], '', ['id' => 'buyerJs', 'placeholder' => Labels::getLabel('LBL_SEARCH', $this->siteLangId)]);
        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_DETAILS', $this->siteLangId), 'seller', [], '', ['id' => 'sellerJs', 'placeholder' => Labels::getLabel('LBL_SEARCH', $this->siteLangId)]);

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));

        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'ocrequest_id', 0);

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-outline-brand');
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
        $data = FatApp::getPostedData();
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
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data);

        $srch = new OrderCancelRequestSearch($this->siteLangId);
        $srch->joinOrderProducts();
        $srch->joinSellerProducts();
        $srch->joinOrders();
        $srch->joinOrderBuyerUser();
        $srch->joinOrderSellerUser();
        $srch->joinOrderProductStatus();
        $srch->joinOrderCancelReasons();
        $srch->addOrderProductCharges();
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder('ocrequest_date', 'DESC');
        $srch->addMultipleFields(
            array(
                'ocrequest_id', 'ocrequest_message', 'ocrequest_date', 'ocrequest_status',
                'buyer.user_name as buyer_name', 'buyer_cred.credential_username as buyer_username', 'buyer_cred.credential_email as buyer_email',
                'buyer.user_phone_dcode as buyer_phone_dcode', 'buyer.user_phone as buyer_phone', 'seller.user_name as seller_name',
                'seller_cred.credential_username as seller_username', 'seller_cred.credential_email as seller_email', 'seller.user_phone_dcode as seller_phone_dcode',
                'seller.user_phone as seller_phone', 'op_invoice_number', 'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name',
                'IFNULL(ocreason_title, ocreason_identifier) as ocreason_title', 'op_qty', 'op_unit_price',
                'order_tax_charged', 'op_other_charges', 'op_rounding_off', 'op_id', 'buyer.user_id AS buyer_id',
                'buyer.user_updated_on AS buyer_updated_on', 'op_shop_id', 'op_shop_name', 'op_selprod_id',
                'op_product_name', 'op_selprod_title', 'op_brand_name', 'selprod_product_id'
            )
        );

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
        if (isset($post['ocrequest_id']) && $post['ocrequest_id'] > 0) {
            $srch->addCondition('ocrequest_id', '=', $post['ocrequest_id']);
        }

        if (isset($post['ocrequest_ocreason_id']) && $post['ocrequest_ocreason_id'] != '') {
            $ocrequest_ocreason_id = FatUtility::int($post['ocrequest_ocreason_id']);
            $srch->addCondition('ocrequest_ocreason_id', '=', $ocrequest_ocreason_id);
        }

        $buyer = FatApp::getPostedData('buyer', FatUtility::VAR_INT, 0);
        if (0 < $buyer) {
            $srch->addCondition('buyer.user_id', '=', $buyer);
        }

        $seller = FatApp::getPostedData('seller', FatUtility::VAR_INT, 0);
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
        
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('requestStatusArr', OrderCancelRequest::getRequestStatusArr($this->siteLangId));
        $this->set('statusClassArr', OrderCancelRequest::getStatusClassArr());
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
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
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'ocrequest_status', OrderCancelRequest::getRequestStatusArr($langId), '', array(), '');
        $moveRefundLocationArr = PaymentMethods::moveRefundLocationsArr($this->siteLangId);
        if (false == $canRefundToCard) {
            unset($moveRefundLocationArr[PaymentMethods::MOVE_TO_CUSTOMER_CARD]);
        } else {
            unset($moveRefundLocationArr[PaymentMethods::MOVE_TO_CUSTOMER_WALLET]);
        }
        $frm->addRadioButtons(Labels::getLabel('FRM_TRANSFER_REFUND', $this->siteLangId), 'ocrequest_refund_in_wallet', $moveRefundLocationArr, PaymentMethods::MOVE_TO_ADMIN_WALLET, array('class' => 'list-inline'));
        $frm->addTextarea(Labels::getLabel('FRM_COMMENT', $this->siteLangId), 'ocrequest_admin_comment');
        $frm->addHiddenField('', 'ocrequest_id', $recordId);
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
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST_OR_STATUS_IS_ALREADY_APPROVED_OR_DECLINED', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
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
                                FatUtility::dieJsonError($paymentMethodObj->getError());
                            }
                            $resp = $paymentMethodObj->getResponse();
                            if (empty($resp)) {
                                $db->rollbackTransaction();
                                LibHelper::exitWithError(Labels::getLabel('LBL_UNABLE_TO_PLACE_GATEWAY_REFUND_REQUEST', $row['order_language_id']), true);
                            }
                            $dataToUpdate['ocrequest_payment_gateway_req_id'] = $resp->id;

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
            Message::addErrorMessage(Labels::getLabel('MSG_EMAIL_SENDING_ERROR', $this->siteLangId) . " " . $emailObj->getError());
            CommonHelper::redirectUserReferer();
        }
        $db->commitTransaction();
        FatUtility::dieJsonSuccess($successMsgString);
    }

    public function viewComment($recordId, $langId = 0)
    {
        $this->checkEditPrivilege();
        // $row = OrderCancelRequest::getAttributesById($recordId);

        $srch = new OrderCancelRequestSearch($this->siteLangId);
        $srch->joinOrderCancelReasons();
        $srch->addCondition('ocrequest_id', '=', $recordId);
        $records = FatApp::getDb()->fetch($srch->getResultSet());
        if (!$records) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $this->set('title', Labels::getLabel('LBL_VIEW_COMMENT', $langId));
        $this->set('cancelMessage', $records);
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
        $withdrawalRequestsTblHeadingCols = CacheHelper::get('withdrawalRequestsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($withdrawalRequestsTblHeadingCols) {
            return json_decode($withdrawalRequestsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'buyer_detail' => Labels::getLabel('LBL_BUYER_DETAILS', $this->siteLangId),
            'vendor_detail' => Labels::getLabel('LBL_SELLER_DETAILS', $this->siteLangId),
            'reuqest_detail' => Labels::getLabel('LBL_REQUEST_DETAILS', $this->siteLangId),
            'amount' => Labels::getLabel('LBL_AMOUNT', $this->siteLangId),
            'ocrequest_date' => Labels::getLabel('LBL_DATE', $this->siteLangId),
            'ocrequest_status' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId)
        ];
        CacheHelper::create('withdrawalRequestsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
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
            'listSerial',
            'buyer_detail',
            'vendor_detail',
            'reuqest_detail',
            'amount',
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
        $excludeArray = [
            'buyer_detail', 'vendor_detail', 'reuqest_detail', 'amount', 'ocrequest_date', 'ocrequest_status'
        ];
        return array_diff($fields, $excludeArray, Common::excludeKeysForSort());
    }
}
