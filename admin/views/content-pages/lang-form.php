<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmLangJs1');
$langFrm->setFormTagAttribute('onsubmit', 'saveContentPageLangData($("#frmLangJs1")); return(false);');

$editFunction = 'editLangData(' . $recordId . ',' . CommonHelper::getDefaultFormLangId() . ', 0, "modal-dialog-vertical-md");';
$langFrm->setFormTagAttribute('data-onclear', $editFunction);
$displayLangTab = false;

$fld = $langFrm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => $editFunction,
            'title' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        'isActive' => true
    ]
];

if ($cpage_layout == ContentPage::CONTENT_PAGE_LAYOUT1_TYPE) {
    $fld = $langFrm->getField('cpage_bg_image');
    $fld->value = '<span id="imageListingJs"></span>';
    $imgArr = [];
    $imageContPageDimensions = ImageDimension::getData(ImageDimension::TYPE_CPAGE_BG, ImageDimension::VIEW_DEFAULT);
    if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
        $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
        $imgArr = [
            'url' => UrlHelper::getCachedUrl(
                UrlHelper::generateFileUrl(
                    'Image',
                    'cpageBackgroundImage',
                    array(
                        $image['afile_record_id'],
                        $image['afile_lang_id'],
                        ImageDimension::VIEW_DEFAULT,
                        $image['afile_type']
                    ),
                    CONF_WEBROOT_FRONT_URL
                ) . $uploadedTime,
                CONF_IMG_CACHE_TIME,
                '.jpg'
            ),
            'name' => $image['afile_name'],
            'afile_id' => $image['afile_id'],
            'data-aspect-ratio' => $imageContPageDimensions[ImageDimension::VIEW_DEFAULT]['aspectRatio'],
        ];
    }

    $fld->value =  '<label class="label">' . Labels::getLabel('FRM_BACKGROUND_IMAGE', $lang_id) . '</label>' . HtmlHelper::getfileInputHtml(
        [
            'onChange' => 'loadImageCropper(this)',
            'accept' => 'image/*',
            'data-name' => Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId)
        ],
        $siteLangId,
        ($canEdit ? 'deleteBackgroundImage(' . $image['afile_record_id'] . ',' . $image['afile_id'] . ',' . $image['afile_lang_id'] . ')' : ''),
        ($canEdit ? 'editDropZoneImages(this)' : ''),
        $imgArr,
        'mt-3 dropzone-custom dropzoneContainerJs'
    );

    $fld->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $imageContPageDimensions['width'] . ' x ' . $imageContPageDimensions['height']) . '</span>';
}


require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');
