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

            case 'product_name':
                $name = $row['product_name'];
                if ($row['brand_name'] != '') {
                    $name .= "<br/><strong>" . Labels::getLabel('LBL_Brand', $siteLangId) . ": </strong>" . $row['brand_name'];
                }
                $name = "<div class='info-wrap'>" . $name . "</div>";
                $td->appendElement('plaintext', $tdAttr, $name, true);
                break;
            case 'prodcat_name':
                $td->appendElement('plaintext', $tdAttr, html_entity_decode($row[$key], ENT_QUOTES, 'utf-8'), true);
                break;
            case 'product_type':
                $td->appendElement('plaintext', $tdAttr, $productTypeArr[$row[$key]] ?? '', true);
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
