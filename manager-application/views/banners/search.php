<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}
$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['banner_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['banner_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'banner_title':
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
            case 'banner_type':
                $td->appendElement('plaintext', $tdAttr, $bannerTypeArr[$row[$key]], true);
                break;
            case 'banner_img':
                $desktop_url = '';
                $tablet_url = '';
                $mobile_url = '';
                if (!AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $row['banner_id'], 0, $siteLangId)) {
                    continue 2;
                } else {
                    $slideArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BANNER, $row['banner_id'], 0, $siteLangId);
                    foreach ($slideArr as $slideScreen) {
                        $uploadedTime = AttachedFile::setTimeParam($slideScreen['afile_updated_at']);
                        switch ($slideScreen['afile_screen']) {
                            case applicationConstants::SCREEN_MOBILE:
                                $mobile_url = '<480:' . UrlHelper::generateFullUrl('Banner', 'Thumb', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)) . $uploadedTime . ",";
                                break;
                            case applicationConstants::SCREEN_IPAD:
                                $tablet_url = ' <768:' . UrlHelper::generateFullUrl('Banner', 'Thumb', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)) . $uploadedTime . ',' . '  <1024:' . UrlHelper::generateFullUrl('Banner', 'Thumb', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)) . $uploadedTime . ",";
                                break;
                            case applicationConstants::SCREEN_DESKTOP:
                                $desktop_url = ' >1024:' . UrlHelper::generateFullUrl('Banner', 'Thumb', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)) . $uploadedTime . ",";
                                break;
                        }
                    }
                }

                $uploadedTime = AttachedFile::setTimeParam($row['banner_updated_on']);
                $img = '<img src="' . UrlHelper::generateFullUrl('Banner', 'Thumb', array($row['banner_id'], $siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime . '" />';
                $td->appendElement('plaintext', $tdAttr, $img, true);
                break;
            case 'banner_target':
                $td->appendElement('plaintext', $tdAttr, $linkTargetsArr[$row[$key]], true);
                break;
            case 'banner_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['banner_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';
                $htm = '<span class="switch switch-sm switch-icon">
                    <label>
                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['banner_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                        <span class="input-helper"></span>
                    </label>
                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['banner_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = ['onclick' => 'editRecord('.$row['banner_id'].','.$row['banner_blocation_id'].');'];
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
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}