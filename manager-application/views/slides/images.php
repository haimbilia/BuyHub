<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
$recordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imageSlideDimensions = ImageDimension::getData(ImageDimension::TYPE_SLIDE, ImageDimension::VIEW_THUMB);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image', 
                'Slide', 
                array(
                    $recordId, 
                    $image['afile_screen'], 
                    $langId, 
                    ImageDimension::VIEW_THUMB, 
                    false
                ), CONF_WEBROOT_FRONT_URL
			) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'
		),
		'name' => $image['afile_name'],
		'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageSlideDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
	]; 
}

echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_SLIDE_IMAGE", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteMedia('.$recordId.','. $image['afile_id'].','.$image['afile_type'].','.$langId.','.$image['afile_screen'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);