<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['brand_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="brandIds[]" value=' . $row['brand_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'brand_identifier':
                $uploadedTime = AttachedFile::setTimeParam($row['brand_updated_on']);
                $brandImage = '<figure class="user-profile_photo"><img width="40" height="40" title="' . $row['brand_name'] . '" alt="' . $row['brand_name'] . '" src="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($row['brand_id'], $adminLangId, 'MINITHUMB'), CONF_WEBROOT_FRONT_URL). $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '"></figure>';

                if ($row['brand_name'] != '') {
                    $brandName = '<div class="user-profile_data">
                                    <span class="user-profile_title">' . $row['brand_name'] . '</span>
                                    <span class="text-muted fw-bold">' . $row[$key] . '</span>
                                </div>';
                } else {
                    $brandName = '<div class="user-profile_data">
                                    <span class="user-profile_title">' . $row[$key] . '</span>
                                </div>';
                }
                $td->appendElement('plaintext', [], '<div class="user-profile">' . $brandImage . $brandName . '</div>', true);
                break;
            case 'brand_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['brand_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['brand_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['brand_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                    $data['deleteButton'] = [];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
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