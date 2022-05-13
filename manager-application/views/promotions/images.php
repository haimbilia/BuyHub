<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $imgUrl =  '';
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    switch ($promotionType) {
        case Promotion::TYPE_BANNER:
            $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_BANNER, ImageDimension::VIEW_THUMB);
            $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Banner', 'BannerImage', array($image['afile_record_id'], $image['afile_lang_id'], $image['afile_screen'],  ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            break;
        case Promotion::TYPE_SLIDES:
            $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_SLIDE, ImageDimension::VIEW_THUMB);
            $imgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullUrl('Image', 'Slide', array($image['afile_record_id'], $image['afile_screen'], $image['afile_lang_id'],  ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            break;
    }
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [
        'url' => $imgUrl,
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ]; 
 } 

 echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_PROMOTION_BANNER", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'removeMedia(' . $promotionId . ',\'' .  $image['afile_record_id'] . '\',' . $image['afile_lang_id'] .',' . $image['afile_screen'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);