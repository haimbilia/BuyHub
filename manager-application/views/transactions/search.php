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
            case 'user_name':
                $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;    
            case 'utxn_id':
                $td->appendElement('plaintext', $tdAttr, Transactions::formatTransactionNumber($row[$key]) );
            break;
            case 'utxn_date':
                $td->appendElement('plaintext', $tdAttr,HtmlHelper::formatDateTime($row[$key]));
            break;
            case 'utxn_credit':
            case 'utxn_debit':
            case 'balance':
                $td->appendElement('plaintext', $tdAttr,CommonHelper::displayMoneyFormat($row[$key]));
            break;														
            case 'utxn_comments':								
                $td->appendElement('plaintext', $tdAttr, Transactions::formatTransactionComments($row[$key]),true);
            break;
            case 'utxn_status':
                $statusHtm = Transactions::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtm, true);
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