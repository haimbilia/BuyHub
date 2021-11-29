<?php
class OrdersController extends ListingBaseController
{
    private array $order;
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrders();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey('MANAGE_ORDERS', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['searchFrmTemplate'] = 'orders/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_ORDER_ID,_CUSTOMER_NAME,_USERNAME_OR_EMAIL_ID', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'orders/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'orders/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'order_date_added');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC));

        $srchFrm = $this->getSearchForm($fields);
        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new OrderSearch();
        $srch->joinOrderBuyerUser();
        $srch->joinOrderPaymentMethod($this->siteLangId);
        $srch->addCondition('order_type', '=', Orders::ORDER_PRODUCT);

        $srch->addMultipleFields(['order_number', 'order_id', 'order_date_added', 'order_payment_status', 'order_status', 'buyer.user_id', 'buyer.user_name as buyer_user_name', 'buyer_cred.credential_email as buyer_email', 'order_net_amount', 'order_wallet_amount_charge', 'order_pmethod_id', 'IFNULL(plugin_name, plugin_identifier) as plugin_name', 'plugin_code', 'order_is_wallet_selected', 'order_deleted', 'order_cart_data', 'buyer.user_name', 'user_updated_on', 'user_id', 'credential_username', 'buyer_cred.credential_email']);

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $srch->addKeywordSearch($keyword);
        }

        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, -1);
        if (0 < $user_id) {
            $srch->addCondition('buyer.user_id', '=', $user_id);
        }

        if (isset($post['order_payment_status']) && $post['order_payment_status'] != '') {
            $order_payment_status = FatUtility::int($post['order_payment_status']);
            $srch->addCondition('order_payment_status', '=', $order_payment_status);
        }

        $dateFrom = FatApp::getPostedData('date_from', null, '');
        if (!empty($dateFrom)) {
            $srch->addDateFromCondition($dateFrom);
        }

        $dateTo = FatApp::getPostedData('date_to', null, '');
        if (!empty($dateTo)) {
            $srch->addDateToCondition($dateTo);
        }

        $priceFrom = FatApp::getPostedData('price_from', null, '');
        if (!empty($priceFrom)) {
            $srch->addMinPriceCondition($priceFrom);
        }

        $priceTo = FatApp::getPostedData('price_to', null, '');
        if (!empty($priceTo)) {
            $srch->addMaxPriceCondition($priceTo);
        }

        $isDeleted = FatApp::getPostedData('order_deleted', FatUtility::VAR_INT, applicationConstants::NO);
        $srch->addCondition('order_deleted', '=', $isDeleted);
        $this->set("deletedOrders", ($isDeleted == applicationConstants::YES));

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set("canEdit", $this->objPrivilege->canEditOrders($this->admin_id, true));
        $this->set('canViewSellerOrders', $this->objPrivilege->canViewSellerOrders($this->admin_id, true));
    }

    private function orderData(int $orderId, bool $bindHistory = false)
    {
        $srch = new OrderSearch($this->siteLangId);
        $srch->joinOrderPaymentMethod();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->joinOrderBuyerUser();
        $srch->addMultipleFields(
            array(
                'order_number', 'order_id', 'order_user_id', 'order_date_added', 'order_payment_status', 'order_tax_charged', 'order_site_commission',
                'order_reward_point_value', 'order_volume_discount_total', 'buyer.user_name as buyer_user_name', 'buyer_cred.credential_email as buyer_email', 'buyer.user_phone_dcode as buyer_phone_dcode', 'buyer.user_phone as buyer_phone', 'order_net_amount', 'order_shippingapi_name', 'order_pmethod_id', 'ifnull(plugin_name,plugin_identifier)as plugin_name', 'order_discount_total', 'plugin_code', 'order_is_wallet_selected', 'order_reward_point_used', 'order_deleted', 'order_rounding_off'
            )
        );
        $srch->addCondition('order_id', '=', $orderId);
        $srch->addCondition('order_type', '=', Orders::ORDER_PRODUCT);
        $rs = $srch->getResultSet();
        $this->order = FatApp::getDb()->fetch($rs);
        if (!$this->order) {
            Message::addErrorMessage(Labels::getLabel('MSG_Order_Data_Not_Found', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl("Orders"));
        }

        $opSrch = new OrderProductSearch($this->siteLangId, false, true, true);
        $opSrch->joinShippingCharges();
        $opSrch->joinAddress();
        $opSrch->joinOrderProductShipment();
        $opSrch->addCountsOfOrderedProducts();
        $opSrch->addOrderProductCharges();
        $opSrch->joinOrderProductSpecifics();
        $opSrch->joinSellerProducts();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_order_id', '=', $this->order['order_id']);

        $opSellerId = FatApp::getPostedData('op_selprod_user_id', FatUtility::VAR_INT, 0);
        if (0 < $opSellerId) {
            $opSrch->addCondition('op.op_selprod_user_id', '=', $opSellerId);
        }
        
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);
        if (0 < $opId) {
            $opSrch->addCondition('op.op_id', '=', $opId);
        }

        $opSrch->addMultipleFields(
            array(
                'op_id', 'op_status_id', 'op_selprod_id', 'op_selprod_user_id', 'op_invoice_number', 'op_selprod_title', 'op_product_name',
                'op_qty', 'op_brand_name', 'op_selprod_options', 'op_selprod_sku', 'op_product_model',
                'op_shop_name', 'op_shop_owner_name', 'op_shop_owner_email', 'op_shop_owner_phone', 'op_unit_price',
                'totCombinedOrders as totOrders', 'op_shipping_duration_name', 'op_shipping_durations',  'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'op_other_charges', 'op_product_tax_options', 'ops.*', 'opship.*', 'opr_response', 'addr.*', 'ts.state_code', 'tc.country_code', 'op_rounding_off',
                'op_shop_owner_phone_dcode', 'op_selprod_price', 'op_special_price', 'opshipping_by_seller_user_id', 'selprod_product_id', 'orderstatus_color_class'
            )
        );

        $opRs = $opSrch->getResultSet();
        $this->order['products'] = FatApp::getDb()->fetchAll($opRs, 'op_id');

        $orderObj = new Orders($this->order['order_id']);

        $charges = $orderObj->getOrderProductChargesByOrderId($this->order['order_id']);
        $shippingObj = new Shipping($this->siteLangId);
        
        $sellers = [];
        foreach ($this->order['products'] as $opId => $opVal) {
            $sellers[$opVal['op_selprod_user_id']] = $opVal['op_shop_name'];
            $this->order['products'][$opId]['charges'] = $charges[$opId];
            $opChargesLog = new OrderProductChargeLog($opId);
            $taxOptions = $opChargesLog->getData($this->siteLangId);
            $this->order['products'][$opId]['taxOptions'] = $taxOptions;
            if (!empty($opVal["opship_orderid"])) {
                $shippingHanldedBySeller = CommonHelper::canAvailShippingChargesBySeller($opVal['op_selprod_user_id'], $opVal['opshipping_by_seller_user_id']);
                $shippingApiObj = $shippingObj->getShippingApiObj(($shippingHanldedBySeller ? $opVal['opshipping_by_seller_user_id'] : 0)) ?? NULL;
                if (false === $shippingApiObj->loadOrder($opVal["opship_orderid"])) {
                    Message::addErrorMessage($shippingApiObj->getError());
                    FatApp::redirectUser(UrlHelper::generateUrl("Orders"));
                }
                $this->order['products'][$opId]['thirdPartyorderInfo'] = $shippingApiObj ? $shippingApiObj->getResponse() : [];
            }
        }
        $addresses = $orderObj->getOrderAddresses($this->order['order_id']);
        $this->order['billingAddress'] = $this->order['billingAddress'] = [];
        if (!empty($addresses)) {
            $this->order['billingAddress'] = $addresses[Orders::BILLING_ADDRESS_TYPE] ?? [];
            $this->order['shippingAddress'] = $addresses[Orders::SHIPPING_ADDRESS_TYPE] ?? [];
        }

        $this->order['comments'] = $orderObj->getOrderComments($this->siteLangId, array("order_id" => $this->order['order_id']));
        $this->order['payments'] = $orderObj->getOrderPayments(array("order_id" => $this->order['order_id']));

        $this->set('sellers', $sellers);
        $this->set('opSellerId', $opSellerId);
        $this->set('order', $this->order);
        $this->set("canEdit", $this->objPrivilege->canEditOrders($this->admin_id, true));
        $this->set("canEditSellerOrders", $this->objPrivilege->canEditSellerOrders($this->admin_id, true));
    }

    public function view($orderId)
    {
        $this->orderData($orderId);
        $str = Labels::getLabel('LBL_ORDER_#{ORDER-NUMBER}', $this->siteLangId);
        $pageData = PageLanguageData::getAttributesByKey('ORDER_VIEW', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? CommonHelper::replaceStringData($str, ['{ORDER-NUMBER}' =>  $this->order['order_number']]);
        $this->set('pageTitle', $pageTitle);

        $frm = $this->getPaymentForm($this->order['order_id']);
        $this->set('frm', $frm);

        $orderStatusArr = Orders::getOrderPaymentStatusArr($this->siteLangId);
        $this->set('orderStatusArr', $orderStatusArr);
        $this->_template->render();
    }
    
    public function getOrderParticulars($orderId)
    {
        $this->orderData($orderId);
        $jsonData = [
            'itemSummaryHtml' => $this->_template->render(false, false, 'orders/item-summary.php', true),
            'orderSummaryHtml' => $this->_template->render(false, false, 'orders/order-summary.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getItem($orderId)
    {
        $this->orderData($orderId);
        $this->_template->render(false, false);
    }

    private function rowsData(int $orderId)
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $orderObj = new Orders($orderId);
        $srch = $orderObj->getOrderCommentsSrchObj($this->siteLangId, array("op_id" => $recordId));
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', FatApp::getPostedData());
    }

    public function getItemStatusHistory($orderId)
    {
        $this->rowsData($orderId);
        $this->_template->render(false, false);
    }

    public function getRows($orderId)
    {
        $this->rowsData($orderId);
        $this->_template->render(false, false);
    }

    public function orderCommentsForm()
    {
        $this->objPrivilege->canEditSellerOrders();
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);

        $srch = new OrderProductSearch($this->siteLangId, true, true);
        $srch->joinOrderProductShipment();
        $srch->joinOrderUser();
        $srch->joinPaymentMethod();
        $srch->joinShippingUsers();
        $srch->joinShippingCharges();
        $srch->joinAddress();
        $srch->addOrderProductCharges();
        $srch->joinTable(Plugin::DB_TBL, 'LEFT OUTER JOIN', 'ops.opshipping_plugin_id = ops_plugin.plugin_id', 'ops_plugin');
        $srch->addMultipleFields(
            array(
                'ops.*', 'order_number', 'order_id', 'order_payment_status', 'order_pmethod_id', 'order_tax_charged', 'order_date_added', 'op_id', 'op_qty', 'op_unit_price', 'op_selprod_user_id', 'op_invoice_number', 'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'ou.user_name as buyer_user_name', 'ouc.credential_username as buyer_username', 'pm.plugin_code', 'IFNULL(pm_l.plugin_name, IFNULL(pm.plugin_identifier, "Wallet")) as plugin_name', 'op_commission_charged', 'op_qty', 'op_commission_percentage', 'ou.user_name as buyer_name', 'ouc.credential_username as buyer_username', 'ouc.credential_email as buyer_email', 'ou.user_phone_dcode as buyer_phone_dcode', 'ou.user_phone as buyer_phone', 'op.op_shop_owner_name', 'op.op_shop_owner_username', 'op_l.op_shop_name', 'op.op_shop_owner_email', 'op.op_shop_owner_phone_dcode', 'op.op_shop_owner_phone',
                'op_selprod_title', 'op_product_name', 'op_brand_name', 'op_selprod_options', 'op_selprod_sku', 'op_product_model', 'op_product_type',
                'op_shipping_duration_name', 'op_shipping_durations', 'op_status_id', 'op_refund_qty', 'op_refund_amount', 'op_refund_commission', 'op_other_charges', 'optosu.optsu_user_id', 'op_tax_collected_by_seller', 'order_is_wallet_selected', 'order_reward_point_used', 'op_product_tax_options', 'ops.*', 'opship.*', 'opr_response', 'addr.*', 'op_rounding_off', 'orderstatus_id', 'ops_plugin.plugin_code as opshipping_plugin_code', 'op_product_length', 'op_product_width', 'op_product_height', 'op_product_dimension_unit', 'opshipping_by_seller_user_id'
            )
        );
        $srch->addCondition('op_id', '=', $opId);
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        $opRow = FatApp::getDb()->fetch($srch->getResultSet());
        if ($opRow == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $shippingHanldedBySeller = CommonHelper::canAvailShippingChargesBySeller($opRow['op_selprod_user_id'], $opRow['opshipping_by_seller_user_id']);

        $orderObj = new Orders($opRow['order_id']);
        if ($opRow['plugin_code'] == 'CashOnDelivery') {
            $processingStatuses = $orderObj->getAdminAllowedUpdateOrderStatuses(true);
        } else if ($opRow['plugin_code'] == 'PayAtStore') {
            $processingStatuses = $orderObj->getAdminAllowedUpdateOrderStatuses(false, false, true);
        } else {
            $processingStatuses = $orderObj->getAdminAllowedUpdateOrderStatuses(false, $opRow['op_product_type']);
        }

        $data = [
            'op_id' => $opId,
            'op_status_id' => $opRow['op_status_id'],
            'tracking_number' => $opRow['opship_tracking_number']
        ];

        if ($opRow["opshipping_fulfillment_type"] == Shipping::FULFILMENT_PICKUP) {
            $processingStatuses = array_diff($processingStatuses, (array) FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS", FatUtility::VAR_INT, 0));
        } else {
            $processingStatuses = array_diff($processingStatuses, (array) FatApp::getConfig("CONF_PICKUP_READY_ORDER_STATUS", FatUtility::VAR_INT, 0));
        }

        $displayForm = (in_array($opRow['op_status_id'], $processingStatuses) && $opRow['order_payment_status'] != Orders::ORDER_PAYMENT_CANCELLED);
        if (!$displayForm) {
            LibHelper::exitWithError(Labels::getLabel('MSG_NOT_ALLOWED_TO_UPDATE_STATUS', $this->siteLangId), true);
        }

        $allowedShippingUserStatuses = $orderObj->getAdminAllowedUpdateShippingUser();
        $displayShippingUserForm = false;

        if (
            (
                (in_array(strtolower($opRow['plugin_code']), ['cashondelivery', 'payatstore'])) || 
                (in_array($opRow['op_status_id'], $allowedShippingUserStatuses))
            ) && 
            $this->objPrivilege->canEditSellerOrders($this->admin_id, true) && 
            !$shippingHanldedBySeller && 
            ($opRow['op_product_type'] == Product::PRODUCT_TYPE_PHYSICAL && 
            $opRow['order_payment_status'] != Orders::ORDER_PAYMENT_CANCELLED)
        ) {
            $displayShippingUserForm = true;
            $shippingUserFrm = $this->getShippingCompanyUserForm();
            $shippingUserdata = array('op_id' => $opId, 'optsu_user_id' => $opRow['optsu_user_id']);
            $shippingUserFrm->fill($shippingUserdata);
            $this->set('shippingUserFrm', $shippingUserFrm);
        }


        $frm = $this->getOrderCommentsForm($opRow, $processingStatuses);
        $frm->fill($data);
        $this->set('frm', $frm);
        $this->set('op', $opRow);
        $this->set('displayShippingUserForm', $displayShippingUserForm);
        $this->_template->render(false, false);
    }

    private function getShippingCompanyUserForm()
    {
        $srch = User::getSearchObject(true);
        $srch->addOrder('u.user_id', 'DESC');
        $srch->addCondition('u.user_is_shipping_company', '=', applicationConstants::YES);
        $srch->addMultipleFields(array('user_id', 'credential_username'));
        $srch->addCondition('uc.credential_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('uc.credential_verified', '=', applicationConstants::YES);
        $records = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());

        $frm = new Form('frmShippingUser');
        $frm->addHiddenField('', 'op_id');
        $frm->addSelectBox(Labels::getLabel('FRM_SHIPPING_USER', $this->siteLangId), 'optsu_user_id', $records)->requirements()->setRequired();
        return $frm;
    }


    private function getOrderCommentsForm($orderData = array(), $processingOrderStatus = [])
    {
        $frm = new Form('frmOrderComments');
        $frm->addTextArea(Labels::getLabel('LBL_Your_Comments', $this->siteLangId), 'comments');
        $orderStatusArr = Orders::getOrderProductStatusArr($this->siteLangId, $processingOrderStatus, $orderData['op_status_id']);

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'op_status_id', $orderStatusArr, '', [], Labels::getLabel('LBL_Select', $this->siteLangId));
        $fld->requirements()->setRequired();

        $frm->addSelectBox(Labels::getLabel('LBL_Notify_Customer', $this->siteLangId), 'customer_notified', applicationConstants::getYesNoArr($this->siteLangId), '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirements()->setRequired();
        if (array_key_exists('opship_tracking_number', $orderData) && (empty($orderData['opship_tracking_number']) || $orderData['opshipping_plugin_code'] == 'ShipStationShipping') && $orderData['orderstatus_id'] !=  FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS")) {
            $manualFld = $frm->addCheckBox(Labels::getLabel('LBL_SELF_SHIPPING', $this->siteLangId), 'manual_shipping', 1, array(), false, 0);
            $manualShipUnReqObj = new FormFieldRequirement('manual_shipping', Labels::getLabel('LBL_SELF_SHIPPING', $this->siteLangId));
            $manualShipUnReqObj->setRequired(false);
            $manualShipReqObj = new FormFieldRequirement('manual_shipping', Labels::getLabel('LBL_SELF_SHIPPING', $this->siteLangId));
            $manualShipReqObj->setRequired(true);

            $fld->requirements()->addOnChangerequirementUpdate(FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS"), 'eq', 'manual_shipping', $manualShipReqObj);
            $fld->requirements()->addOnChangerequirementUpdate(FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS"), 'ne', 'manual_shipping', $manualShipUnReqObj);

            $frm->addTextBox(Labels::getLabel('LBL_Tracking_Number', $this->siteLangId), 'tracking_number');

            $trackingUnReqObj = new FormFieldRequirement('tracking_number', Labels::getLabel('LBL_Tracking_Number', $this->siteLangId));
            $trackingUnReqObj->setRequired(false);

            $trackingReqObj = new FormFieldRequirement('tracking_number', Labels::getLabel('LBL_Tracking_Number', $this->siteLangId));
            $trackingReqObj->setRequired(true);

            $manualFld->requirements()->addOnChangerequirementUpdate(applicationConstants::YES, 'eq', 'tracking_number', $trackingReqObj);
            $manualFld->requirements()->addOnChangerequirementUpdate(applicationConstants::NO, 'eq', 'tracking_number', $trackingUnReqObj);

            $frm->addTextBox(Labels::getLabel('LBL_TRACKING_URL', $this->siteLangId), 'opship_tracking_url');

            $trackingUrlUnReqObj = new FormFieldRequirement('opship_tracking_url', Labels::getLabel('LBL_TRACKING_URL', $this->siteLangId));
            $trackingUrlUnReqObj->setRequired(false);

            $trackingurlReqObj = new FormFieldRequirement('opship_tracking_url', Labels::getLabel('LBL_TRACKING_URL', $this->siteLangId));
            $trackingurlReqObj->setRequired(true);

            $manualFld->requirements()->addOnChangerequirementUpdate(applicationConstants::YES, 'eq', 'opship_tracking_url', $trackingurlReqObj);
            $manualFld->requirements()->addOnChangerequirementUpdate(applicationConstants::NO, 'eq', 'opship_tracking_url', $trackingUrlUnReqObj);

            $shipmentTracking = new ShipmentTracking();
            if (false !== $shipmentTracking->init($this->siteLangId) && false !== $shipmentTracking->getTrackingCouriers()) {
                $trackCarriers = $shipmentTracking->getResponse();
                $frm->addSelectBox(Labels::getLabel('LBL_TRACKING_COURIER', $this->siteLangId), 'oshistory_courier', $trackCarriers, '', array(), Labels::getLabel('LBL_Select', $this->siteLangId));

                $trackCarrierFldUnReqObj = new FormFieldRequirement('oshistory_courier', Labels::getLabel('LBL_TRACKING_COURIER', $this->siteLangId));
                $trackCarrierFldUnReqObj->setRequired(false);

                $trackCarrierFldReqObj = new FormFieldRequirement('oshistory_courier', Labels::getLabel('LBL_TRACKING_COURIER', $this->siteLangId));
                $trackCarrierFldReqObj->setRequired(true);

                $manualFld->requirements()->addOnChangerequirementUpdate(applicationConstants::YES, 'eq', 'oshistory_courier', $trackCarrierFldReqObj);
                $manualFld->requirements()->addOnChangerequirementUpdate(applicationConstants::NO, 'eq', 'oshistory_courier', $trackCarrierFldUnReqObj);
            }
        }

        $frm->addHiddenField('', 'op_id', 0);
        return $frm;
    }

    public function orderProductsCharges($orderId, int $chargeType = 0)
    {
        $opSrch = new OrderProductSearch($this->siteLangId, true, true, true);
        $opSrch->joinShippingCharges();
        $opSrch->joinSellerProducts();
        $opSrch->joinAddress();
        $opSrch->joinOrderProductShipment();
        $opSrch->addCountsOfOrderedProducts();
        $opSrch->addOrderProductCharges();
        $opSrch->joinOrderProductSpecifics();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_order_id', '=', $orderId);

        $opSrch->addMultipleFields(
            [
                'order_id', 'order_number', 'order_date_added', 'op_id', 'op_selprod_user_id', 'op_invoice_number', 'op_selprod_title', 'op_product_name',
                'op_qty', 'op_brand_name', 'op_selprod_options', 'op_selprod_sku', 'op_product_model',
                'op_shop_name', 'op_shop_owner_name', 'op_shop_owner_email', 'op_shop_owner_phone', 'op_unit_price',
                'totCombinedOrders as totOrders', 'op_shipping_duration_name', 'op_shipping_durations',  'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'op_other_charges', 'op_product_tax_options', 'ops.*', 'opship.*', 'opr_response', 'addr.*', 'ts.state_code', 'tc.country_code', 'op_rounding_off',
                'op_shop_owner_phone_dcode', 'op_selprod_price', 'op_special_price', 'opshipping_by_seller_user_id', 'op_is_batch', 'op_selprod_id', 'selprod_product_id'
            ]
        );
        $opsShippingDetail = FatApp::getDb()->fetchAll($opSrch->getResultSet());

        $oObj = new Orders();
        foreach ($opsShippingDetail as &$op) {
            $charges = $oObj->getOrderProductChargesArr($op['op_id']);
            $op['charges'] = $charges;
        }

        $this->set('opsShippingDetail', $opsShippingDetail);
        switch ($chargeType) {
            case OrderProduct::CHARGE_TYPE_SHIPPING:
                $this->_template->render(false, false, 'orders/order-products-shipping.php');
                break;
            case OrderProduct::CHARGE_TYPE_TAX:
                $this->_template->render(false, false, 'orders/order-products-tax.php');
                break;
            case OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT:
                $this->_template->render(false, false, 'orders/order-products-vol-discount.php');
                break;
            case OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT:
                $this->_template->render(false, false, 'orders/order-products-rewards.php');
                break;
            
            default:
                LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_CHARGE_TYPE', $this->siteLangId), true);
                break;
        }
    }

    public function updatePayment()
    {
        $this->objPrivilege->canEditOrders();
        $frm = $this->getPaymentForm($this->siteLangId);

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $orderId = $post['opayment_order_id'];

        if ($orderId == '' || $orderId == null) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = new OrderSearch($this->siteLangId);
        $srch->joinOrderPaymentMethod();
        $srch->addMultipleFields(array('plugin_code'));
        $srch->addCondition('order_id', '=', $orderId);
        $srch->addCondition('order_type', '=', Orders::ORDER_PRODUCT);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $order = FatApp::getDb()->fetch($rs);
        if (!empty($order) && array_key_exists('plugin_code', $order) && 'CashOnDelivery' == $order['plugin_code']) {
            LibHelper::exitWithError(Labels::getLabel('LBL_COD_orders_are_not_eligible_for_payment_status_update', $this->siteLangId), true);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        if (!$orderPaymentObj->addOrderPayment($post["opayment_method"], $post['opayment_gateway_txn_id'], $post["opayment_amount"], $post["opayment_comments"])) {
            LibHelper::exitWithError($orderPaymentObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('LBL_Payment_Details_Added_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function approvePayment(int $orderPaymentId)
    {
        $orederObj = new Orders();
        $result = current($orederObj->getOrderPayments(['id' => $orderPaymentId]));
        if (!empty($result)) {
            $db = FatApp::getDb();
            $db->startTransaction();
            if (!$db->updateFromArray(
                Orders::DB_TBL,
                array('order_payment_status' => Orders::ORDER_PAYMENT_PAID, 'order_date_updated' => date('Y-m-d H:i:s')),
                array('smt' => 'order_id = ? ', 'vals' => array($result['opayment_order_id']))
            )) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }

            if (!$db->updateFromArray(
                Orders::DB_TBL_ORDER_PAYMENTS,
                array('opayment_txn_status' => Orders::ORDER_PAYMENT_PAID),
                array('smt' => 'opayment_id = ? ', 'vals' => array($orderPaymentId))
            )) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }

            if (!$db->updateFromArray(
                Orders::DB_TBL_ORDER_PRODUCTS,
                array('op_status_id' => FatApp::getConfig("CONF_DEFAULT_PAID_ORDER_STATUS")),
                array('smt' => 'op_order_id = ? ', 'vals' => array($result['opayment_order_id']))
            )) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }
        }

        $db->commitTransaction();
        $this->set('msg', Labels::getLabel("MSG_APPROVED", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function rejectPayment(int $orderPaymentId)
    {
        $orederObj = new Orders();
        $result = current($orederObj->getOrderPayments(['id' => $orderPaymentId]));
        if (!empty($result)) {
            $db = FatApp::getDb();
            $db->startTransaction();
            if (!$db->updateFromArray(
                Orders::DB_TBL,
                array('order_payment_status' => Orders::ORDER_PAYMENT_CANCELLED, 'order_date_updated' => date('Y-m-d H:i:s')),
                array('smt' => 'order_id = ? ', 'vals' => array($result['opayment_order_id']))
            )) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }

            if (!$db->updateFromArray(
                Orders::DB_TBL_ORDER_PAYMENTS,
                array('opayment_txn_status' => Orders::ORDER_PAYMENT_CANCELLED),
                array('smt' => 'opayment_id = ? ', 'vals' => array($orderPaymentId))
            )) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }

            if (!$db->updateFromArray(
                Orders::DB_TBL_ORDER_PRODUCTS,
                array('op_status_id' => FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS")),
                array('smt' => 'op_order_id = ? ', 'vals' => array($result['opayment_order_id']))
            )) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }
        }
        $db->commitTransaction();
        $this->set('msg', Labels::getLabel("MSG_REJECTED", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditOrders();
        $orderId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $this->markAsDeleted($orderId);

        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditOrders();
        $orderIdsArr = FatUtility::int(FatApp::getPostedData('order_ids'));
        if (empty($orderIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($orderIdsArr as $orderId) {
            $this->markAsDeleted($orderId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($orderId)
    {
        $orderObj = new Orders();
        $order = $orderObj->getOrderById($orderId);
        if (false === $order) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Error:_Please_perform_this_action_on_valid_record.', $this->siteLangId), true);
        }

        if (!$order["order_payment_status"]) {
            $updateArray = array('order_deleted' => applicationConstants::YES);
            $whr = array('smt' => 'order_id = ?', 'vals' => array($orderId));

            if (!FatApp::getDb()->updateFromArray(Orders::DB_TBL, $updateArray, $whr)) {
                LibHelper::exitWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId), true);
            }
        }
    }

    private function getPaymentForm($orderId = '')
    {
        $frm = new Form('frmPayment');
        $frm->addHiddenField('', 'opayment_order_id', $orderId);
        $frm->addTextArea(Labels::getLabel('FRM_Comments', $this->siteLangId), 'opayment_comments', '')->requirements()->setRequired();
        $frm->addRequiredField(Labels::getLabel('FRM_Payment_Method', $this->siteLangId), 'opayment_method');
        $frm->addRequiredField(Labels::getLabel('FRM_Txn_ID', $this->siteLangId), 'opayment_gateway_txn_id');
        $frm->addRequiredField(Labels::getLabel('FRM_Amount', $this->siteLangId), 'opayment_amount')->requirements()->setFloatPositive(true);
        return $frm;
    }

    protected function getSearchForm($fields = [])
    {
        $currency_id = FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1);
        $currencyData = Currency::getAttributesById($currency_id, array('currency_code', 'currency_symbol_left', 'currency_symbol_right'));
        $currencySymbol = ($currencyData['currency_symbol_left'] != '') ? $currencyData['currency_symbol_left'] : $currencyData['currency_symbol_right'];

        $frm = new Form('frmRecordSearch');

        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'order_date_added', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER', $this->siteLangId), 'user_id', []);

        $frm->addSelectBox(Labels::getLabel('FRM_DELETED_ORDERS', $this->siteLangId), 'order_deleted', applicationConstants::getYesNoArr($this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_Payment_Status', $this->siteLangId), 'order_payment_status', Orders::getOrderPaymentStatusArr($this->siteLangId));

        $frm->addDateField('', 'date_from', '', array('placeholder' => 'Date From', 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField('', 'date_to', '', array('placeholder' => 'Date To', 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addTextBox('', 'price_from', '', array('placeholder' => 'Order From' . ' [' . $currencySymbol . ']'));
        $frm->addTextBox('', 'price_to', '', array('placeholder' => 'Order To [' . $currencySymbol . ']'));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $abusiveWordsTblHeadingCols = CacheHelper::get('abusiveWordsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($abusiveWordsTblHeadingCols) {
            return json_decode($abusiveWordsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'order_number' => Labels::getLabel('LBL_Order_ID', $this->siteLangId),
            'buyer_user_name' => Labels::getLabel('LBL_Customer_Name', $this->siteLangId),
            'order_date_added' => Labels::getLabel('LBL_ORDER_DATE_&_TIME', $this->siteLangId),
            'order_net_amount' => Labels::getLabel('LBL_Total', $this->siteLangId),
            'order_payment_status' => Labels::getLabel('LBL_Payment_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        CacheHelper::create('abusiveWordsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'order_number',
            'buyer_user_name',
            'order_date_added',
            'order_net_amount',
            'order_payment_status',
            'action'
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
