<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {   
	$imgUrl = '';
	$uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
	switch ($promotionType) {
		case Promotion::TYPE_BANNER:
			$imgUrl = UrlHelper::generateFullUrl('Banner', 'BannerImage', array($image['afile_record_id'], $image['afile_lang_id'], $image['afile_screen'], 'THUMB'), CONF_WEBROOT_FRONTEND);
			break;
		case Promotion::TYPE_SLIDES:
			$imgUrl = UrlHelper::generateFullUrl('Image', 'Slide', array($image['afile_record_id'], $image['afile_screen'], $image['afile_lang_id'], 'THUMB'), CONF_WEBROOT_FRONTEND);
			break;
	}

	$imgUrl = UrlHelper::getCachedUrl($imgUrl . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $imgArr = [
        'url' => $imgUrl ."?". $uploadedTime,
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ]; 
 } 

 echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'popupImage(this)', 'accept' => 'image/*', 'data-name' =>  Labels::getLabel("FRM_PROMOTION_MEDIA", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'removePromotionBanner(' . $promotionId . ',\'' . $image['afile_record_id'] . '\',' . $image['afile_lang_id'] .',' . $image['afile_screen'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);
