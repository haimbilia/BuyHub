<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'name':
                $name = $row['name'] . (!empty($row['email']) ? '<br/>(' . $row['email'] . ')' : '');
                $td->appendElement('plaintext', $tdAttr, $name, true);
                break;
            case 'user_regdate':
                $date = HtmlHelper::formatDateTime(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                );
                $td->appendElement('plaintext', $tdAttr, $date, true);
                break;
            case 'orderDate':
                $td->appendElement('plaintext', $tdAttr, '<a href="' . UrlHelper::generateUrl('SalesReport', 'index', array($row[$key])) . '">' . HtmlHelper::formatDateTime($row[$key]) . '</a>', true);
                break;
            case 'order_net_amount':
                $amt = CommonHelper::orderProductAmount($row);
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($amt, true, true));
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
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
                break;
            case 'rewardsPoints':
            case 'rewardsPointsEarned':
            case 'rewardsPointsRedeemed':
            case 'netSoldQty':
            case 'totOrders':
            case 'totRefundedQtys':
            case 'totQtys':
            case 'promotionCharged':
                $td->appendElement('plaintext', $tdAttr, FatUtility::int($row[$key], FatUtility::VAR_INT, 0), true);
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
    $serialNo++;
}

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
