<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
$statusArr = Transactions::getStatusArr($siteLangId);
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
            case 'utxn_date':
                $td->appendElement('plaintext', $tdAttr, FatDate::format($row[$key], true), true);
                break;
            case 'utxn_id':
                $td->appendElement('plaintext', $tdAttr, Transactions::formatTransactionNumber($row[$key]), true);
                break;
            case 'user_name':
                $name = $row[$key];
                $name .= !empty($row['credential_email']) ? ' (' . $row['credential_email'] . ')' : '';
                $td->appendElement('plaintext', $tdAttr, $name, true);
                break;
            case 'utxn_status':
                $td->appendElement('plaintext', $tdAttr, $statusArr[$row[$key]], true);
                break;
            case 'utxn_credit':
            case 'utxn_debit':
            case 'transactionAmount':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayMoneyFormat($row[$key], true, true));
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
