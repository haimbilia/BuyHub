<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', $imageFunction, array($image['afile_record_id'], $image['afile_lang_id'], "THUMB", $image['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ];
}

if($imageType == 'icon'){
    $popup = 'iconPopupImage';
    $label = Labels::getLabel("FRM_CATEGORY_ICON", $siteLangId);
} elseif ($imageType == 'banner') {
    $popup = 'bannerPopupImage';
    $label = Labels::getLabel("FRM_CATEGORY_BANNER_IMAGE", $siteLangId);
} elseif ($imageType == 'thumb') {
    $popup = 'thumbPopupImage';
    $label = Labels::getLabel("FRM_CATEGORY_THUMB", $siteLangId);
}

echo HtmlHelper::getfileInputHtml(
    ['onChange' => $popup . '(this)', 'accept' => 'image/*', 'data-name' => $label, 'data-file_type' => $imageType],
    $siteLangId,
    ($canEdit ? 'deleteImage(' . $image['afile_id'] . ',' . $image['afile_record_id'] . ',\'' . $imageType . '\',' . $image['afile_lang_id'] . ',' . $image['afile_screen'] . ')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);
