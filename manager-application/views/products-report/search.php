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
                $td->appendElement('plaintext', array(), $serialNo);
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
                $td->appendElement('plaintext', array(), $name, true);
                break;

            case 'price':
                $td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row['selprod_price'], true, true));
                break;

            case 'followers':
                $td->appendElement('plaintext', array(), $row[$key], true);
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

                /* case 'order_date':
                $td->appendElement('plaintext', array(), '<a href="'.UrlHelper::generateUrl('SalesReport','index',array($row[$key])).'">'.FatDate::format($row[$key]).'</a>',true);
                break;
            */

            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
    $serialNo++;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}
