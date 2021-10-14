<?php

class SalesReportController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSalesReport();
    }

    public function index($orderDate = '')
    {

        $fields = $this->getFormColumns($orderDate);
        $frmSearch = $this->getSearchForm($fields, $orderDate);
        $this->set('frmSearch', $frmSearch);
        $this->set('orderDate', $orderDate);
        $this->set('defaultColumns', $this->getDefaultColumns($orderDate));
        $this->set('fields', $fields);
        $this->_template->addJs('js/report.js');
        $this->_template->render();
    }

    public function search($type = false)
    {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();

        $orderDate = FatApp::getPostedData('orderDate');

        $fields = $this->getFormColumns($orderDate);
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns($orderDate) : $this->getDefaultColumns($orderDate);
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields, $orderDate);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $srch = new Report(0, array_keys($fields));
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
            $srch->addTotalOrdersCount('order_date_added');
            $srch->addFld('totOrders');
        } else {
            $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
            if (!empty($keyword)) {
                $cnd = $srch->addCondition('op_invoice_number', 'like', '%' . $keyword . '%');
                $cnd->attachCondition('order_id', 'like', '%' . $keyword . '%');
            }

            $this->set('orderDate', $orderDate);
            $srch->setGroupBy('op_invoice_number');
            $srch->addFld('op_invoice_number');
        }

        $srch->setOrderBy($sortBy, $sortOrder);
        $srch->setDateCondition($fromDate, $toDate);

        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();

            array_push($sheetData, array_values($fields));

            $count = 1;
            while ($row = $db->fetch($rs)) {
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
                $count++;
            }

            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Sales_Report', $this->siteLangId) . date("d-M-Y") . '.csv', ',');
            exit;
        }


        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->_template->render(false, false);
    }

    public function getSearchForm($fields = [], $orderDate = '')
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'orderDate', $orderDate);

        if (empty($orderDate)) {
            $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
            $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        } else {
            $frm->addTextBox(Labels::getLabel("LBL_Keyword", $this->siteLangId), 'keyword');
        }

        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'orderDate');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_DESC);
            $frm->addHiddenField('', 'reportColumns', '');
            /* $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->siteLangId), 'sortBy', $fields, '', array(), '');
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->siteLangId), 'sortOrder', applicationConstants::sortOrder($this->siteLangId), 0, array(),  ''); */
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getFormColumns($orderDate = '')
    {
        $salesReportCacheVar = FatCache::get('salesReportCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$salesReportCacheVar) {
            $arr = [
                'orderDate' => Labels::getLabel('LBL_Date', $this->siteLangId),
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
            FatCache::set('salesReportCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($salesReportCacheVar);
        }

        if (!empty($orderDate)) {
            unset($arr['orderDate']);
            $arr = [
                'op_invoice_number' => Labels::getLabel('LBL_invoice_number', $this->siteLangId),
                'order_date_added' => Labels::getLabel('LBL_Date', $this->siteLangId),
            ] + $arr;
        }

        return $arr;
    }

    private function getDefaultColumns($orderDate = ''): array
    {
        $arr = ['orderDate', 'totQtys', 'grossSales', 'couponDiscount', 'refundedAmount', 'shippingTotal', 'taxTotal', 'orderNetAmount'];
        if (!empty($orderDate)) {
            unset($arr['orderDate']);
            $arr = [
                'op_invoice_number',
                'order_date_added'
            ] + $arr;
        }
        return $arr;
    }
}
