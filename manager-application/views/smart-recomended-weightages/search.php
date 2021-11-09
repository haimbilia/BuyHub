<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['swsetting_key']]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'swsetting_name':
                $key = str_replace('#', ' ', $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $key, true);
                break;
            case 'swsetting_weightage':
                $editable = $canEdit ? 'contentEditable="true"' : '';
                $td->appendElement('plaintext', $tdAttr, '<div ' . $editable .' data-toggle="tooltip" data-placement="top" title="' . Labels::getLabel('LBL_CLICK_HERE_TO_EDIT', $siteLangId) .'" onblur="updateWeightage(' . $row['swsetting_key'] . ',this.textContent)">' . $row[$key] . '</div>', true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key]);
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
