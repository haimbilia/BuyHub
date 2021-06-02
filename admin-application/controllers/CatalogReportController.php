<?php

class CatalogReportController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewCatalogReport($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditCatalogReport($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewCatalogReport();
        $flds = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($flds);
        $frmSearch->fill(['sortBy' => 'totOrders', 'sortOrder' => 'DESC']);
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->objPrivilege->canViewProductsReport();
        $db = FatApp::getDb();
        $fields = $this->getFormColumns();
        $srchFrm = $this->getSearchForm($fields);
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'totOrders');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'DESC');

        /* get Seller Order Products[ */
        /* $fields = ['totOrders',  'totQtys', 'totRefundedQtys', 'netSoldQty', 'grossSales', 'transactionAmount', 'inventoryValue', 'taxTotal', 'sellerTaxTotal', 'adminTaxTotal', 'shippingTotal', 'sellerShippingTotal', 'adminShippingTotal', 'couponDiscount', 'volumeDiscount', 'rewardDiscount', 'adminSalesEarnings', 'refundedAmount', 'refundedShipping', 'refundedTax', 'commissionCharged', 'refundedCommission', 'refundedAffiliateCommission', 'orderNetAmount']; */
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
        $opSrch->removeFld('product_name');
        // echo  $opSrch->getQuery(); exit;
        /* ] */

        $selectedFlds = ['p.product_id', 'IFNULL(tp_l.product_name,p.product_identifier) as product_name', 'IFNULL(tb_l.brand_name, brand_identifier) as brand_name', 'opq.*'];
        $srch = new ProductSearch($this->adminLangId, '', '', false, false, false);
        $srch->joinBrands($this->adminLangId, false, true);
        $srch->joinProductToCategory();
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'INNER JOIN', 'p.product_id = opq.product_id', 'opq');
        $srch->addMultipleFields($selectedFlds);
        $srch->addGroupBy('p.product_id');

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING);
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

            CommonHelper::convertToCsv($sheetData, 'Catalog_Report_' . date("d-M-Y") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arr_listing = $db->fetchAll($rs);
            $this->set("arr_listing", $arr_listing);
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
        $frm = new Form('frmCatalogReportSearch');
        $frm->addHiddenField('', 'page', 1);

        if (!empty($fields)) {
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');

            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  '');
        }

        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getFormColumns()
    {
        $catalogReportCacheVar = FatCache::get('catalogReportCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$catalogReportCacheVar) {
            $arr = [
                'product_name'    =>    Labels::getLabel('LBL_Product', $this->adminLangId),
                'totOrders' => Labels::getLabel('LBL_No._of_Orders', $this->adminLangId),
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
            FatCache::set('catalogReportCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($catalogReportCacheVar);
        }

        return $arr;
    }
}
