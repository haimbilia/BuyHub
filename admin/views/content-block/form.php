<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmAddBlock');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#frmAddBlock")); return(false);');

$fld = $frm->getField('epage_label');
$fld->setFieldtagAttribute('autocomplete', 'off');

$fld = $frm->getField('epage_active');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$fld = $frm->getField('epage_content');

if (false === Extrapage::nonHtmlEditorBlocks($recordId)) {
    $htmlFld = $frm->addHTML('', 'epage_content_html', '<div class="col-md-12"><div class="form-group"><label class="label lbl-link">' . $fld->getCaption() . '<a class="link" href="javascript:void(0)" onclick="resetToDefaultContent();">' . Labels::getLabel('LBL_RESET_TO_DEFAULT_CONTENT', $siteLangId) . '</a></label>' . $fld->getHtml() . '</div></div>');
    $frm->changeFieldPosition($htmlFld->getFormIndex(), $fld->getFormIndex());
    $frm->removeField($fld);
}


$formTitle = Labels::getLabel('LBL_CONTENT_BLOCK_SETUP', $siteLangId);
if (array_key_exists($epageType, Extrapage::getContentBlockArrWithBg($siteLangId))) {
    $imageLangFld = $frm->getField('lang_id');
    $imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

    $imgArr = [];
    $imageRecordId = $image['afile_record_id'];
    if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
        $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
        $imageCBlockBgDimensions = ImageDimension::getData(ImageDimension::TYPE_CBLOCK_BG, ImageDimension::VIEW_THUMB);

        $imgArr = [
            'url' => UrlHelper::getCachedUrl(
                UrlHelper::generateFileUrl(
                    'Image',
                    'cblockBackgroundImage',
                    array(
                        $recordId,
                        $image['afile_lang_id'],
                        ImageDimension::VIEW_THUMB,
                        $image['afile_type']
                    ),
                    CONF_WEBROOT_FRONT_URL
                ) . $uploadedTime,
                CONF_IMG_CACHE_TIME,
                '.jpg'
            ),
            'name' => $image['afile_name'],
            'afile_id' => $image['afile_id'],
            'data-aspect-ratio' => $imageCBlockBgDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
        ];
    }
    $fld = $frm->getField('cblock_bg_image');
    $dropZone = "<span id='imageListingJs'>" . HtmlHelper::getfileInputHtml(
        [
            'onChange' => 'loadImageCropper(this)',
            'accept' => 'image/*',
            'data-name' => Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId)
        ],
        $siteLangId,
        ($canEdit ? 'deleteBackgroundImage(' . $recordId . ',' . $image['afile_id'] . ',' . $image['afile_type'] . ',' . $image['afile_lang_id'] . ')' : ''),
        ($canEdit ? 'editDropZoneImages(this)' : ''),
        $imgArr,
        'dropzone-custom dropzoneContainerJs'
    ) . "</span>";
    $htm = '<div class="col-md-12">
                <div class="form-group">
                    <label class="label">' . Labels::getLabel('FRM_BACKGROUND_IMAGE', $siteLangId) . '</label>
                    ' . $dropZone . '
                </div>
            </div>';

    $fld->value = $htm;
    $fld->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $frm->getField('min_width')->value . ' x ' . $frm->getField('min_height')->value) . '</span>';
}
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>

<div id="editor_default_content" style="display:none;">
    <?php echo (!empty($defaultContent)) ? html_entity_decode($defaultContent) : ''; ?>
</div>