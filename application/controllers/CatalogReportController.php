<?php

class CatalogReportController extends SellerBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->userPrivilege->canViewCatalogReport(UserAuthentication::getLoggedUserId());
    }

    public function index()
    {
        $fields = $this->getFormColumns($this->siteLangId);
        $frmSearch = $this->getSearchForm($fields);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('fields', $fields);
        $this->_template->addJs('js/report.js');
        $this->_template->render();
    }

    public function search($type = false)
    {
        $db = FatApp::getDb();
        $fields = $this->getFormColumns($this->siteLangId);
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields);
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pageSize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');

        /* get Seller Order Products[ */
        $opSrch = new Report(0, array_keys($fields), true);
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
        $opSrch->addCondition('op.op_selprod_user_id', '=', $this->userParentId);

        // echo  $opSrch->getQuery(); exit;
        /* ] */

        $selectedFlds = ['p.product_id', 'IFNULL(tp_l.product_name,p.product_identifier) as product_name', 'p.product_type', 'IFNULL(tb_l.brand_name, brand_identifier) as brand_name', 'IFNULL(c_l.prodcat_name,c.prodcat_identifier) as prodcat_name', 'opq.*'];
        $srch = new ProductSearch($this->siteLangId, '', '', false, false, false);
        $srch->joinBrands($this->siteLangId, false, true);
        $srch->joinProductToCategory();
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'INNER JOIN', 'p.product_id = opq.product_id', 'opq');
        $srch->addMultipleFields($selectedFlds);
        $srch->addGroupBy('p.product_id');

        if (!empty($keyword)) {
            $srch->addCondition('product_name', 'LIKE', '%' . $keyword . '%');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder(CommonHelper::getLangId()))) {
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
                        case 'discountTotal':
                        case 'couponDiscount':
                        case 'volumeDiscount':
                        case 'rewardDiscount':
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
        $this->_template->render(false, false);
    }

    public function export()
    {
        $this->search("export");
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page');
        $frm->addTextBox('', 'keyword');
        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'product_name');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_ASC);
            $frm->addHiddenField('', 'reportColumns', '');
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear', $this->siteLangId), array('onclick' => 'clearSearch();'));
        return $frm;
    }

    private function getFormColumns(int $langId)
    {
        $sellerCatalogReportCacheVar = FatCache::get('sellerCatalogReportCacheVar' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$sellerCatalogReportCacheVar) {
            $arr = [
                'product_name'    =>    Labels::getLabel('LBL_Product', $langId),
                'totOrders' => Labels::getLabel('LBL_No._of_Orders', $langId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $langId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $langId),
                'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $langId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $langId),
                'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $langId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $langId),
                'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged_By_Seller', $langId),
                'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_By_Seller', $langId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $langId),
                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $langId),
                'refundedShippingFromSeller' => Labels::getLabel('LBL_Refunded_Shipping', $langId),
                'refundedTaxFromSeller' => Labels::getLabel('LBL_Refunded_Tax', $langId),
                'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $langId),
                'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $langId),
                'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $langId),
                'adminSalesEarnings' => Labels::getLabel('LBL_Admin_Earnings', $langId)
            ];
        } else {
            $arr =  unserialize($sellerCatalogReportCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['product_name', 'product_type', 'prodcat_name', 'netSoldQty', 'grossSales', 'couponDiscount', 'refundedAmount', 'taxTotal', 'shippingTotal', 'orderNetAmount'];
    }
}
