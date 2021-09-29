<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
$serialNo = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;

foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);

        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="country_ids[]" value=' . $row['country_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'country_name':
                $countryName = '<figure class="user-profile_photo"><img width="40" height="40" title="' . $row['country_name'] . '" alt="' . $row['country_code'] . '" src="' . CONF_WEBROOT_FRONTEND . 'images/flags/round/' . $row['country_code'] . '.svg"></figure>';
                $countryName .= '<div class="user-profile_data"><span class="user-profile_title">' . $row['country_name'] . '</span></div>';
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $countryName . '</div>', true);
                break;
            case 'country_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['country_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['country_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['country_id']
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
    $serialNo--;
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