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
$fld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '2000 x 500') . '</span>';
$fld->value = '<span id="imageListingJs"></span>';

$imageLangFld = $imageFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

$screenFld = $imageFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');

if (1 < $languageCount) {
    $imageLangFld->developerTags['colWidthValues'] = [null, '6', null, null];
    $screenFld->developerTags['colWidthValues'] = [null, '6', null, null];
}

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

$formTitle = Labels::getLabel('LBL_PRODUCT_CATEGORY_REQUESTS_SETUP', $siteLangId); ?>

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

    /* $(minWidthBaneerEle).val(2000);
    $(minHeightBaneerEle).val(500);
    $(minWidthLogoEle).val(150);
    $(minHeightLogoEle).val(150); */
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;

     $(minWidthBaneerEle).val('<?php  echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['width'];  ?>');
    $(minHeightBaneerEle).val('<?php  echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['height'];  ?>'); 
    $(minWidthLogoEle).val('<?php  echo $getCategoryRequestLogoSquare['width'];  ?>');
    $(minHeightLogoEle).val('<?php  echo $getCategoryRequestLogoSquare['height'];  ?>');

    
    var getAspectRatioDes = '<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['aspectRatio']; ?>';
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

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
            aspectRatio = aspectRatioDes;


          /*   $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
            $(minWidthBaneerEle).val(2000);
            $(minHeightBaneerEle).val(500);
            aspectRatio = 4 / 1; */
        } else if ($(this).val() == screenIpad) {

            var getAspectRatioIpad = '<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_DESKTOP]['aspectRatio']; ?>';
            getAspectRatioIpad = getAspectRatioIpad.split(":");
            if (getAspectRatioIpad) {
                var aspectRatioIpad = getAspectRatioIpad[0] / getAspectRatioIpad[1];
            } else {
                var aspectRatioIpad = 128 / 45;
            }
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');
            aspectRatio = aspectRatioIpad;


            /* $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
            $(minWidthBaneerEle).val(1024);
            $(minHeightBaneerEle).val(360);
            aspectRatio = 128 / 45; */
        } else {

            var getAspectRatioMob = '<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_TABLET]['aspectRatio']; ?>';
            getAspectRatioMob = getAspectRatioMob.split(":");
            if (getAspectRatioMob) {
                var aspectRatioMob = getAspectRatioMob[0] / getAspectRatioMob[1];
            } else {
                var aspectRatioMob = 16 / 9;
            }
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));

            $(minWidthBaneerEle).val('<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getCategoryRequestDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');
            aspectRatio = aspectRatioMob;


           /*  $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
            $(minWidthBaneerEle).val(640);
            $(minHeightBaneerEle).val(360);
            aspectRatio = 16 / 9; */
        }

        var slide_screen = $(this).val();
        var mediaRecordId = $(this).closest("form").find('input[name="prodcat_id"]').val();
        var lang_id = $("#imageLanguageJs").val();
        images(mediaRecordId, 'image', slide_screen, lang_id);
    });


    $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $(minWidthLogoEle).val('<?php echo $getCategoryRequestLogoSquare['width']; ?>');
            $(minHeightLogoEle).val('<?php echo $getCategoryRequestLogoSquare['height']; ?>');
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getCategoryRequestLogoSquare['width']; ?> x <?php echo $getCategoryRequestLogoSquare['height']; ?>'));
        } else {
            $(minWidthLogoEle).val('<?php echo $getCategoryRequestLogoRactangle['width']; ?>');
            $(minHeightLogoEle).val('<?php echo $getCategoryRequestLogoRactangle['height']; ?>');
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getCategoryRequestLogoRactangle['width']; ?> x <?php echo $getCategoryRequestLogoRactangle['height']; ?>'));
        }
    });


   /*  $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $(minWidthLogoEle).val(500);
            $(minHeightLogoEle).val(500);
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 500'));
        } else {
            $(minWidthLogoEle).val(500);
            $(minHeightLogoEle).val(280);
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 280'));
        }
    }); */
</script>