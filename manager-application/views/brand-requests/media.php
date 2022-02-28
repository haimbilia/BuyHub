<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* Logo Image */
HtmlHelper::formatFormFields($logoFrm);
$logoFrm->setFormTagAttribute('class', 'modal-body form');

$logoLangFld = $logoFrm->getField('lang_id');
$logoLangFld->addFieldTagAttribute('id', 'logoLanguageJs');

$ratioFld = $logoFrm->getField('ratio_type');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld = HtmlHelper::configureRadioAsButton($logoFrm, 'ratio_type');

$fld = $logoFrm->getField('heading');
$fld->value = '<h3 class="h3">' . Labels::getLabel('LBL_LOGO', $siteLangId) . '</h3>';

$fld = $logoFrm->getField('logo');
$fld->htmlAfterField = '<span class="form-text text-muted logoPreferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '500 x 500') . '</span>';
$fld->value = '<span id="logoListingJs"></span>';

$ratioFld->attachField($fld);

/* Logo Image */


/* Image Form */
HtmlHelper::formatFormFields($imageFrm);
$imageFrm->setFormTagAttribute('class', 'modal-body form');

$fld = $imageFrm->getField('heading');
$fld->value = '<h3 class="h3">' . Labels::getLabel('LBL_BANNER', $siteLangId) . '</h3>';

$fld = $imageFrm->getField('banner');
$fld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width'] . ' x ' . $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']) . '</span>';
$fld->value = '<span id="imageListingJs"></span>';

$imageLangFld = $imageFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

$screenFld = $imageFrm->getField('slide_screen');
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

$formTitle = Labels::getLabel('LBL_PRODUCT_BRAND_REQUEST_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <?php echo $logoFrm->getFormHtml(); ?>
    <div class="separator separator-dashed my-4"></div>
    <?php echo $imageFrm->getFormHtml(); ?>
</div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script>
    var minWidthLogoEle = $('#<?php echo $logoFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightLogoEle = $('#<?php echo $logoFrm->getFormTagAttribute('id'); ?> input[name=min_height]');
    var minWidthBaneerEle = $('#<?php echo $imageFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightBaneerEle = $('#<?php echo $imageFrm->getFormTagAttribute('id'); ?> input[name=min_height]');

   $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width'];  ?>');
    $(minHeightBaneerEle).val('<?php  echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'); 
     $(minWidthLogoEle).val('<?php  echo $getBrandRequestLogoSquare[ImageDimension::VIEW_DEFAULT]['width']; ?>');
    $(minHeightLogoEle).val('<?php  echo $getBrandRequestLogoSquare[ImageDimension::VIEW_DEFAULT]['height']; ?>'); 
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;

    var getAspectRatioDes = '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['aspectRatio']; ?>';
    getAspectRatioDes = getAspectRatioDes.split(":");
    if (getAspectRatioDes) {
        var aspectRatioDes = getAspectRatioDes[0] / getAspectRatioDes[1];
    } else {
        var aspectRatioDes = 4 / 1;
    }


    var aspectRatio = 4 / 1;
    $(document).on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
            aspectRatio = aspectRatioDes;
        } else if ($(this).val() == screenIpad) {
            var getAspectRatioIpad = '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['aspectRatio']; ?>';
            getAspectRatioIpad = getAspectRatioIpad.split(":");
            if (getAspectRatioIpad) {
                var aspectRatioIpad = getAspectRatioIpad[0] / getAspectRatioIpad[1];
            } else {
                var aspectRatioIpad = 128 / 45;
            }
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');
            aspectRatio = aspectRatioIpad;
           
        } else {
            var getAspectRatioMob = '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['aspectRatio']; ?>';
            getAspectRatioMob = getAspectRatioMob.split(":");
            if (getAspectRatioMob) {
                var aspectRatioMob = getAspectRatioMob[0] / getAspectRatioMob[1];
            } else {
                var aspectRatioMob = 16 / 9;
            }
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));

            $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');
            aspectRatio = aspectRatioMob;


           
        }

        var slide_screen = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        var lang_id = $("#imageLanguageJs").val();
        brandImages(brand_id, 'image', slide_screen, lang_id);
    });

    $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $(minWidthLogoEle).val('<?php echo $getBrandRequestLogoSquare['width']; ?>');
            $(minHeightLogoEle).val('<?php echo $getBrandRequestLogoSquare['height']; ?>');
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestLogoSquare['width']; ?> x <?php echo $getBrandRequestLogoSquare['height']; ?>'));
        } else {
            $(minWidthLogoEle).val('<?php echo $getBrandRequestLogoRactangle['width']; ?>');
            $(minHeightLogoEle).val('<?php echo $getBrandRequestLogoRactangle['height']; ?>');
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestLogoRactangle['width']; ?> x <?php echo $getBrandRequestLogoRactangle['height']; ?>'));
        }
    });
</script>