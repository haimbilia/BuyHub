<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
$recordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($bannerDetail['banner_updated_on']);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Banner',
                'Thumb',
                array(
                    $recordId,
                    $image['afile_lang_id'],
                    $image['afile_screen'],
                    '',
                ),
                CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime,
            CONF_IMG_CACHE_TIME,
            '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ];
}

echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_BANNER_IMAGE", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteMedia(' . $bannerLocationId . ',' . $recordId . ',' . $image['afile_id'] . ',' . $image['afile_type'] . ',' . $image['afile_lang_id'] . ',' . $image['afile_screen'] . ')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);
