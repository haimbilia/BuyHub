<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
$pageSize = $pageSize ?? 0;
$page = $page ?? 0;

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
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="brandIds[]" value=' . $row['brand_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'brand_logo':
                $languages = Language::getAllNames();
                $brandLogo = AttachedFile::getAttachment(AttachedFile::FILETYPE_BRAND_LOGO, $row['brand_id'], 0, $siteLangId, (count($languages) > 1) ? false : true);
                $aspectRatioType = $brandLogo['afile_aspect_ratio'];
                $aspectRatioType = ($aspectRatioType > 0) ? $aspectRatioType : 1;
                $imageBrandDimensions = ImageDimension::getData(ImageDimension::TYPE_BRAND_LOGO, ImageDimension::VIEW_MINI_THUMB, $aspectRatioType);
                $uploadedTime = AttachedFile::setTimeParam($row['brand_updated_on']);

                $brandImage = '<a href="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($row['brand_id'], $siteLangId, ImageDimension::VIEW_ORIGINAL), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" data-featherlight="image"><img data-aspect-ratio = "' . $imageBrandDimensions[ImageDimension::VIEW_MINI_THUMB]['aspectRatio'] . '" width="' . $imageBrandDimensions['width'] . '" height="' . $imageBrandDimensions['height'] . '" title="' . $row['brand_name'] . '" alt="' . $row['brand_name'] . '" src="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'brand', array($row['brand_id'], $siteLangId, ImageDimension::VIEW_MINI_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '"></a>';

                $td->appendElement('plaintext', $tdAttr, '<div class="brand-logo">' . $brandImage . '</div>', true);
                break;
            case 'brand_identifier':
                $brandName = !empty($row['brand_name']) ? $row['brand_name'] : $row[$key];
                $td->appendElement('plaintext', $tdAttr, $brandName, true);
                break;
            case 'seo_url':
                $url = UrlHelper::generateFullUrl('Brands', 'View', array($row['brand_id']), CONF_WEBROOT_FRONT_URL);
                $td->appendElement('plaintext', $tdAttr, '<a class="td-link" href="' . $url . '" target="_blank">' . $url . '</a>', true);
                break;
            case 'brand_active':
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['brand_id'], $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
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
