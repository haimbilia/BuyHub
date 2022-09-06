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
                $td->appendElement('plaintext', $tdAttr, $serialNo, true);
                break;
            case 'seller':
                $str = $this->includeTemplate('_partial/shop/shop-info-card.php', ['shop' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, $str, true);
                break;
            case 'media':
                $name = $row['badge_name'];
                $getBadgeRatio = ImageDimension::getData(ImageDimension::TYPE_BADGE_ICON, ImageDimension::VIEW_MINI);
                $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $row[Badge::DB_TBL_PREFIX . 'id'], 0, $siteLangId);
                $uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);

                $imgA = $td->appendElement('a', ['href' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], ImageDimension::VIEW_ORIGINAL, $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'data-featherlight' => 'image'], '', true);

                $imgA->appendElement('img', ['data-aspect-ratio' => $getBadgeRatio[ImageDimension::VIEW_MINI]['aspectRatio'], 'src' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], ImageDimension::VIEW_MINI, $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'), 'title' => $name, 'alt' => $name], '', true);
                break;
            case 'breq_requested_on':
                $htm = (isset($row[$key]) && $row[$key] != '0000-00-00 00:00:00') ? HtmlHelper::formatDateTime($row[$key]) : Labels::getLabel('LBL_NA', $siteLangId);
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'download':
                $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE_REQUEST, $row[BadgeRequest::DB_TBL_PREFIX . 'id']);
                $fileName = Labels::getLabel('LBL_N/A', $siteLangId);
                $getBadgeRatio = ImageDimension::getData(ImageDimension::TYPE_ADMIN_BADGE_REQUEST, ImageDimension::VIEW_THUMB);
                if ($res !== false && 0 < $res['afile_id']) {
                    $uploadedTime = AttachedFile::setTimeParam($res['afile_updated_at']);
                    $fileName = '<a href="' . UrlHelper::generateUrl('BadgeRequests', 'downloadFile', array($row['breq_id'])) . '" title = "' . Labels::getLabel('MSG_CLICK_TO_DOWNLOAD', $siteLangId) . '">
                    <img data-aspect-ratio ="' . $getBadgeRatio[ImageDimension::VIEW_THUMB]['aspectRatio'] . '" src="' .  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeRequest', array($row['breq_id'], ImageDimension::VIEW_THUMB)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '"/></a>';
                }

                $td->appendElement('div', ['class' => "text-break"], $fileName, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['breq_id']
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
