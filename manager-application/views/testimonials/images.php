<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$imgArr = [];
$recordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imageTestimonialDimensions = ImageDimension::getData(ImageDimension::TYPE_TESTIMONIAL, ImageDimension::VIEW_THUMB);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'testimonial', array($recordId, $image['afile_lang_id'], ImageDimension::VIEW_THUMB, $image['afile_id']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageTestimonialDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ]; 
 } 
 echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteMedia(' . $recordId . ',' . $image['afile_type'].','.$image['afile_id'].','.$image['afile_screen'].','.$image['afile_lang_id'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);