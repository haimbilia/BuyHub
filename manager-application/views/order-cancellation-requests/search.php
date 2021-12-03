<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
foreach ($arrListing as $sn => $row) {
    
    $cls = (($row["ocrequest_id"] % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $row["ocrequest_id"]]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $listSerial = '#C'. str_pad( $row["ocrequest_id"], 5, '0', STR_PAD_LEFT );
                $td->appendElement('plaintext', $tdAttr,  $listSerial);
                break;
            case 'buyer_detail':
                $txt = '<a href="javascript:void(0);" onclick="redirectUser('.$row['buyer_id'].')">' . $row['buyer_name'] . ' ( <strong>' . $row['buyer_username'] . '</strong> )</a>';
                $td->appendElement('plaintext', $tdAttr, $txt, true);

                break;
            case 'vendor_detail':
                $txt = '<a href="javascript:void(0);" onclick="redirectToShop(' . $row['op_shop_id'] . ')">' . $row['op_shop_name'] . ' ( <strong>' . $row['seller_username'] . '</strong> )</a>';
                $td->appendElement('plaintext', $tdAttr, $txt, true);
                break;
            case 'reuqest_detail':
                $data = [
                    'order' => $row, 
                    'siteLangId' => $siteLangId, 
                    'horizontalAlignOptions' => true
                ];
                $html = $this->includeTemplate('_partial/product/order-product-info-card.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $html, true);
                break;
            case 'amount':
                $amt = CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($row,'netamount'), true, true);
                $td->appendElement('plaintext', $tdAttr, $amt, true);
                break;
            case 'ocrequest_status':
                $statusHtml = OrderCancelRequest::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtml, true);
                break;
            case 'action':
                $data = [   
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['ocrequest_id']
                ];

                if ($canEdit && $row['ocrequest_status'] == OrderCancelRequest::CANCELLATION_REQUEST_STATUS_PENDING ) {
                    $data['editButton'] = [];
                }
                if (!empty($row['ocreason_title'])) {
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' =>  'javascript:void(0);',
                                'onclick' => 'viewComment('.$row['ocrequest_id'].','.$siteLangId.')' ,
                                'title' => Labels::getLabel('LBL_VIEW_COMMENT', $siteLangId),
                            ],
                            'label' => "<i class='far fa-eye icon'></i>"
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