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
    $tr->setAttribute("id", $row['taxstr_id']);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'taxstr_identifier':
                if (empty($row['taxstr_name'])) {
                    $td->appendElement('plaintext', $tdAttr, $row['taxstr_name'], true);
                    $td->appendElement('br', $tdAttr);
                    $td->appendElement('plaintext', $tdAttr, '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                }
                break;
            case 'taxstr_is_combined':
                $td->appendElement('plaintext', $tdAttr, applicationConstants::getYesNoArr($adminLangId)[$row[$key]]);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['taxstr_id']
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
    $serialNo++;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields)
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $adminLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}