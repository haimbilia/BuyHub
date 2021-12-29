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
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="stpl_codes[]" value=' . $row['stpl_code'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo, true);
                break;
            case 'stpl_status':
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';
                $statusAct = ($canEdit) ? 'updateStatus(event, this, \'' . $row['stpl_code'] . '\', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $htm = '<span class="switch switch-sm switch-icon" data-bs-toggle="tooltip" data-placement="top">
                            <label>
                                <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['stpl_code'] . '" ' . $checked . ' onclick="' . $statusAct . '">
                                <span class="input-helper"></span>
                            </label>
                        </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['stpl_code']
                ];

                if ($canEdit) {
                    $data['editButton'] = [
                        'onclick' => "editStplData('" . $row['stpl_code'] . "' , " . $siteLangId . ")"
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

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
