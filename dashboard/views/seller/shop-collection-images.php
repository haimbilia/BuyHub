<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {   	
	$uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);	    
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'shopCollectionImage', array($image['afile_record_id'], $image['afile_lang_id'], 'THUMB'), CONF_WEBROOT_FRONTEND). $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ]; 
 } 

 echo HtmlHelper::getfileInputHtml(
    ['onChange' => 'collectionPopupImage(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("LBL_COLLECTION_IMAGE", $lang_id)],
    $lang_id,
    ($canEdit ? 'removeCollectionImage(' . $scollection_id . "," . $lang_id .')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);

