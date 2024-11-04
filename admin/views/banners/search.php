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
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                //$disabled = (1 == $row['banner_id']) ? 'disabled' : '';
                $disabled = '';
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs ' . $disabled . '" type="checkbox" ' . $disabled . ' name="record_ids[]" value=' . $row['banner_id'] . '><i class="input-helper"></i></label>', true);
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
                $uploadedTime = AttachedFile::setTimeParam($row['banner_updated_on']);
                $getBannerRatio = ImageDimension::getData(ImageDimension::TYPE_BANNER, ImageDimension::VIEW_MINI_THUMB);
                $link = UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Banner', 'BannerImage', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP, ImageDimension::VIEW_HOME_PAGE_BANNER_TOP_LAYOUT), CONF_WEBROOT_FRONT_URL));
                $src = UrlHelper::generateFullUrl('Banner', 'BannerImage', array($row['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP, ImageDimension::VIEW_MINI_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime;

                $img = '<a href="' . $link . '" data-featherlight="image"><img data-aspect-ratio = "' . $getBannerRatio[ImageDimension::VIEW_MINI_THUMB]['aspectRatio'] . '" width="' . $getBannerRatio['width'] . '" height="' . $getBannerRatio['height'] . '"  src="' . $src . '" /></a>';
                $td->appendElement('plaintext', $tdAttr, $img, true);
                break;
            case 'banner_target':
                $td->appendElement('plaintext', $tdAttr, $linkTargetsArr[$row[$key]], true);
                break;
            case 'banner_active':
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['banner_id'], $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['banner_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = ['onclick' => 'editRecord(' . $row['banner_id'] . ',' . $row['banner_blocation_id'] . ');'];
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
