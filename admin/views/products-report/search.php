<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
$page = $page ?? 0;
$pageSize = $pageSize ?? 0;
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
                $name = "<strong>" . Labels::getLabel('LBL_Catalog_Name', $siteLangId) . ": </strong>" . $row['product_name'];
                if ($row['selprod_title'] != '') {
                    $name .= '<br/><strong>' . Labels::getLabel('LBL_Custom_Title', $siteLangId) . ': </strong>' . $row['selprod_title'];
                }
                if ($row['grouped_option_name'] != '') {
                    $groupedOptionNameArr = explode(',', $row['grouped_option_name']);
                    $groupedOptionValueArr = explode(',', $row['grouped_optionvalue_name']);
                    if (!empty($groupedOptionNameArr)) {
                        foreach ($groupedOptionNameArr as $key => $optionName) {
                            $name .= '<br/><strong>' . $optionName . ':</strong> ' . $groupedOptionValueArr[$key];
                        }
                    }
                }

                if ($row['brand_name'] != '') {
                    $name .= "<br/><strong>" . Labels::getLabel('LBL_Brand', $siteLangId) . ":  </strong>" . $row['brand_name'];
                }

                if ($row['shop_name'] != '') {
                    $name .= '<br/><strong>' . Labels::getLabel('LBL_Sold_By', $siteLangId) . ':  </strong>' . $row['shop_name'];
                }
                $name = "<div class='info-wrap'>" . $name . "</div>";
                $td->appendElement('plaintext', $tdAttr, $name, true);
                break;

            case 'price':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row['selprod_price'], true, true));
                break;

            case 'followers':
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
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
            case 'followers':
            case 'totOrders':
            case 'totQtys':
            case 'totRefundedQtys':
            case 'netSoldQty':
                $td->appendElement('plaintext', $tdAttr, FatUtility::int($row[$key], FatUtility::VAR_INT, 0), true);

                /* case 'order_date':
                $td->appendElement('plaintext', $tdAttr, '<a href="'.UrlHelper::generateUrl('SalesReport','index',array($row[$key])).'">'.HtmlHelper::formatDateTime($row[$key]).'</a>',true);
                break;
            */

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
