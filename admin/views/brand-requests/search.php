<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;

foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['brand_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['brand_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'user_name':
                if ($canViewUsers) {
                    $href = "javascript:void(0)";
                    $onclick = ($canViewUsers ? 'redirectUser(' . $row['user_id'] . ')' : '');
                    $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'siteLangId' => $siteLangId, 'displayProfileImage' => false, 'href' => $href, 'onclick' => $onclick,], false, true);
                    $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                } else {
                    $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                }
                break;
            case 'brand_logo':
                $uploadedTime = AttachedFile::setTimeParam($row['brand_updated_on']);
                $languages = Language::getAllNames();

                $brandLogo = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $row['brand_id'], 0, $siteLangId, (count($languages) > 1) ? false : true);

                $aspectRatioType = $brandLogo['afile_aspect_ratio'];
                $aspectRatioType = ($aspectRatioType > 0) ? $aspectRatioType : 1;
                $imageBrandDimensions = ImageDimension::getData(ImageDimension::TYPE_BRAND_LOGO, ImageDimension::VIEW_MINI_THUMB, $aspectRatioType);

                $td->appendElement(
                    'plaintext',
                    array('style' => 'text-align:center'),
                    '<a class="thumbnail" href="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($row['brand_id'], $siteLangId, ImageDimension::VIEW_ORIGINAL), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" data-featherlight="image"><img   data-aspect-ratio = "' . $imageBrandDimensions[ImageDimension::VIEW_MINI_THUMB]['aspectRatio'] . '" class="max-img"  src="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($row['brand_id'], $siteLangId, ImageDimension::VIEW_MINI_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '"></a>',
                    true
                );
                break;
            case 'brand_active':
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['brand_id'], $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'brand_status':
                $statusAct = ($canEdit) ? 'updateApprovalStatus(event, this, ' . $row['brand_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';
                $str =  '<label class="switch switch-sm switch-icon"  data-bs-toggle="tooltip" data-placement="top">
                            <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['brand_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                            <span class="input-helper"></span>
                        </label>';
                $td->appendElement('plaintext', $tdAttr, $str, true);
                break;
            case 'brand_requested_on':
                $td->appendElement('plaintext', array(), HtmlHelper::formatDateTime($row[$key]), true);
                break;
            case 'brand_updated_on':
                $td->appendElement('plaintext', array(), HtmlHelper::formatDateTime($row[$key], true), true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['brand_id']
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

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
