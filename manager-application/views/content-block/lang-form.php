<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('id', 'frmBlock');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmBlock")); return(false);');
$formTitle = Labels::getLabel('LBL_CONTENT_BLOCK_SETUP', $siteLangId);
if (array_key_exists($recordId, Extrapage::getContentBlockArrWithBg($siteLangId))) {
    
    $imageLangFld = $langFrm->getField('lang_id');
    $imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

    $fld = $langFrm->getField('cblock_bg_image');
    $fld->value = '<span id="imageListingJs"></span>';
    $imgArr = [];
    $imageRecordId = $image['afile_record_id'];
    if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
        $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
        $imgArr = [
            'url' => UrlHelper::getCachedUrl(
                UrlHelper::generateFileUrl(
                    'Image', 
                    'cblockBackgroundImage', 
                    array(
                        $recordId, 
                        $image['afile_lang_id'], 
                        "THUMB", 
                        $image['afile_type']
                    ), CONF_WEBROOT_FRONT_URL
                ) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'
            ),
            'name' => $image['afile_name'],
            'afile_id' => $image['afile_id'],
        ]; 
    } 
    
    $fld = $langFrm->getField('cblock_bg_image');
    $fld->value =  HtmlHelper::getfileInputHtml(
        [
            'onChange' => 'loadImageCropper(this)', 
            'accept' => 'image/*', 
            'data-name' => Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId)
        ],
        $siteLangId,
        ($canEdit ? 'deleteBackgroundImage(' . $recordId . ',' . $image['afile_id'] .',' . $image['afile_type'].','.$image['afile_lang_id'].')' :''),
        ($canEdit ? 'editDropZoneImages(this)': ''),
        $imgArr,
        'mt-3 dropzone-custom dropzoneContainerJs'
    );
}
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); 
