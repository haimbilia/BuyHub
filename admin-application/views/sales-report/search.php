<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$arrFlds1 = array(
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'order_date' => Labels::getLabel('LBL_Date', $adminLangId),
    'totOrders' => Labels::getLabel('LBL_Order_Placed', $adminLangId),
    /*  'orderNetAmount' => Labels::getLabel('LBL_Order_Net_Amount', $adminLangId), */
);
$arrFlds2  = array(
    'listserial' => Labels::getLabel('LBL_#', $adminLangId),
    'op_invoice_number' => Labels::getLabel('LBL_Invoice_Number', $adminLangId),
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
    'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $adminLangId),
    'discountTotal' => Labels::getLabel('LBL_Coupon_Discount', $adminLangId),
    'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $adminLangId),
    'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $adminLangId),

    'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $adminLangId),
    'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $adminLangId),
    'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $adminLangId)
);
if (empty($orderDate)) {
    $arr_flds = array_merge($arrFlds1, $arr);
} else {
    $arr_flds = array_merge($arrFlds2, $arr);
}


$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'table table-responsive table--hovered')
);

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arr_flds as $val) {
    $e = $th->appendElement('th', array(), $val);
}

$sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arr_listing as $sn => $row) {
    $tr = $tbl->appendElement('tr');

    foreach ($arr_flds as $key => $val) {
        $td = $tr->appendElement('td');
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
            case 'inventoryValue':
            case 'taxTotal':
            case 'shippingTotal':
            case 'discountTotal':
            case 'volumeDiscount':
            case 'rewardDiscount':
            case 'refundedAmount':
            case 'orderNetAmount':
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
