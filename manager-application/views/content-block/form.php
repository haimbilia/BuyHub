<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmAddBlock');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#frmAddBlock")); return(false);');

$fld = $frm->getField('epage_label');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','epage_id');getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('epage_active');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

/*
$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = '<span class="form-text text-muted">' . UrlHelper::generateFullUrl('Custom', 'View', array($recordId), CONF_WEBROOT_FRONT_URL) . '</span>';
$fld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");
*/
$formTitle = Labels::getLabel('LBL_CONTENT_BLOCK_SETUP', $siteLangId);
if (array_key_exists($recordId, Extrapage::getContentBlockArrWithBg($siteLangId))) {
    $imageLangFld = $frm->getField('lang_id');
    $imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

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
                    ),
                    CONF_WEBROOT_FRONT_URL
                ) . $uploadedTime,
                CONF_IMG_CACHE_TIME,
                '.jpg'
            ),
            'name' => $image['afile_name'],
            'afile_id' => $image['afile_id'],
        ];
    }
    $fld = $frm->getField('cblock_bg_image');
    $fld->value = "<span id='imageListingJs'>" . HtmlHelper::getfileInputHtml(
        [
            'onChange' => 'loadImageCropper(this)',
            'accept' => 'image/*',
            'data-name' => Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId)
        ],
        $siteLangId,
        ($canEdit ? 'deleteBackgroundImage(' . $recordId . ',' . $image['afile_id'] . ',' . $image['afile_type'] . ',' . $image['afile_lang_id'] . ')' : ''),
        ($canEdit ? 'editDropZoneImages(this)' : ''),
        $imgArr,
        'mt-3 dropzone-custom dropzoneContainerJs'
    ) . "</span>";
}
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
