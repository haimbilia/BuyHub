<?php

class ProductsReportController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewProductsReport();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('frmSearch', $frmSearch);
        $this->set('fields', $fields);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $db = FatApp::getDb();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }

        $srchFrm = $this->getSearchForm($fields);
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        /* get Seller Order Products[ */
        $opSrch = new Report(0, array_keys($fields));
        $opSrch->joinOrders();
        $opSrch->joinPaymentMethod();
        $opSrch->joinOtherCharges(true);
        $opSrch->joinOrderProductTaxCharges();
        $opSrch->joinOrderProductShipCharges();
        $opSrch->joinOrderProductDicountCharges();
        $opSrch->joinOrderProductVolumeCharges();
        $opSrch->joinOrderProductRewardCharges();
        $opSrch->setPaymentStatusCondition();
        $opSrch->setCompletedOrdersCondition();
        $opSrch->excludeDeletedOrdersCondition();
        $opSrch->addTotalOrdersCount('selprod_id');
        $opSrch->setGroupBy('selprod_id');
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->removeFld(['product_name', 'followers', 'selprod_price']);
        /* ] */


        /* get Seller product Options[ */
        $spOptionSrch = new SearchBase(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'spo');
        $spOptionSrch->joinTable(OptionValue::DB_TBL, 'INNER JOIN', 'spo.selprodoption_optionvalue_id = ov.optionvalue_id', 'ov');
        $spOptionSrch->joinTable(OptionValue::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'ov_lang.optionvaluelang_optionvalue_id = ov.optionvalue_id AND ov_lang.optionvaluelang_lang_id = ' . $this->adminLangId, 'ov_lang');
        $spOptionSrch->joinTable(Option::DB_TBL, 'INNER JOIN', '`option`.option_id = ov.optionvalue_option_id', '`option`');
        $spOptionSrch->joinTable(Option::DB_TBL . '_lang', 'LEFT OUTER JOIN', '`option`.option_id = option_lang.optionlang_option_id AND option_lang.optionlang_lang_id = ' . $this->adminLangId, 'option_lang');
        $spOptionSrch->doNotCalculateRecords();
        $spOptionSrch->doNotLimitRecords();
        $spOptionSrch->addGroupBy('spo.selprodoption_selprod_id');
        $spOptionSrch->addMultipleFields(array('spo.selprodoption_selprod_id', 'IFNULL(option_name, option_identifier) as option_name', 'IFNULL(optionvalue_name, optionvalue_identifier) as optionvalue_name', 'GROUP_CONCAT(option_name) as grouped_option_name', 'GROUP_CONCAT(optionvalue_name) as grouped_optionvalue_name'));
        /* ] */

        /* Sub Query to get, how many users added current product in his/her wishlist[ */
        $uWsrch = new UserWishListProductSearch($this->adminLangId);
        $uWsrch->doNotCalculateRecords();
        $uWsrch->doNotLimitRecords();
        $uWsrch->joinWishLists();
        $uWsrch->addMultipleFields(array('uwlp_selprod_id', 'uwlist_user_id'));
        /* ] */

        $srch = new ProductSearch($this->adminLangId, '', '', false, false, false);
        $srch->joinTable(SellerProduct::DB_TBL, 'LEFT OUTER JOIN', 'p.product_id = selprod.selprod_product_id', 'selprod');
        $srch->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT OUTER JOIN', 'selprod.selprod_id = sprod_l.selprodlang_selprod_id AND sprod_l.selprodlang_lang_id = ' . $this->adminLangId, 'sprod_l');
        $srch->joinSellers();
        $srch->joinBrands($this->adminLangId, false, true);
        //$srch->addCondition('brand_id', '!=', 'NULL');
        $srch->joinShops($this->adminLangId, false, false);
        $srch->joinTable('(' . $spOptionSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'selprod_id = spoq.selprodoption_selprod_id', 'spoq');
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'selprod.selprod_id = opq.op_selprod_id', 'opq');
        $srch->joinTable('(' . $uWsrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tquwl.uwlp_selprod_id = selprod.selprod_id', 'tquwl');
        $srch->joinProductToCategory();
        $srch->addCondition('selprod.selprod_id', '!=', 'NULL');
        $srch->addMultipleFields(array('product_id', 'product_name', 'selprod_id', 'selprod_code', 'selprod_user_id', 'selprod_title', 'selprod_price', /* 'IFNULL(totOrders, 0) as totOrders', */ 'grouped_option_name', 'grouped_optionvalue_name', 'IFNULL(s_l.shop_name, shop_identifier) as shop_name', 'IFNULL(tb_l.brand_name, brand_identifier) as brand_name', 'count(distinct tquwl.uwlist_user_id) as followers', 'opq.*'));

        /* groupby added, because if same product is linked with multiple categories, then showing in repeat for each category[ */
        $srch->addGroupBy('selprod_id');
        /* ] */

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder(CommonHelper::getLangId()))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        switch ($sortBy) {
            default:
                $srch->addOrder($sortBy, $sortOrder);
                break;
        }

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING);
        if (!empty($keyword)) {
            $srch->addKeywordSearch($keyword);
        }

        $shop_id = FatApp::getPostedData('shop_id', null, '');
        if ($shop_id) {
            $shop_id = FatUtility::int($shop_id);
            $srch->addShopIdCondition($shop_id);
        }

        $brand_id = FatApp::getPostedData('brand_id', null, '');
        if ($brand_id) {
            $brand_id = FatUtility::int($brand_id);
            $srch->addBrandCondition($brand_id);
        }

        $category_id = FatApp::getPostedData('category_id', null, '');
        if ($category_id) {
            $category_id = FatUtility::int($category_id);
            $srch->addCategoryCondition($category_id);
        }

        $price_from = FatApp::getPostedData('price_from', null, '');
        if (!empty($price_from)) {
            $min_price_range_default_currency = CommonHelper::getDefaultCurrencyValue($price_from, false, false);
            $srch->addCondition('selprod_price', '>=', $min_price_range_default_currency);
        }

        $price_to = FatApp::getPostedData('price_to', null, '');
        if (!empty($price_to)) {
            $max_price_range_default_currency = CommonHelper::getDefaultCurrencyValue($price_to, false, false);
            $srch->addCondition('selprod_price', '<=', $max_price_range_default_currency);
        }

        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();

            array_push($sheetData, array_values($fields));
            while ($row = $db->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'product_name':
                            $name =  Labels::getLabel('LBL_Catalog_Name', $this->adminLangId) . ": " . $row['product_name'];
                            if ($row['selprod_title'] != '') {
                                $name .= "\n" . Labels::getLabel('LBL_Custom_Title', $this->adminLangId) . ':' . $row['selprod_title'];
                            }
                            if ($row['grouped_option_name'] != '') {
                                $groupedOptionNameArr = explode(',', $row['grouped_option_name']);
                                $groupedOptionValueArr = explode(',', $row['grouped_optionvalue_name']);
                                if (!empty($groupedOptionNameArr)) {
                                    foreach ($groupedOptionNameArr as $key => $optionName) {
                                        $name .= "\n" . $optionName . ':</strong> ' . $groupedOptionValueArr[$key];
                                    }
                                }
                            }

                            if ($row['brand_name'] != '') {
                                $name .= "\n" . Labels::getLabel('LBL_Brand', $this->adminLangId) . ": " . $row['brand_name'];
                            }

                            if ($row['shop_name'] != '') {
                                $name .= "\n" . Labels::getLabel('LBL_Sold_By', $this->adminLangId) . ': ' . $row['shop_name'];
                            }
                            $arr[] = html_entity_decode($name, ENT_QUOTES, 'utf-8');
                            break;
                        case 'grossSales':
                        case 'transactionAmount':
                        case 'inventoryValue':
                        case 'taxTotal':
                        case 'adminTaxTotal':
                        case 'sellerTaxTotal':
                        case 'shippingTotal':
                        case 'sellerShippingTotal':
                        case 'adminShippingTotal':
                        case 'discountTotal':
                        case 'couponDiscount':
                        case 'volumeDiscount':
                        case 'rewardDiscount':
                        case 'refundedAmount':
                        case 'refundedShipping':
                        case 'refundedTax':
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
            }

            CommonHelper::convertToCsv($sheetData, 'Products_Report_' . date("d-M-Y") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arrListing = $db->fetchAll($rs);
            $this->set("arrListing", $arrListing);
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('postedData', $post);
            $this->set('sortBy', $sortBy);
            $this->set('sortOrder', $sortOrder);
            $this->set('fields', $fields);
            $this->_template->render(false, false);
        }
    }

    public function export()
    {
        $this->search('export');
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmProductsReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $frm->addTextBox(Labels::getLabel('LBL_Shop', $this->adminLangId), 'shop_name');
        $frm->addTextBox(Labels::getLabel('LBL_Brand', $this->adminLangId), 'brand_name');
        $frm->addHiddenField('', 'shop_id', 0);
        $frm->addHiddenField('', 'brand_id', 0);

        $prodCatObj = new ProductCategory();
        $categoriesAssocArr = $prodCatObj->getProdCatTreeStructure(0, $this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Category', $this->adminLangId), 'category_id', $categoriesAssocArr, '', [], Labels::getLabel('LBL_Select', $this->adminLangId));

        $frm->addTextBox(Labels::getLabel('LBL_Price_From', $this->adminLangId), 'price_from');
        $frm->addTextBox(Labels::getLabel('LBL_Price_To', $this->adminLangId), 'price_to');

        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'product_name');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_ASC);
            $frm->addHiddenField('', 'reportColumns', '');
            /* $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  ''); */
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getFormColumns()
    {
        $productReportCacheVar = FatCache::get('productReportCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$productReportCacheVar) {
            $arr = [
                'product_name'    =>    Labels::getLabel('LBL_Product_name', $this->adminLangId),
                /* 'selprod_title' =>  Labels::getLabel('LBL_Custom_Title', $this->adminLangId),
                'brand_name' => Labels::getLabel('LBL_Brand', $this->adminLangId),
                'shop_name' => Labels::getLabel('LBL_Sold_By', $this->adminLangId), */
                'followers'    =>    Labels::getLabel('LBL_Favorites', $this->adminLangId),
                'selprod_price'    =>    Labels::getLabel('LBL_Unit_Price', $this->adminLangId),
                'totOrders' => Labels::getLabel('LBL_Order_Placed', $this->adminLangId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->adminLangId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->adminLangId),
                'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $this->adminLangId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $this->adminLangId),
                'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->adminLangId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $this->adminLangId),

                'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->adminLangId),
                'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged_By_Seller', $this->adminLangId),
                'adminTaxTotal' => Labels::getLabel('LBL_Tax_Charged_by_Admin', $this->adminLangId),

                'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->adminLangId),
                'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_By_Seller', $this->adminLangId),
                'adminShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_by_Admin', $this->adminLangId),

                'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $this->adminLangId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $this->adminLangId),
                'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->adminLangId),

                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->adminLangId),
                'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $this->adminLangId),
                'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $this->adminLangId),

                'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->adminLangId),

                'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $this->adminLangId),
                'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $this->adminLangId),
                'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $this->adminLangId)
            ];
            FatCache::set('productReportCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($productReportCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['product_name', 'netSoldQty', 'grossSales', 'couponDiscount', 'refundedAmount', 'taxTotal', 'shippingTotal', 'orderNetAmount'];
    }
}
