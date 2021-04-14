<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$arrFlds = array(
    'shop_name'        =>    Labels::getLabel('LBL_Name', $adminLangId),
    'owner_name'    =>    Labels::getLabel('LBL_Owner', $adminLangId),
    'totProducts'    => Labels::getLabel('LBL_Items', $adminLangId),
    'totOrders' => Labels::getLabel('LBL_Order_Placed', $adminLangId),
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
    'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $adminLangId),
    'totalFavorites' =>    Labels::getLabel('LBL_Favorites', $adminLangId),
    'totReviews'    =>    Labels::getLabel('LBL_Reviews', $adminLangId),
    'totRating'        =>    Labels::getLabel('LBL_Rating', $adminLangId),
);

$tbl = new HtmlElement(
    'table',
    array('width' => '100%', 'class' => 'table table-responsive table--hovered')
);

$th = $tbl->appendElement('thead')->appendElement('tr');
foreach ($arrFlds as $val) {
    $e = $th->appendElement('th', array(), $val, true);
}

$sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arr_listing as $sn => $row) {
    $sr_no++;
    $tr = $tbl->appendElement('tr');

    foreach ($arrFlds as $key => $val) {
        $td = $tr->appendElement('td');
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', array(), $sr_no);
                break;

            case 'shop_name':
                $shop = $row['shop_name'];
                $shop .= '<br/>Created On: ' . FatDate::format($row['shop_created_on'], false, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get()));

                $td->appendElement('plaintext', array(), $shop, true);
                break;

            case 'owner_name':
                $td->appendElement('plaintext', array(), $row['owner_name'] . '<br/>(' . $row['owner_email'] . ')', true);
                break;

            case 'totRating':
                $rating = '<ul class="rating list-inline">';
                for ($j = 1; $j <= 5; $j++) {
                    $class = ($j <= round($row['totRating'])) ? "active" : "in-active";
                    $fillColor = ($j <= round($row['totRating'])) ? "#ff3a59" : "#474747";
                    $rating .= '<li class="' . $class . '">
                    <svg xml:space="preserve" enable-background="new 0 0 70 70" viewBox="0 0 70 70" height="18px" width="18px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
                    <g><path d="M51,42l5.6,24.6L35,53.6l-21.6,13L19,42L0,25.4l25.1-2.2L35,0l9.9,23.2L70,25.4L51,42z M51,42" fill="' . $fillColor . '" /></g></svg>

                  </li>';
                }
                $rating .= '</ul>';
                $td->appendElement('plaintext', array(), $rating, true);
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
}
if (count($arr_listing) == 0) {
    $tbl->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($arrFlds)
        ),
        Labels::getLabel('LBL_No_Records_Found', $adminLangId)
    );
}
echo '<div class="overflow_auto">';
echo $tbl->getHtml();
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmShopsReportSearchPaging'
));
echo '</div>';
$pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId);
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
