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
                $td->appendElement('plaintext', $tdAttr, $serialNo, true);
                break;
            case 'orrequest_id':
                $td->appendElement('plaintext', $tdAttr, $row['orrequest_reference']);
                break;
            case 'buyer_detail':
                $txt = '<a href="javascript:void(0);" onclick="redirectUser(' . $row['order_user_id'] . ')">' . $row['buyer_name'] . ' <br>( <strong>' . $row['buyer_username'] . '</strong> )</a>';
                $td->appendElement('plaintext', $tdAttr, $txt, true);
                break;
            case 'vendor_detail':
                $txt = '<a href="javascript:void(0);" onclick="redirectToShop(' . $row['op_shop_id'] . ')">' . $row['op_shop_name'] . '<br> ( <strong>' . $row['seller_username'] . '</strong> )</a>';
                $td->appendElement('plaintext', $tdAttr, $txt, true);
                break;
            case 'product':
                $html = $this->includeTemplate('_partial/product/order-product-info-card.php', ['order' => $row, 'siteLangId' => $siteLangId, 'horizontalAlignOptions' => true], false, true);
                $td->appendElement('plaintext', $tdAttr, $html, true);
                break;
            case 'orrequest_type':
                $td->appendElement('plaintext', $tdAttr, isset($requestTypeArr[$row[$key]]) ? $requestTypeArr[$row[$key]] : '', true);
                break;
            case 'orrequest_date':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row[$key], true), true);
                break;
            case 'amount':
                $amt = '';
                $priceTotalPerItem = CommonHelper::orderProductAmount($row, 'netamount', true);
                $price = 0;
                if ($row['orrequest_status'] != OrderReturnRequest::RETURN_REQUEST_STATUS_REFUNDED) {
                    if (FatApp::getConfig('CONF_RETURN_SHIPPING_CHARGES_TO_CUSTOMER', FatUtility::VAR_INT, 0)) {
                        $shipCharges = isset($row['charges'][OrderProduct::CHARGE_TYPE_SHIPPING][OrderProduct::DB_TBL_CHARGES_PREFIX . 'amount']) ? $row['charges'][OrderProduct::CHARGE_TYPE_SHIPPING][OrderProduct::DB_TBL_CHARGES_PREFIX . 'amount'] : 0;
                        $unitShipCharges = round(($shipCharges / $row['op_qty']), 2);
                        $priceTotalPerItem = $priceTotalPerItem + $unitShipCharges;
                        $price = $priceTotalPerItem * $row['orrequest_qty'];
                    }
                }

                if (!$price) {
                    $price = $priceTotalPerItem * $row['orrequest_qty'];
                    $price = $price + $row['op_refund_shipping'];
                }

                $amt = CommonHelper::displayMoneyFormat($price, true, true);
                $td->appendElement('plaintext', $tdAttr, $amt, true);
                break;
            case 'orrequest_status':
                $statusHtml = OrderReturnRequest::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtml, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['orrequest_id']
                ];

                if ($canEdit) {
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => UrlHelper::generateUrl('OrderReturnRequests', 'view', [$row['orrequest_id']]),
                                'title' => Labels::getLabel('LBL_VIEW_DETAIL', $siteLangId)
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#view">
                                            </use>
                                        </svg>'
                        ]
                    ];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
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
