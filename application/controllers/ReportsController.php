<?php

class ReportsController extends SellerBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'S';
        if (!User::canAccessSupplierDashboard()) {
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'supplierApprovalForm'));
        }
        $this->set('bodyClass', 'is--dashboard');
    }

    public function index()
    {
        if (User::isSeller()) {
            FatApp::redirectUser(UrlHelper::generateUrl('seller'));
        } elseif (User::isBuyer()) {
            FatApp::redirectUser(UrlHelper::generateUrl('buyer'));
        } else {
            FatApp::redirectUser(UrlHelper::generateUrl(''));
        }
    }

    public function productsPerformance()
    {
        $this->userPrivilege->canViewPerformanceReport(UserAuthentication::getLoggedUserId());
        if (!User::canAccessSupplierDashboard() || !User::isSellerVerified($this->userParentId)) {
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'supplierApprovalForm'));
        }
        $srchFrm = $this->getProdPerformanceSrchForm();
        $this->set('srchFrm', $srchFrm);
        $this->_template->render(true, true);
    }

    public function searchProductsPerformance($topPerformed = 0, $export = "")
    {
        if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $userId = $this->userParentId;
        $shopDetails = Shop::getAttributesByUserId($userId, array('shop_id'), false);

        if (!$shopDetails) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        /* Sub Query to get, how many users added current product in his/her wishlist[ */
        $uWsrch = new UserWishListProductSearch($this->siteLangId);
        $uWsrch->doNotCalculateRecords();
        $uWsrch->doNotLimitRecords();
        $uWsrch->joinWishLists();
        $uWsrch->addGroupBy('uwlp_selprod_id');
        $uWsrch->addMultipleFields(array('uwlp_selprod_id', 'count(uwlist_user_id) as wishlist_user_counts'));
        /* ] */

        $srch = new OrderProductSearch($this->siteLangId, true);
        $srch->joinPaymentMethod();
        $srch->joinTable('(' . $uWsrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tquwl.uwlp_selprod_id = op.op_selprod_id', 'tquwl');
        $srch->addCondition('op_shop_id', '=', $shopDetails['shop_id']);
        //$srch->doNotCalculateRecords();
        $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));
        $cnd = $srch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $cnd->attachCondition('plugin_code', '=', 'cashondelivery');
        $cnd->attachCondition('plugin_code', '=', 'payatstore');
        $srch->addMultipleFields(array('op_selprod_title', 'op_product_name', 'op_selprod_options', 'op_brand_name', 'SUM(op_refund_qty) as totRefundQty', 'SUM(op_qty - op_refund_qty) as totSoldQty', 'op.op_selprod_id', 'IFNULL(tquwl.wishlist_user_counts, 0) as wishlist_user_counts', 'op_selprod_sku'));
        $srch->addGroupBy('op.op_selprod_id');
        $srch->addGroupBy('op.op_is_batch');
        if ($topPerformed) {
            $srch->addOrder('totSoldQty', 'desc');
            $srch->addHaving('totSoldQty', '>', 0);
        } else {
            $srch->addOrder('totRefundQty', 'desc');
            $srch->addHaving('totRefundQty', '>', 0);
        }

        if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel('LBL_Product', $this->siteLangId), Labels::getLabel('LBL_Custom_Title', $this->siteLangId), Labels::getLabel('LBL_Options', $this->siteLangId), Labels::getLabel('LBL_Brand', $this->siteLangId), Labels::getLabel('LBL_SKU', $this->siteLangId), Labels::getLabel('LBL_WishList_User_Counts', $this->siteLangId));

            if ($topPerformed) {
                array_push($arr, Labels::getLabel('LBL_Sold_Quantity', $this->siteLangId));
            } else {
                array_push($arr, Labels::getLabel('LBL_Refund_Quantity', $this->siteLangId));
            }

            array_push($sheetData, $arr);
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = array($row['op_product_name'], $row['op_selprod_title'], $row['op_selprod_options'],  $row['op_brand_name'], $row['op_selprod_sku'], $row['wishlist_user_counts']);

                if ($topPerformed) {
                    array_push($arr, $row['totSoldQty']);
                } else {
                    array_push($arr, $row['totRefundQty']);
                }

                array_push($sheetData, $arr);
            }
            $csvName = '';
            if ($topPerformed) {
                $csvName = Labels::getLabel('LBL_Top_Performing_Products_Report', $this->siteLangId) . date("Y-m-d") . '.csv';
            } else {
                $csvName = Labels::getLabel('LBL_Most_Refunded_Products_Report', $this->siteLangId) . date("Y-m-d") . '.csv';
            }
            CommonHelper::convertToCsv($sheetData, $csvName, ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arrListing = FatApp::getDb()->fetchAll($rs);
            $this->set('arrListing', $arrListing);
            $this->set('topPerformed', $topPerformed);
            $this->set('page', $page);
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('postedData', $post);
            $this->_template->render(false, false);
        }
    }

    public function searchMostWishListAddedProducts($export = "")
    {
        if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $userId = $this->userParentId;
        $shopDetails = Shop::getAttributesByUserId($userId, array('shop_id'), false);

        if (!$shopDetails) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        /* $srch = new ProductSearch( $this->siteLangId );
        $srch->setDefinedCriteria( 0 );
        $srch->joinProductToCategory(); */

        /* Sub Query to get, how many users added current product in his/her wishlist[ */
        $uWsrch = new UserWishListProductSearch($this->siteLangId);
        $uWsrch->doNotCalculateRecords();
        $uWsrch->doNotLimitRecords();
        $uWsrch->joinWishLists();
        $uWsrch->addGroupBy('uwlp_selprod_id');
        $uWsrch->addMultipleFields(array('uwlp_selprod_id', 'count(uwlist_user_id) as wishlist_user_counts'));
        /* ] */

        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(Brand::DB_TBL, 'LEFT OUTER JOIN', 'p.product_brand_id = b.brand_id', 'b');
        $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT OUTER JOIN', 'b.brand_id = b_l.brandlang_brand_id AND b_l.brandlang_lang_id = ' . $this->siteLangId, 'b_l');
        $srch->joinTable('(' . $uWsrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tquwl.uwlp_selprod_id = sp.selprod_id', 'tquwl');
        $srch->addCondition('selprod_user_id', '=', $userId);
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('wishlist_user_counts', '>', applicationConstants::NO);
        $srch->addOrder('wishlist_user_counts', 'DESC');
        $srch->addMultipleFields(array('selprod_id', 'product_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'selprod_active', 'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(tquwl.wishlist_user_counts, 0) as wishlist_user_counts', 'selprod_sku'));

        if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel('LBL_Product', $this->siteLangId), Labels::getLabel('LBL_Custom_Title', $this->siteLangId), Labels::getLabel('LBL_Brand', $this->siteLangId), Labels::getLabel('LBL_SKU', $this->siteLangId), Labels::getLabel('LBL_User_Counts', $this->siteLangId));
            array_push($sheetData, $arr);
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = array($row['product_name'], $row['selprod_title'], $row['brand_name'], $row['selprod_sku'], $row['wishlist_user_counts']);
                array_push($sheetData, $arr);
            }
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Most_Favorites_Products_Report', $this->siteLangId) . date("Y-m-d") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();

            $arrListing = FatApp::getDb()->fetchAll($rs);
            $this->set('arrListing', $arrListing);
            $this->set('pageCount', $srch->pages());
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('postedData', $post);
            $this->set('recordCount', $srch->recordCount());
            $this->_template->render(false, false);
        }
    }

    public function exportMostWishListAddedProducts()
    {
        $this->searchMostWishListAddedProducts("export");
    }

    public function exportProductPerformance($orderBy = 'DESC')
    {
        $this->searchProductsPerformance($orderBy, "export");
    }

    public function productsInventory()
    {
        $this->userPrivilege->canViewInventoryReport(UserAuthentication::getLoggedUserId());
        if (!User::canAccessSupplierDashboard()) {
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'supplierApprovalForm'));
        }
        $frmSrch = $this->getProductInventorySearchForm($this->siteLangId);
        $this->set('frmSrch', $frmSrch);
        $this->_template->render(true, true);
    }

    public function searchProductsInventory($export = "")
    {
        if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $post = FatApp::getPostedData();
        $pageSize = FatApp::getConfig('CONF_PAGE_SIZE');
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        if ($page < 2) {
            $page = 1;
        }
        $userId = $this->userParentId;
        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(Brand::DB_TBL, 'INNER JOIN', 'p.product_brand_id = b.brand_id', 'b');
        $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT OUTER JOIN', 'b.brand_id = b_l.brandlang_brand_id  AND brandlang_lang_id = ' . $this->siteLangId, 'b_l');
        $srch->addCondition('selprod_user_id', '=', $userId);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addOrder('selprod_active', 'DESC');
        $srch->addOrder('product_name');
        $srch->addMultipleFields(
            array(
                'selprod_id', 'selprod_user_id', 'selprod_cost', 'selprod_price', 'selprod_stock', 'selprod_product_id', 'selprod_sku',
                'selprod_active', 'selprod_available_from', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'b_l.brand_name'
            )
        );

        if ($keyword = FatApp::getPostedData('keyword')) {
            $cnd = $srch->addCondition('product_name', 'like', "%$keyword%");
            $cnd->attachCondition('selprod_title', 'LIKE', "%$keyword%");
            $cnd->attachCondition('brand_name', 'LIKE', "%$keyword%");
        }

        if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel('LBL_Product', $this->siteLangId), Labels::getLabel('LBL_Custom_Title(If_Any)', $this->siteLangId), Labels::getLabel('LBL_Product_SKU', $this->siteLangId), Labels::getLabel('LBL_Brand', $this->siteLangId), Labels::getLabel('LBL_Stock_Quantity', $this->siteLangId));
            array_push($sheetData, $arr);
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = array($row['product_name'], $row['selprod_title'], $row['selprod_sku'], $row['brand_name'], $row['selprod_stock']);
                array_push($sheetData, $arr);
            }
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Products_Inventory_Report', $this->siteLangId) . date("Y-m-d") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arrListing = FatApp::getDb()->fetchAll($rs);

            if (count($arrListing)) {
                foreach ($arrListing as &$arr) {
                    $arr['options'] = SellerProduct::getSellerProductOptions($arr['selprod_id'], true, $this->siteLangId);
                }
            }

            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('pageCount', $srch->pages());
            $this->set('postedData', $post);
            $this->set('recordCount', $srch->recordCount());
            $this->set('arrListing', $arrListing);
            $this->_template->render(false, false);
        }
    }

    public function exportProductsInventoryReport()
    {
        $this->searchProductsInventory("export");
    }

    public function productsInventoryStockStatus()
    {
        $this->userPrivilege->canViewInventoryReport(UserAuthentication::getLoggedUserId());
        if (!User::canAccessSupplierDashboard()) {
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'supplierApprovalForm'));
        }
        $frmSrch = $this->getProductInventoryStockStatusSearchForm($this->siteLangId);
        $this->set('frmSrch', $frmSrch);
        $this->_template->render(true, true);
    }

    public function searchProductsInventoryStockStatus($export = "")
    {
        if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $post = FatApp::getPostedData();
        $pageSize = FatApp::getConfig('CONF_PAGE_SIZE');
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        if ($page < 2) {
            $page = 1;
        }

        $userId = $this->userParentId;

        /* [ */
        $orderProductSrch = new OrderProductSearch($this->siteLangId, true);
        $orderProductSrch->joinPaymentMethod();
        $orderProductSrch->doNotCalculateRecords();
        $orderProductSrch->doNotLimitRecords();
        $orderProductSrch->addStatusCondition(unserialize(FatApp::getConfig("CONF_PRODUCT_IS_ON_ORDER_STATUSES")));
        $cnd = $orderProductSrch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $cnd->attachCondition('pm.plugin_code', '=', 'CashOnDelivery');
        $orderProductSrch->addCondition('op.op_is_batch', '=', 0);
        $orderProductSrch->addMultipleFields(array('op.op_selprod_id', 'SUM(op_qty) as stock_on_order', 'op_selprod_options'));
        $orderProductSrch->addGroupBy('op.op_selprod_id');
        /* ] */

        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable('(' . $orderProductSrch->getQuery() . ')', 'INNER JOIN', 'sp.selprod_id = qryop.op_selprod_id', 'qryop');
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(Brand::DB_TBL, 'INNER JOIN', 'p.product_brand_id = b.brand_id', 'b');
        $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT OUTER JOIN', 'b.brand_id = b_l.brandlang_brand_id  AND brandlang_lang_id = ' . $this->siteLangId, 'b_l');
        $srch->addCondition('selprod_user_id', '=', $userId);
        $srch->addOrder('selprod_active', 'DESC');
        $srch->addOrder('product_name');
        $srch->addMultipleFields(
            array(
                'selprod_id', 'selprod_user_id', 'selprod_cost', 'selprod_price', 'selprod_stock', 'selprod_product_id',
                'selprod_active', 'selprod_available_from', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'selprod_sku',
                'b_l.brand_name', 'IFNULL(qryop.stock_on_order, 0) as stock_on_order'
            )
        );

        if ($keyword = FatApp::getPostedData('keyword')) {
            $cnd = $srch->addCondition('product_name', 'like', "%$keyword%");
            $cnd->attachCondition('selprod_title', 'LIKE', "%$keyword%");
            $cnd->attachCondition('brand_name', 'LIKE', "%$keyword%");
        }

        if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel('LBL_Product', $this->siteLangId), Labels::getLabel('LBL_Custom_title(if_any)', $this->siteLangId), Labels::getLabel('LBL_Brand', $this->siteLangId), Labels::getLabel('LBL_Stock_Available', $this->siteLangId), Labels::getLabel('LBL_Stock_on_order', $this->siteLangId), Labels::getLabel('LBL_Unit_Price', $this->siteLangId), Labels::getLabel('LBL_Total_Value(Stock_Available*unit_Price)', $this->siteLangId));
            array_push($sheetData, $arr);
            /* while( $row = FatApp::getDb()->fetch($rs) ){
            $arr = array( $row['product_name'], $row['selprod_title'], $row['brand_name'], $row['selprod_stock'] );
            array_push($sheetData,$arr);
            } */
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Products_Inventory_Report', $this->siteLangId) . date("Y-m-d") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arrListing = FatApp::getDb()->fetchAll($rs);
            if (count($arrListing)) {
                foreach ($arrListing as &$arr) {
                    $arr['options'] = SellerProduct::getSellerProductOptions($arr['selprod_id'], true, $this->siteLangId);
                }
            }
            $this->set('arrListing', $arrListing);
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('pageCount', $srch->pages());
            $this->set('postedData', $post);
            $this->set('recordCount', $srch->recordCount());
            $this->_template->render(false, false);
        }
    }

    public function exportProductsInventoryStockStatusReport()
    {
        $this->searchProductsInventoryStockStatus("export");
    }

    private function getProductInventorySearchForm($langId)
    {
        $frm = new Form('frmProductInventorySrch');
        $frm->addTextBox('', 'keyword', '');
        $frm->addHiddenField('', 'page');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $langId));
        $frm->addButton("", "btn_clear", Labels::getLabel("LBL_Clear", $langId), array('onclick' => 'clearSearch();'));
        return $frm;
    }

    private function getProductInventoryStockStatusSearchForm($langId)
    {
        $frm = new Form('frmProductInventoryStockStatusSrch');
        $frm->addTextBox('', 'keyword', '');
        $frm->addHiddenField('', 'page');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $langId));
        $frm->addButton("", "btn_clear", Labels::getLabel("LBL_Clear", $langId), array('onclick' => 'clearSearch();'));
        return $frm;
    }

    private function getProdPerformanceSrchForm()
    {
        $frm = new Form('frmProdPerformanceSrch');
        //$frm->addHiddenField('','order_by');
        return $frm;
    }


    public function salesReport($orderDate = '')
    {
        $this->userPrivilege->canViewSalesReport(UserAuthentication::getLoggedUserId());
        if (!User::canAccessSupplierDashboard()) {
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'supplierApprovalForm'));
        }
        $flds = $this->getFormColumns($orderDate);
        $frmSrch = $this->getSalesReportSearchForm($flds, $orderDate);
        $this->set('frmSrch', $frmSrch);
        $this->set('orderDate', $orderDate);
        $this->_template->render(true, true);
    }

    public function searchSalesReport($export = "")
    {
        if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $orderDate = FatApp::getPostedData('orderDate', FatUtility::VAR_STRING, '');
        $fields = $this->getFormColumns($orderDate);
        $srchFrm = $this->getSalesReportSearchForm($fields, $orderDate);
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $pageSize = FatApp::getConfig('CONF_PAGE_SIZE');
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        if ($page < 2) {
            $page = 1;
        }
        $userId = UserAuthentication::getLoggedUserId();
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'orderDate');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'ASC');

        $srch = new Report(0, array_keys($fields), true);
        $srch->joinOrders();
        $srch->joinPaymentMethod();
        $srch->joinOtherCharges(true);
        $srch->joinOrderProductTaxCharges();
        $srch->joinOrderProductShipCharges();
        $srch->joinOrderProductDicountCharges();
        $srch->joinOrderProductVolumeCharges();
        $srch->joinOrderProductRewardCharges();
        $srch->setPaymentStatusCondition();
        $srch->setCompletedOrdersCondition();
        $srch->excludeDeletedOrdersCondition();
        $fromDate = $toDate = $orderDate;
        if (empty($orderDate)) {
            $fromDate = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
            $toDate = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
            $srch->setGroupBy('orderDate');
            $srch->addTotalOrdersCount('order_date_added', $userId);
            $srch->addFld('totOrders');
        } else {
            $this->set('orderDate', $orderDate);
            $srch->setGroupBy('op_invoice_number');
            $srch->addFld('op_invoice_number');
        }

        $srch->setOrderBy($sortBy, $sortOrder);
        $srch->setDateCondition($fromDate, $toDate);
        $srch->addCondition('op_selprod_user_id', '=', $userId);

        if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            array_push($sheetData, array_values($fields));
            $count = 1;
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'listserial':
                            $arr[] = $count;
                            break;
                        case 'orderDate':
                            $arr[] = FatDate::format($row['orderDate']);
                            break;
                        case 'grossSales':
                        case 'transactionAmount':
                        case 'inventoryValue':
                        case 'adminTaxTotal':
                        case 'sellerTaxTotal':
                        case 'sellerShippingTotal':
                        case 'volumeDiscount':
                        case 'refundedAmount':
                        case 'refundedShippingFromSeller':
                        case 'refundedTaxFromSeller':
                        case 'orderNetAmount':
                        case 'commissionCharged':
                        case 'refundedCommission':
                        case 'adminSalesEarnings':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true, false);
                            break;
                        default:
                            $arr[] = $row[$key];
                            break;
                    }
                }

                array_push($sheetData, $arr);
                $count++;
            }
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Sales_Report', $this->siteLangId) . date("Y-m-d") . '.csv', ',');
            exit;
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();

        $arrListing = FatApp::getDb()->fetchAll($rs);
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', $post);
        $this->set('recordCount', $srch->recordCount());
        $this->set('arrListing', $arrListing);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->_template->render(false, false);
    }

    public function exportSalesReport()
    {
        $this->searchSalesReport("export");
    }

    private function getSalesReportSearchForm($fields = [], $orderDate = '')
    {
        $frm = new Form('frmSalesReportSrch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'orderDate', $orderDate);
        if (empty($orderDate)) {
            $frm->addDateField('', 'date_from', '', array('placeholder' => Labels::getLabel('LBL_Date_From', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
            $frm->addDateField('', 'date_to', '', array('placeholder' => Labels::getLabel('LBL_Date_To', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        }

        if (!empty($fields)) {
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->siteLangId), 'sortBy', $fields, '', array(), '');

            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->siteLangId), 'sortOrder', applicationConstants::sortOrder($this->siteLangId), 0, array(),  '');
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear', $this->siteLangId), array('onclick' => 'clearSearch();'));
        return $frm;
    }

    private function getFormColumns($orderDate = '')
    {
        $shopsReportCacheVar = FatCache::get('shopsReportCacheVar' . $this->userParentId . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$shopsReportCacheVar) {
            $arr = [
                'orderDate' => Labels::getLabel('LBL_Date', $this->siteLangId),
                'totOrders' => Labels::getLabel('LBL_Order_Placed', $this->siteLangId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->siteLangId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->siteLangId),
                'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $this->siteLangId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $this->siteLangId),
                'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->siteLangId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $this->siteLangId),

                // 'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->siteLangId),
                'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->siteLangId),
                // 'adminTaxTotal' => Labels::getLabel('LBL_Tax_Charged_by_Admin', $this->siteLangId),

                // 'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->siteLangId),
                'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->siteLangId),
                // 'adminShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_by_Admin', $this->siteLangId),

                // 'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $this->siteLangId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $this->siteLangId),
                // 'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->siteLangId),

                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->siteLangId),
                // 'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $this->siteLangId),
                'refundedShippingFromSeller' => Labels::getLabel('LBL_Refunded_Shipping', $this->siteLangId),
                // 'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $this->siteLangId),
                'refundedTaxFromSeller' => Labels::getLabel('LBL_Refunded_Tax', $this->siteLangId),

                'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->siteLangId),

                'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $this->siteLangId),
                'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $this->siteLangId),
                'adminSalesEarnings' => Labels::getLabel('LBL_Admin_Earnings', $this->siteLangId),
            ];
            FatCache::set('shopsReportCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($shopsReportCacheVar);
        }

        if (!empty($orderDate)) {
            unset($arr['orderDate']);
            unset($arr['totOrders']);
            $arr = ['op_invoice_number' => Labels::getLabel('LBL_invoice_number', $this->siteLangId)] + $arr;
        }

        return $arr;
    }
}
