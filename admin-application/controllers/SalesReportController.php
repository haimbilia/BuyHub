<?php

class SalesReportController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewSalesReport($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditSalesReport($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index($orderDate = '')
    {
        $this->objPrivilege->canViewSalesReport();

        $frmSearch = $this->getSearchForm($orderDate);
        //$frmSearch->fill(array('orderDate'=>$orderDate));

        $this->set('frmSearch', $frmSearch);
        $this->set('orderDate', $orderDate);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewSalesReport();
        $db = FatApp::getDb();
        $orderDate = FatApp::getPostedData('orderDate');

        $srchFrm = $this->getSearchForm($orderDate);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);


        $fields = ['orderDate',  'totQtys', 'totRefundedQtys', 'netSoldQty', 'grossSales', 'transactionAmount', 'inventoryValue', 'taxTotal', 'sellerTaxTotal', 'adminTaxTotal', 'shippingTotal', 'sellerShippingTotal', 'adminShippingTotal', 'couponDiscount', 'volumeDiscount', 'rewardDiscount', 'adminSalesEarnings', 'refundedAmount', 'refundedShipping', 'refundedTax', 'commissionCharged', 'refundedCommission', 'refundedAffiliateCommission', 'orderNetAmount'];
        $srch = new Report(0, $fields);
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
            $this->set('orderDate', $orderDate);
            $srch->setGroupBy('op_invoice_number');
            $srch->addFld('op_invoice_number');
        }

        $srch->setDateCondition($fromDate, $toDate);
        $srch->addOrder('order_date', 'desc');

        // echo $srch->getQuery(); exit;

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetchAll($rs);

        $this->set("arr_listing", $arr_listing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function export()
    {
        $this->objPrivilege->canViewSalesReport();
        $db = FatApp::getDb();
        $orderDate = FatApp::getPostedData('orderDate', FatUtility::VAR_DATE, '');

        $srchFrm = $this->getSearchForm($orderDate);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $fields = ['orderDate',  'totQtys', 'totRefundedQtys', 'netSoldQty', 'grossSales', 'transactionAmount', 'inventoryValue', 'taxTotal', 'sellerTaxTotal', 'adminTaxTotal', 'shippingTotal', 'sellerShippingTotal', 'adminShippingTotal', 'couponDiscount', 'volumeDiscount', 'rewardDiscount', 'adminSalesEarnings', 'refundedAmount', 'refundedShipping', 'refundedTax', 'commissionCharged', 'refundedCommission', 'refundedAffiliateCommission', 'orderNetAmount'];
        $srch = new Report(0, $fields);
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
            $this->set('orderDate', $orderDate);
            $srch->setGroupBy('op_invoice_number');
            $srch->addFld('op_invoice_number');
        }

        $srch->setDateCondition($fromDate, $toDate);
        $srch->addOrder('order_date', 'desc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        //echo $srch->getQuery();
        $rs = $srch->getResultSet();
        //$arr_listing = $db->fetchAll($rs);

        $sheetData = array();
        $arrFlds1 = array(
            'listserial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'order_date' => Labels::getLabel('LBL_Date', $this->adminLangId),
            'totOrders' => Labels::getLabel('LBL_Order_Placed', $this->adminLangId),
            /*  'orderNetAmount' => Labels::getLabel('LBL_Order_Net_Amount', $this->adminLangId), */
        );
        $arrFlds2  = array(
            'listserial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'op_invoice_number' => Labels::getLabel('LBL_Invoice_Number', $this->adminLangId),
            /* 'order_net_amount' => Labels::getLabel('LBL_Order_Net_Amount', $this->adminLangId), */
        );
        $arr = array(
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
        );
        if (empty($orderDate)) {
            $arr_flds = array_merge($arrFlds1, $arr);
        } else {
            $arr_flds = array_merge($arrFlds2, $arr);
        }

        array_push($sheetData, array_values($arr_flds));

        $count = 1;
        while ($row = $db->fetch($rs)) {
            $arr = [];
            foreach ($arr_flds as $key => $val) {
                switch ($key) {
                    case 'listserial':
                        $arr[] = $count;
                        break;
                    case 'listserial':
                        $arr[] = FatDate::format($row['order_date']);
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
                        $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true);
                        break;
                    default:
                        $arr[] = $row[$key];
                        break;
                }
            }

            array_push($sheetData, $arr);
            $count++;
        }

        CommonHelper::convertToCsv($sheetData, 'Sales_Report_' . date("d-M-Y") . '.csv', ',');
        exit;
    }

    private function getSearchForm($orderDate = '')
    {
        $frm = new Form('frmSalesReportSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'orderDate', $orderDate);
        if (empty($orderDate)) {
            $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
            $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
            $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
            $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
            $fld_submit->attachField($fld_cancel);
        }
        return $frm;
    }
}
