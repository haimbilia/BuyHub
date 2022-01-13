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
                $href = "javascript:void(0)";
                $onclick = ($canViewUsers ? 'redirectUser('. $row['user_id'] . ')' : '');
                $str = $this->includeTemplate('_partial/user/user-info-card.php', [
                    'user' => $row,
                    'siteLangId' => $siteLangId,
                    'href' => $href,
                    'onclick' => $onclick,
                    'extraClass' => 'user-profile-sm'
                ], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'vendor_detail':
                $onclick = $canViewShops && !empty($row['op_shop_id']) ? 'redirectToShop(' . $row['op_shop_id'] . ')' : '';
                $data = [
                    'user_updated_on' => $row['seller_updated_on'],
                    'user_id' => $row['seller_id'],
                    'user_name' => $row['seller_name'],
                    'credential_username' => $row['seller_username'],
                    'credential_email' => $row['seller_email'],
                    
                ];
                $title = '';
                if (!empty($row['op_shop_name'])) {
                    $str = Labels::getLabel('LBL_SHOP:_{SHOP}', $siteLangId);
                    $data['extra_text'] = CommonHelper::replaceStringData($str, ['{SHOP}' => $row['op_shop_name']]);
                    $title = Labels::getLabel('LBL_CLICK_HERE_TO_VISIT_SHOP_LIST', $siteLangId);
                }
                
                $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $data, 'siteLangId' => $siteLangId, 'onclick' => $onclick, 'title' => $title,'extraClass' => 'user-profile-sm','displayProfileImage'=>false], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'reuqest_detail':
                $data = [
                    'order' => $row, 
                    'siteLangId' => $siteLangId, 
                    'horizontalAlignOptions' => true
                ];
                $html = $this->includeTemplate('order-cancellation-requests/_partial/cancellation-info-card.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $html, true);
                break;
            case 'amount':
                $amt = CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($row,'netamount'), true, true);
                $td->appendElement('plaintext', $tdAttr, $amt, true);
                break;
            case 'ocrequest_date':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row[$key], true), true);
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

                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}