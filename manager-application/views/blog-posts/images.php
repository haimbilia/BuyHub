<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [        
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'blogPostAdmin', array($image['afile_record_id'], $image['afile_lang_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
    ];
}

echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_BLOG_POST_MEDIA", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteImage(' . $image['afile_record_id'] . ',' . $image['afile_id'] . ',' . $image['afile_lang_id'] . ')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);
