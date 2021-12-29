<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
$listSerial = 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($row["spreview_id"] % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $row["spreview_id"]]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr,  $listSerial);
                break;
            case 'selprod_title':
                $data = [
                    'product' => $row, 
                    'siteLangId' => $siteLangId, 
                ];
                $html = $this->includeTemplate('_partial/product/product-info-card.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $html, true);
                break;
            case 'spreview_status':
                $statusHtml = SelProdReview::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtml, true);
                break;
            case 'sprating_rating':
                $rating = '';
                for ($i = 1; $i <= 5; $i++) {
                    $fillcolor = ($i <= round($row[$key])) ? "#F5861F" : "#000000";
                    $rating .= '<svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px" fill="'. $fillcolor.'"><path d="M0 0h24v24H0z" fill="none"/><path d="M0 0h24v24H0z" fill="none"/><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';
                }
                
                $td->appendElement('plaintext', ['class' => 'align-right', 'width' => '20%'], $rating, true);
                break;
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
    $listSerial++;
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}