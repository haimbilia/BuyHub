<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
// $listSerial = 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($row["spreview_id"] % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $row["spreview_id"]]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                // $listSerial = $row["spreview_id"];
                $listSerial = '#C'. str_pad( $row["spreview_id"], 5, '0', STR_PAD_LEFT );
                $td->appendElement('plaintext', $tdAttr,  $listSerial);
                break;
            case 'selprod_title':
                $orderData = [
                    'op_selprod_id'  => $row['selprod_id'],
                    'selprod_product_id'  => $row['selprod_product_id'],
                    'op_product_name'  => $row['product_name'],
                    'op_invoice_number'  => '',
                    'op_brand_name'  => '',
                    'op_selprod_title' => $row['selprod_title'],
                ];
                $data = [
                    'order' => $orderData, 
                    'siteLangId' => $siteLangId, 
                    'horizontalAlignOptions' => true,
                    'includeInvoiceNo' => false,
                    'includeBrandName' => false,
                        'includeProductLink' => true
                ];
                $html = $this->includeTemplate('_partial/product/order-product-info-card.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $html, true);
                break;
            case 'spreview_status':
                $statusHtml = SelProdReview::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtml, true);
                break;
            // case 'sprating_rating':
            //     $rating = '<ul class="rating list-inline">';
            //     for ($j = 1; $j <= 5; $j++) {
            //         $class = ($j <= round($row[$key])) ? "active" : "in-active";
            //         $fillColor = ($j <= round($row[$key])) ? "#f5851f" : "#474747";
            //         $rating .= '<li class="' . $class . '">
			// 		<svg xml:space="preserve" enable-background="new 0 0 70 70" viewBox="0 0 70 70" height="18px" width="18px" y="0px" x="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Layer_1" version="1.1">
			// 		<g><path d="M51,42l5.6,24.6L35,53.6l-21.6,13L19,42L0,25.4l25.1-2.2L35,0l9.9,23.2L70,25.4L51,42z M51,42" fill="' . $fillColor . '" /></g></svg>

			// 	  </li>';
            //     }
            //     $rating .= '</ul>';
            //     $td->appendElement('plaintext', ['class' => 'align-right', 'width' => '20%'], $rating, true);
            //     break;
            case 'spreview_posted_on':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row[$key], true), true);
                break;
            case 'seller_username':
                if ($canViewUsers) {
                    $txt = '<a href="javascript:void(0);" onclick="redirectToShop(' . $row['shop_id'] . ')">' . $row['shop_name'] . '<br/> ( <strong>' . $row['seller_username'] . '</strong> )</a>';
                } else {
                   $txt =  $row[$key];
                }
                $td->appendElement('plaintext', $tdAttr, $txt, true);
                break;
            case 'reviewed_by':
                if ($canViewUsers) {
                    $txt = '<a href="javascript:void(0);" onclick="redirectUser('.$row['credential_user_id'].')">' . $row['buyer_name'] . ' <br/>( <strong>' . $row['reviewed_by'] . '</strong> )</a>';
                } else {
                    $txt =  $row[$key];
                }
                $td->appendElement('plaintext', $tdAttr, $txt, true);
                break;
            case 'action':
                $data = [   
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['spreview_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                }

                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
    // $listSerial++;
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