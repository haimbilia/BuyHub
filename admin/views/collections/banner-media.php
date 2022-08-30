<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);

$frm->setFormTagAttribute('data-action', 'setupBannerImage');
$frm->setFormTagAttribute('data-onclear', 'bannerMediaForm(' . $collectionId . ',' . $recordId . ')');
$frm->setFormTagAttribute('data-callbackfn', 'loadBannerImagesCallback');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$bannerFld = $frm->getField('banner_screen');
$bannerFld->addFieldTagAttribute('id', 'slideScreenJs');

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

$htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_PREFERRED_DIMENSIONS', $siteLangId), $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['width'] .
    " x " . $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['height']) . '</span>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$fld->htmlAfterField = $htmlAfterField;
$langFld = $frm->getField('lang_id');
if (null != $langFld) {
    $langFld->addFieldTagAttribute('id', 'imageLanguageJs');  
    if($bannerFld->fldType !='hidden'){        
        $bannerFld->developerTags['colWidthValues'] = [null, '6', null, null];
        $langFld->developerTags['colWidthValues'] = [null, '6', null, null];
    }else{
        $langFld->developerTags['colWidthValues'] = [null, '12', null, null];
    }    
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
    $('input[name=min_width]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['width']; ?>');
    $('input[name=min_height]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['height']; ?>');



    $(document).off('change', '#slideScreenJs').on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['width'] .
                                                                                            " x " . $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $('input[name=min_width]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $('input[name=min_height]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_DESKTOP]['height']; ?>');

        } else if ($(this).val() == screenIpad) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $bannerDimensiomns[ImageDimension::VIEW_TABLET]['width'] .
                                                                                            " x " . $bannerDimensiomns[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $('input[name=min_width]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_TABLET]['width']; ?>');
            $('input[name=min_height]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_TABLET]['height']; ?>');

        } else {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $bannerDimensiomns[ImageDimension::VIEW_MOBILE]['width'] .
                                                                                            " x " . $bannerDimensiomns[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $('input[name=min_width]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $('input[name=min_height]').val('<?php echo $bannerDimensiomns[ImageDimension::VIEW_MOBILE]['height']; ?>');

        }

        let slideScreen = $(this).val();
        let recordId = $(this).closest("form").find('input[name="banner_id"]').val();
        let langId = $("#imageLanguageJs").val();
        let collectionId = '<?php echo $collectionId; ?>';
        loadBannerImages(collectionId, recordId, '<?php echo ImageDimension::VIEW_THUMB; ?>', slideScreen, langId);
    });
</script>