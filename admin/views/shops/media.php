<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* Logo Image */
HtmlHelper::formatFormFields($logoFrm);
$logoFrm->setFormTagAttribute('class', 'modal-body form');

$fld = $logoFrm->getField('logo_heading');
$fld->developerTags['fieldWrapperRowExtraClass'] = 'form-group mb-3';
$fld->value = '<h5>' . Labels::getLabel('FRM_LOGO', $siteLangId) . '</h5>';

$logoLangFld = $logoFrm->getField('lang_id');
$logoLangFld->addFieldTagAttribute('id', 'logoLanguageJs');

$ratioFld = $logoFrm->getField('ratio_type');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld = HtmlHelper::configureRadioAsButton($logoFrm, 'ratio_type');

$fld = $logoFrm->getField('shop_logo');
$fld->htmlAfterField = '<span class="form-text text-muted logoPreferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '' . $getShopLogoSquare['width'] . ' x ' . $getShopLogoSquare['height'] . '') . '</span>';
$fld->value = '<span id="logoListingJs"></span>';

$ratioFld->attachField($fld);

/* Logo Image */


/* Image Form */
HtmlHelper::formatFormFields($shopBannerFrm);
$shopBannerFrm->setFormTagAttribute('class', 'modal-body form');

$fld = $shopBannerFrm->getField('shop_banner');
$fld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '' . $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width'] . ' x ' . $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height'] . '') . '</span>';
$fld->value = '<span id="imageListingJs"></span>';

$imageLangFld = $shopBannerFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

$fld = $shopBannerFrm->getField('banner_heading');
$fld->developerTags['fieldWrapperRowExtraClass'] = 'form-group mb-3';
$fld->value = '<h5>' . Labels::getLabel('FRM_BANNERS', $siteLangId) . '</h5>';

$screenFld = $shopBannerFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');
if (1 < $languageCount) {
    $imageLangFld->developerTags['colWidthValues'] = [null, '6', null, null];
    $screenFld->developerTags['colWidthValues'] = [null, '6', null, null];
}
/* Image Form */



$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ]
];

$generalTab['attr']['onclick'] = 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")';
$langTabExtraClass = "modal-dialog-vertical-md";

$formTitle = Labels::getLabel('LBL_SHOP_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <?php echo $logoFrm->getFormHtml(); ?>
    <div class="separator separator-dashed my-4"></div>
    <?php echo $shopBannerFrm->getFormHtml(); ?>
</div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script>
    var minWidthLogoEle = $('#<?php echo $logoFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightLogoEle = $('#<?php echo $logoFrm->getFormTagAttribute('id'); ?> input[name=min_height]');
    var minWidthBaneerEle = $('#<?php echo $shopBannerFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightBaneerEle = $('#<?php echo $shopBannerFrm->getFormTagAttribute('id'); ?> input[name=min_height]');

    $(minWidthBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width'];  ?>');
    $(minHeightBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
    
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var ratioTypeCustom = <?php echo AttachedFile::RATIO_TYPE_CUSTOM; ?>;
    var selectedRatioType = <?php echo $ratio_type; ?>;

    if (selectedRatioType == ratioTypeSquare) {
        $(minWidthLogoEle).val('<?php echo $getShopLogoSquare['width']; ?>');
        $(minHeightLogoEle).val('<?php echo $getShopLogoSquare['height']; ?>');
        $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopLogoSquare['width']; ?> x <?php echo $getShopLogoSquare['height']; ?>'));

    } else if (selectedRatioType == ratioTypeRectangular) {
        $(minWidthLogoEle).val('<?php echo $getShopLogoRactangle['width']; ?>');
        $(minHeightLogoEle).val('<?php echo $getShopLogoRactangle['height']; ?>');
        $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopLogoRactangle['width']; ?> x <?php echo $getShopLogoRactangle['height']; ?>'));

    } else {
        $(minWidthLogoEle).val('');
        $(minHeightLogoEle).val('');
        $('.logoPreferredDimensionsJs').html('');
    }
    $(document).off('change', '#slideScreenJs').on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;
        if ($(this).val() == screenDesktop) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
        } else if ($(this).val() == screenIpad) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');
        } else {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');
        }

        var slide_screen = $(this).val();
        var shop_id = $(this).closest("form").find('input[name="shop_id"]').val();
        var lang_id = $("#imageLanguageJs").val();
        shopImages(shop_id, 'image', slide_screen, lang_id);
    });


    $(document).off('change', '.prefRatio-js').on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $(minWidthLogoEle).val('<?php echo $getShopLogoSquare['width']; ?>');
            $(minHeightLogoEle).val('<?php echo $getShopLogoSquare['height']; ?>');
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopLogoSquare['width']; ?> x <?php echo $getShopLogoSquare['height']; ?>'));
        } else if ($(this).val() == ratioTypeCustom) {
            $(minWidthLogoEle).val('');
            $(minHeightLogoEle).val('');
            $('.logoPreferredDimensionsJs').html('');
        } else {
            $(minWidthLogoEle).val('<?php echo $getShopLogoRactangle['width']; ?>');
            $(minHeightLogoEle).val('<?php echo $getShopLogoRactangle['height']; ?>');
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopLogoRactangle['width']; ?> x <?php echo $getShopLogoRactangle['height']; ?>'));
        }
    });
</script>