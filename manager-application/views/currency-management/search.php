<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = 0;
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    $tr->setAttribute("id", $row['currency_id']);

    foreach ($fields as $key => $val) {        
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'dragdrop':
                if ($row['currency_active'] == applicationConstants::ACTIVE) {
                    $td->appendElement('i', array('class' => 'ion-arrow-move icon'));
                    $td->setAttribute("class", 'dragHandle');
                }
                break;
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="currency_ids[]" value=' . $row['currency_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'currency_symbol_left':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
            case 'currency_symbol_right':
                $td->appendElement('plaintext', array(), CommonHelper::displayNotApplicable($adminLangId, $row[$key]), true);
                break;
            case 'currency_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['currency_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch--sm switch--icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['currency_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'currency_code':
                if ($row['currency_name'] != '') {
                    $default = ($row['currency_id'] == $defaultCurrencyId) ? '<span class="badge badge--unified-brand badge--inline badge--pill">' . Labels::getLabel('LBL_DEFAULT', $adminLangId) . '</span>' : '';
                    $td->appendElement('plaintext', array(), $row['currency_name'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ') ' . $default, true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['currency_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
                break;
        }
    }
}

if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($fields)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
}

if ($printData) {
    echo $tbody->getHtml();
}

if (count($arrListing) == 0) {
    $tbl->appendElement('tr')->appendElement('td', array('colspan' => count($fields)), Labels::getLabel('LBL_No_Records_Found', $adminLangId));
} ?>