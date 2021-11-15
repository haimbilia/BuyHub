<?php

class CatalogReportController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewCatalogReport();
    }

    public function index()
    {
        $formColumns = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($formColumns);
        $pageData = PageLanguageData::getAttributesByKey('SALES_REPORT', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($formColumns);
        $actionItemsData = array_merge($actionItemsData, [
            'newRecordBtn' => false,
            'formColumns' => $formColumns,
            'columnButtons' => true,
            'defaultColumns' => $this->getDefaultColumns(),
            'searchFrmTemplate' => 'catalog-report/search-form.php'
        ]);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('frmSearch', $frmSearch);
        $this->set('actionItemsData', $actionItemsData);
        $this->getListingData(false);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->getListingData($type);
        $jsonData = [
            'headSection' => $this->_template->render(false, false, '_partial/listing/head-section.php', true),
            'listingHtml' => $this->_template->render(false, false, 'catalog-report/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData($type = false)
    {
        $db = FatApp::getDb();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('listingColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $srchFrm = $this->getSearchForm($fields);
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

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
        $opSrch->addTotalOrdersCount('product_id');
        $opSrch->setGroupBy('product_id');
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->removeFld(['product_name', 'product_type', 'prodcat_name']);
        /* ] */

        $selectedFlds = ['p.product_id', 'IFNULL(tp_l.product_name,p.product_identifier) as product_name', 'p.product_type', 'IFNULL(tb_l.brand_name, brand_identifier) as brand_name', 'IFNULL(c_l.prodcat_name,c.prodcat_identifier) as prodcat_name', 'opq.*'];
        $srch = new ProductSearch($this->siteLangId, '', '', false, false, false);
        $srch->joinBrands($this->siteLangId, false, true);
        $srch->joinProductToCategory($this->siteLangId);
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'INNER JOIN', 'p.product_id = opq.product_id', 'opq');
        $srch->addMultipleFields($selectedFlds);
        $srch->addGroupBy('p.product_id');

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING);
        if (!empty($keyword)) {
            $srch->addCondition('product_name', 'LIKE', '%' . $keyword . '%');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        switch ($sortBy) {
            default:
                $srch->addOrder($sortBy, $sortOrder);
                break;
        }

        $productTypeArr = Product::getProductTypes($this->siteLangId);

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
                            $name = $row['product_name'] . '(' . $row['brand_name'] . ')';
                            $arr[] = $name;
                            break;
                        case 'product_type':
                            $arr[] = $productTypeArr[$row[$key]];
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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Catalog_Report', $this->siteLangId) . ' ' . date("d-M-Y") . '.csv', ',');

            exit;
        }

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
        $this->set('productTypeArr', $productTypeArr);
        $this->set('allowedKeysForSorting', array_keys($fields));
    }

    public function export()
    {
        $this->search('export');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'orderDate', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns()
    {
        $catalogReportCacheVar = FatCache::get('catalogReportCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$catalogReportCacheVar) {
            $arr = [
                'product_name'    =>    Labels::getLabel('LBL_Product', $this->siteLangId),
                'product_type'    =>    Labels::getLabel('LBL_Product_Type', $this->siteLangId),
                'prodcat_name'    =>    Labels::getLabel('LBL_Category', $this->siteLangId),
                'totOrders' => Labels::getLabel('LBL_No._of_Orders', $this->siteLangId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->siteLangId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->siteLangId),
                'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $this->siteLangId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $this->siteLangId),
                'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->siteLangId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $this->siteLangId),

                'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->siteLangId),
                'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged_By_Seller', $this->siteLangId),
                'adminTaxTotal' => Labels::getLabel('LBL_Tax_Charged_by_Admin', $this->siteLangId),

                'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->siteLangId),
                'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_By_Seller', $this->siteLangId),
                'adminShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_by_Admin', $this->siteLangId),

                'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $this->siteLangId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $this->siteLangId),
                'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->siteLangId),

                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->siteLangId),
                'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $this->siteLangId),
                'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $this->siteLangId),

                'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->siteLangId),

                'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $this->siteLangId),
                'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $this->siteLangId),
                'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $this->siteLangId)
            ];
            FatCache::set('catalogReportCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($catalogReportCacheVar);
        }

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return ['product_name', 'product_type', 'prodcat_name', 'netSoldQty', 'grossSales', 'couponDiscount', 'refundedAmount', 'taxTotal', 'shippingTotal', 'orderNetAmount'];
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_PRODUCT_SALES_REPORT', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
