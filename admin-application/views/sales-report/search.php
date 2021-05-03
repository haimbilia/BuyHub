<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
/*Only one column allowed */
$staticFlds = ['order_date', 'op_invoice_number'];

$arrFlds1 = array(
    'order_date' => Labels::getLabel('LBL_Date', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'totOrders' => Labels::getLabel('LBL_Order_Placed', $adminLangId),
    /*  'orderNetAmount' => Labels::getLabel('LBL_Order_Net_Amount', $adminLangId), */
);
$arrFlds2  = array(
    'op_invoice_number' => Labels::getLabel('LBL_Invoice_Number', $adminLangId),
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    /* 'order_net_amount' => Labels::getLabel('LBL_Order_Net_Amount', $adminLangId), */
);
$arr = array(
    'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $adminLangId),
    'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $adminLangId),
    'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $adminLangId),
    'grossSales' => Labels::getLabel('LBL_Gross_Sale', $adminLangId),
    'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $adminLangId),
    'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $adminLangId),

    'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $adminLangId),
    'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged_By_Seller', $adminLangId),
    'adminTaxTotal' => Labels::getLabel('LBL_Tax_Charged_by_Admin', $adminLangId),

    'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $adminLangId),
    'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_By_Seller', $adminLangId),
    'adminShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_by_Admin', $adminLangId),

    'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $adminLangId),
    'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $adminLangId),
    'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $adminLangId),

    'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $adminLangId),
    'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $adminLangId),
    'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $adminLangId),

    'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $adminLangId),

    'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $adminLangId),
    'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $adminLangId),
    'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $adminLangId)
);
if (empty($orderDate)) {
    $arr_flds = array_merge($arrFlds1, $arr);
} else {
    $arr_flds = array_merge($arrFlds2, $arr);
}


$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'datatable__table')
);

$th = $tbl->appendElement('thead', ['class' => 'datatable__head'])->appendElement('tr', ['class' => 'datatable__row']);
foreach ($arr_flds as $key => $val) {
    $cls = 'datatable_cell datatable_cell-sort datatable_cell_top';
    if (in_array($key, $staticFlds)) {
        $cls .= ' datatable_cell_left';
    }
    $e = $th->appendElement('th', ['class' => $cls], $val);
}

// $tbl->appendElement('tbody', ['class' => 'datatable__body']);

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arr_listing as $sn => $row) {
    $tr = $tbl->appendElement('tr', ['class' => 'datatable__row', 'data-row' => $sr_no]);

    foreach ($arr_flds as $key => $val) {
        if (in_array($key, $staticFlds)) {
            $td = $tr->appendElement('th', ['class' => 'datatable_cell datatable_cell_left']);
            $td->appendElement('span');
        } else {
            $td = $tr->appendElement('td', ['class' => 'datatable_cell']);
            $td->appendElement('span');
        }

        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;
            case 'order_date':
                $td->appendElement('plaintext', array(), '<a href="' . UrlHelper::generateUrl('SalesReport', 'index', array($row[$key])) . '">' . FatDate::format($row[$key]) . '</a>', true);
                break;
            case 'order_net_amount':
                $amt = CommonHelper::orderProductAmount($row);
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($amt, true, true));
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
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $sr_no--;
}
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($arr_flds)
        ),
        Labels::getLabel('LBL_No_Records_Found', $adminLangId)
    );
}


echo $tbl->getHtml();
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSalesReportSearchPaging'
));
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);

?>