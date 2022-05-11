<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* Logo Image */
HtmlHelper::formatFormFields($logoFrm);
$logoFrm->setFormTagAttribute('class', 'modal-body form');

$logoLangFld = $logoFrm->getField('lang_id');
$logoLangFld->addFieldTagAttribute('id', 'logoLanguageJs');

$fld = $logoFrm->getField('heading');
$fld->value = '<h3 class="h3">' . Labels::getLabel('LBL_LOGO', $siteLangId) . '</h3>';

$fld = $logoFrm->getField('logo');
$fld->htmlAfterField = '<span class="form-text text-muted logoPreferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '500 x 500') . '</span>';
$fld->value = '<span id="logoListingJs"></span>';
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

    $(minWidthLogoEle).val('<?php echo $logoDimensions['width']; ?>');
    $(minHeightLogoEle).val('<?php echo $logoDimensions['height']; ?>');

    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;

    $(minWidthBaneerEle).val('<?php  echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['width'];  ?>');
    $(minHeightBaneerEle).val('<?php  echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['height'];  ?>'); 
 
    
    var getAspectRatioDes = '<?php echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['aspectRatio']; ?>';
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
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $bannerDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
        
        } else if ($(this).val() == screenIpad) {

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $bannerDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $bannerDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $bannerDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $bannerDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');
        

        } else {          
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $bannerDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $bannerDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $bannerDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $bannerDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');

        }

        var slide_screen = $(this).val();
        var mediaRecordId = $(this).closest("form").find('input[name="prodcat_id"]').val();
        var lang_id = $("#imageLanguageJs").val();
        images(mediaRecordId, 'image', slide_screen, lang_id);
    });
    
</script>