<?php

trait OrdersPackage
{
    private array $order;
    private string $directory;
    protected string $viewPageKey;
    protected string $tblHeadingKey;

    private function initVariables()
    {
        switch ($this->ordersType) {
            case Orders::ORDER_PRODUCT:
                $this->directory = 'orders';
                $this->viewPageKey = 'ORDER_VIEW';
                $this->tblHeadingKey = 'ordersTblHeadingCols';
                break;
            case Orders::ORDER_SUBSCRIPTION:
                $this->directory = 'subscription-orders';
                $this->viewPageKey = 'SUBSCRIPTION_ORDER_VIEW';
                $this->tblHeadingKey = 'subscriptionOrdersTblHeadingCols';
                break;
            case Orders::GIFT_CARD_TYPE:
                $this->directory = 'gift-card-orders';
                $this->viewPageKey = 'GIFT_CARD_ORDER_VIEW';
                $this->tblHeadingKey = 'giftCardOrdersTblHeadingCols';
                break;
            default:
                Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ORDER_TYPE', $this->siteLangId));
                CommonHelper::redirectUserReferer();
                break;
        }
    }

    public function index()
    {

        $this->initVariables();

        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['searchFrmTemplate'] = $this->directory . '/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_ORDER_ID,_BUYER_NAME,_USERNAME_OR_EMAIL_ID', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', $this->directory . '/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->initVariables();

        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, $this->directory . '/search.php', true),
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
            $sortBy = 'order_date_added';
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);
        $srchFrm = $this->getSearchForm($fields);
        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $srch = new OrderSearch();
        $srch->joinOrderBuyerUser();
        $srch->joinOrderPaymentMethod($this->siteLangId);
        $srch->addCondition('order_type', '=', $this->ordersType);
        if ($this->ordersType == Orders::GIFT_CARD_TYPE) {
            $srch->joinTable(GiftCards::DB_TBL, 'INNER JOIN', 'ogcards.ogcards_order_id = order_id', 'ogcards');
        }
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

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        if (0 < $recordId) {
            $srch->addCondition('order_id', '=', $recordId);
        }

        $recordId = FatApp::getPostedData('op_status_id', FatUtility::VAR_INT, 0);
        if (0 < $recordId) {
            $opSrch = new OrderProductSearch(0, true, true);
            $opSrch->addStatusCondition($recordId, ($recordId == FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS", FatUtility::VAR_INT, -1)));
            $opSrch->addGroupBy('op_order_id');
            $opSrch->doNotCalculateRecords();
            $opSrch->doNotLimitRecords();
            $opSrch->addMultipleFields(['op_order_id']);
            $srch->joinTable('(' . $opSrch->getQuery() . ')', 'INNER JOIN', 'op.op_order_id = o.order_id', 'op');
        }

        $isDeleted = FatApp::getPostedData('order_deleted', FatUtility::VAR_INT, applicationConstants::NO);
        $srch->addCondition('order_deleted', '=', $isDeleted);
        $this->set("deletedOrders", ($isDeleted == applicationConstants::YES));

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $fieldsearch = ['order_number', 'order_id', 'order_date_added', 'order_payment_status', 'order_status', 'buyer.user_id', 'buyer.user_name as buyer_user_name', 'buyer_cred.credential_email as buyer_email', 'order_net_amount', 'order_wallet_amount_charge', 'order_pmethod_id', 'IFNULL(plugin_name, plugin_identifier) as plugin_name', 'plugin_code', 'order_is_wallet_selected', 'order_deleted', 'order_cart_data', 'buyer.user_name', 'user_updated_on', 'user_id', 'credential_username', 'buyer_cred.credential_email'];
        if ($this->ordersType == Orders::GIFT_CARD_TYPE) {
            $fieldsearch[] = 'ogcards_receiver_name';
            $fieldsearch[] = 'ogcards_receiver_email';
        }

        $srch->addMultipleFields($fieldsearch);
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
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set("canEdit", $this->objPrivilege->canEditOrders($this->admin_id, true));
        $this->set('canViewSellerOrders', $this->objPrivilege->canViewSellerOrders($this->admin_id, true));
    }

    public function view($orderId)
    {
        $this->initVariables();

        $this->orderData($orderId);
        if ($this->ordersType == Orders::ORDER_SUBSCRIPTION) {
            $str = Labels::getLabel('LBL_SUBSCRIPTION_ORDER_#{ORDER-NUMBER}', $this->siteLangId);
        } else {
            $str = Labels::getLabel('LBL_ORDER_#{ORDER-NUMBER}', $this->siteLangId);
        }

        $pageData = PageLanguageData::getAttributesByKey($this->viewPageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? CommonHelper::replaceStringData($str, ['{ORDER-NUMBER}' =>  $this->order['order_number']]);
        $this->set('pageTitle', $pageTitle);
        $this->set('pageData', $pageData);

        $frm = $this->getPaymentForm($this->order['order_id']);
        $this->set('frm', $frm);

        $oSubObj = new OrderSubscription();
        $charges = [];
        if (isset($this->get('order')['items'])) {
            $item = current($this->get('order')['items']);
            $charges = $oSubObj->getOrderSubscriptionChargesArr($item['ossubs_id']);
        }
        $this->set('order', $this->get('order') +  ['charges' => $charges]);

        $orderStatusArr = Orders::getOrderPaymentStatusArr($this->siteLangId);
        $subcriptionPeriodArr = SellerPackagePlans::getSubscriptionPeriods($this->siteLangId);

        $this->set('subcriptionPeriodArr', $subcriptionPeriodArr);
        $this->set('orderStatusArr', $orderStatusArr);
        $this->_template->addJs(array('js/jquery.datetimepicker.js'), false);
        $this->_template->addCss(array('css/jquery.datetimepicker.css'), false);
        $this->includeFeatherLightJsCss();
        $this->_template->render();
    }

    public function getItem($orderId)
    {
        $this->orderData($orderId);
        $subcriptionPeriodArr = SellerPackagePlans::getSubscriptionPeriods($this->siteLangId);

        $this->set('subcriptionPeriodArr', $subcriptionPeriodArr);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getPaymentForm($orderId = '')
    {
        $frm = new Form('frmPayment');
        $frm->addHiddenField('', 'opayment_order_id', $orderId);
        $frm->addTextArea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'opayment_comments', '')->requirements()->setRequired();
        $frm->addRequiredField(Labels::getLabel('FRM_PAYMENT_METHOD', $this->siteLangId), 'opayment_method');
        $frm->addRequiredField(Labels::getLabel('FRM_TXN_ID', $this->siteLangId), 'opayment_gateway_txn_id');
        $frm->addRequiredField(Labels::getLabel('FRM_AMOUNT', $this->siteLangId), 'opayment_amount')->requirements()->setFloatPositive(true);
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
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER', $this->siteLangId), 'user_id', []);

        $frm->addSelectBox(Labels::getLabel('FRM_DELETED_ORDERS', $this->siteLangId), 'order_deleted', applicationConstants::getYesNoArr($this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_PAYMENT_STATUS', $this->siteLangId), 'order_payment_status', Orders::getOrderPaymentStatusArr($this->siteLangId));

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));

        $str = Labels::getLabel('FRM_ORDER_FROM_[{CURRENCY-SYMBOL}]', $this->siteLangId);
        $str = CommonHelper::replaceStringData($str, ['{CURRENCY-SYMBOL}' => $currencySymbol]);
        $frm->addTextBox(Labels::getLabel('FRM_ORDER_FROM', $this->siteLangId), 'price_from', '', array('placeholder' => $str));

        $str = Labels::getLabel('FRM_ORDER_TO[{CURRENCY-SYMBOL}]', $this->siteLangId);
        $str = CommonHelper::replaceStringData($str, ['{CURRENCY-SYMBOL}' => $currencySymbol]);
        $frm->addTextBox(Labels::getLabel('FRM_ORDER_TO', $this->siteLangId), 'price_to', '', array('placeholder' => $str));

        $frm->addSelectBox(Labels::getLabel('FRM_ORDER_ITEM_STATUS', $this->siteLangId), 'op_status_id', Orders::getOrderProductStatusArr($this->siteLangId), '', array(), Labels::getLabel('LBL_All', $this->siteLangId));

        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
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
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($orderIdsArr as $orderId) {
            $this->markAsDeleted($orderId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($orderId)
    {
        $orderObj = new Orders();
        $order = $orderObj->getOrderById($orderId);
        if (false === $order) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_PERFORM_THIS_ACTION_ON_VALID_RECORD.', $this->siteLangId), true);
        }
        $twoDaysAfter = date('Y-m-d H:i:s', strtotime($order['order_date_added'] . ' + 2 days'));
        if ($order['order_deleted'] || $order['order_payment_status'] != Orders::ORDER_PAYMENT_PENDING || $twoDaysAfter > date('Y-m-d H:i:s')) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NOT_ALLOWED_TO_DELETE_THIS_ORDER', $this->siteLangId), true);
        }

        if (!$order["order_payment_status"]) {
            $updateArray = array('order_deleted' => applicationConstants::YES);
            $whr = array('smt' => 'order_id = ?', 'vals' => array($orderId));

            if (!FatApp::getDb()->updateFromArray(Orders::DB_TBL, $updateArray, $whr)) {
                LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Access', $this->siteLangId), true);
            }
        }
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get($this->tblHeadingKey . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }
        if ($this->ordersType == Orders::GIFT_CARD_TYPE) {
            $arr = [
                'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
                /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
                'order_number' => Labels::getLabel('LBL_Order_ID', $this->siteLangId),
                'buyer_user_name' => Labels::getLabel('LBL_BUYER_NAME', $this->siteLangId),
                'ogcards_receiver_name' => Labels::getLabel('LBL_RECEIVER_NAME', $this->siteLangId),
                'ogcards_receiver_email' => Labels::getLabel('LBL_RECEIVER_EMAIL', $this->siteLangId),
                'order_date_added' => Labels::getLabel('LBL_ORDER_DATE_&_TIME', $this->siteLangId),
                'order_net_amount' => Labels::getLabel('LBL_Total', $this->siteLangId),
                'order_payment_status' => Labels::getLabel('LBL_Payment_Status', $this->siteLangId),
                'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
            ];
        } else {
            $arr = [
                'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
                /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
                'order_number' => Labels::getLabel('LBL_Order_ID', $this->siteLangId),
                'buyer_user_name' => Labels::getLabel('LBL_BUYER_NAME', $this->siteLangId),
                'order_date_added' => Labels::getLabel('LBL_ORDER_DATE_&_TIME', $this->siteLangId),
                'order_net_amount' => Labels::getLabel('LBL_Total', $this->siteLangId),
                'order_payment_status' => Labels::getLabel('LBL_Payment_Status', $this->siteLangId),
                'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
            ];
        }



        CacheHelper::create($this->tblHeadingKey . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {

        if ($this->ordersType == Orders::GIFT_CARD_TYPE) {
            return [
                'select_all',
                /*  'listSerial', */
                'order_number',
                'buyer_user_name',
                'ogcards_receiver_name',
                'ogcards_receiver_email',
                'order_date_added',
                'order_net_amount',
                'order_payment_status',
                'action'
            ];
        } else {
            return [
                'select_all',
                /*  'listSerial', */
                'order_number',
                'buyer_user_name',
                'order_date_added',
                'order_net_amount',
                'order_payment_status',
                'action'
            ];
        }
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'view':
                $lbl = Labels::getLabel('LBL_ORDER', $this->siteLangId);
                $pageUrl = UrlHelper::generateUrl('Orders');
                if ($this->ordersType == Orders::ORDER_SUBSCRIPTION) {
                    $lbl = Labels::getLabel('LBL_SUBSCRIPTION_ORDER', $this->siteLangId);
                    $pageUrl = UrlHelper::generateUrl('SubscriptionOrders');
                }
                $lbl = $this->ordersType == Orders::ORDER_SUBSCRIPTION ? Labels::getLabel('LBL_SUBSCRIPTION_ORDER', $this->siteLangId) : Labels::getLabel('LBL_ORDER', $this->siteLangId);
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? $lbl;

                $url = FatApp::getQueryStringData('url');
                $urlParts = explode('/', $url);
                $title = Labels::getLabel('LBL_VIEW_ORDER', $this->siteLangId);
                if (isset($urlParts[2])) {
                    $title = Orders::getAttributesById($urlParts[2], 'order_number');
                }

                $this->nodes = [
                    ['title' => $pageTitle, 'href' => $pageUrl],
                    ['title' => $title]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
