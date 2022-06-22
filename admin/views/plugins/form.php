<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frm->getField('CONF_DEFAULT_PLUGIN_'.$type);

if(null != $fld){
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$fld = $frm->getField('plugin_logo');
if(null != $fld){
    $frm->setFormTagAttribute('data-callback', 'editRecord(' . $recordId.')');
    $frm->setFormTagAttribute('data-action', 'uploadIcon');
    $imgArr = [];
    if (!empty($pluginLogo) && isset($pluginLogo['afile_id']) && $pluginLogo['afile_id'] != -1) {
        $uploadedTime = AttachedFile::setTimeParam($pluginLogo['afile_updated_at']);
        $imagePluginDimensions = ImageDimension::getData(ImageDimension::TYPE_PLUGIN_IMAGE, ImageDimension::VIEW_THUMB);
        $imgArr = [
            'url' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'plugin', array($pluginLogo['afile_record_id'], ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
            'name' => $pluginLogo['afile_name'],
            'afile_id' => $pluginLogo['afile_id'],
            'data-aspect-ratio' => $imagePluginDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
        ];         
     }

    $fld->value = '<label class="label">'.Labels::getLabel("FRM_LOGO", $siteLangId).'</label>'.HtmlHelper::getfileInputHtml(
        ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_PLUGIN_LOGO", $siteLangId)],
        $siteLangId,
        ($canEdit ? 'deleteIcon('.$pluginLogo['afile_record_id'].')': ''),
        ($canEdit ? 'editDropZoneImages(this)': ''),
        $imgArr,
        'dropzone-custom dropzoneContainerJs'
    );
}


require_once(CONF_THEME_PATH . '_partial/listing/form.php');