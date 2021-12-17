<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);

$frm->setFormTagAttribute('data-action', 'setupBannerImage');
$frm->setFormTagAttribute('data-onclear', 'bannerMediaForm(' . $collectionId . ',' . $recordId . ')');
$frm->setFormTagAttribute('data-callbackfn', 'loadBannerImagesCallback');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');

$fld = $frm->getField('banner_screen');
$fld->setFieldTagAttribute('class', 'prefDimensionsJs');
if (!empty($languages)) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('banner');
$fld->value = HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_BANNER_IMAGE", $siteLangId),
        'data-frm' => $frm->getFormTagAttribute('name')
    ],
    $siteLangId,
    '',
    '',
    [],
    'dropzone-custom dropzoneContainerJs'
);

$htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_PREFERRED_DIMENSIONS', $siteLangId), '1350*405') . '</span>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$fld->htmlAfterField = $htmlAfterField;

$langFld = $frm->getField('lang_id');
if (null != $langFld) {
    $langFld->developerTags['colWidthValues'] = [null, '6', null, null];
    $langFld->addFieldTagAttribute('onchange', 'loadBannerImages(' . $collectionId . ',' . $recordId . ', this.value);');
}

$displayLangTab = false;

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'banners(' . $collectionId . ')',
        'title' => Labels::getLabel('LBL_BANNERS', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_BANNERS', $siteLangId),
    'isActive' => false
];

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => 'bannerForm(' . $collectionId . ', ' . $recordId . ')',
        'title' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId),
    'isActive' => false
];

if (!empty($languages)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerLangForm(' . $collectionId . ', ' . $recordId . ',' . array_key_first($languages) . ')',
            'title' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        'isActive' => false
    ];
}

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'bannerMediaForm(' . $collectionId . ', ' . $recordId . ')',
        'title' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
    'isActive' => true
];

$includeTabs = ($collection_layout_type != Collections::TYPE_PENDING_REVIEWS1);
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">
    $('input[name=min_width]').val(1350);
    $('input[name=min_height]').val(405);
    var aspectRatio = 10 / 3;
</script>