<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$imgArr = [];
$recordId = $image['afile_record_id'];
if ($recordId > 0) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imageContPageDimensions = ImageDimension::getData(ImageDimension::TYPE_CPAGE_BG, ImageDimension::VIEW_THUMB);

    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', $imageFunction, array($recordId, $image['afile_lang_id'], "THUMB", $image['afile_id'], $image['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageContPageDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ]; 
 } 

 echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteBackgroundImage(' . $recordId . ',' . $image['afile_id'] .',' . $image['afile_lang_id'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);
