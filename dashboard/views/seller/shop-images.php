<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {   	
	$uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);	
    $thumbType = ($imageType == 'logo') ? 'THUMB':'PREVIEW';
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', $imageFunction, array($image['afile_record_id'], $image['afile_lang_id'], $thumbType, $image['afile_id']), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ]; 
 } 

 echo HtmlHelper::getfileInputHtml(
    ['onChange' => ($imageType == 'logo' ? 'logoPopupImage(this)' :'bannerPopupImage(this)'), 'accept' => 'image/*', 'data-name' =>  ($imageType == 'logo' ? Labels::getLabel("FRM_SHOP_LOGO", $siteLangId): Labels::getLabel("FRM_SHOP_BANNER", $siteLangId))],
    $siteLangId,
    ($canEdit ? 'removeShopImage(' . $image['afile_id'] . "," . $image['afile_lang_id'] . ",'" . $imageType . "'," . $image['afile_screen'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);


?>