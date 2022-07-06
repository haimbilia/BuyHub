<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* Logo Image */
HtmlHelper::formatFormFields($logoFrm);

$logoFrm->setFormTagAttribute('class', 'form modalFormJs');

$logoLangFld = $logoFrm->getField('lang_id');
$logoLangFld->addFieldTagAttribute('id', 'logoLanguageJs');

$ratioFld = $logoFrm->getField('ratio_type');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld = HtmlHelper::configureRadioAsButton($logoFrm, 'ratio_type');

$fld = $logoFrm->getField('heading');
$fld->developerTags['fieldWrapperRowExtraClass'] = 'form-group mb-3';
$fld->value = '<h5>' . Labels::getLabel('LBL_LOGO', $siteLangId) . '</h5>';

$fld = $logoFrm->getField('logo');
$fld->htmlAfterField = '<span class="form-text text-muted logoPreferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '' . $getBrandRequestLogoSquare['width'] . ' x ' . $getBrandRequestLogoSquare['width'] . '') . '</span>';
$fld->value = '<span id="logoListingJs"></span>';

$ratioFld->attachField($fld);

/* Logo Image */


/* Image Form */
HtmlHelper::formatFormFields($bannerFrm);
$bannerFrm->setFormTagAttribute('class', 'modal-body form');

$fld = $bannerFrm->getField('heading');
$fld->developerTags['fieldWrapperRowExtraClass'] = 'form-group mb-3';
$fld->value = '<h5>' . Labels::getLabel('LBL_BANNER', $siteLangId) . '</h5>';

$fld = $bannerFrm->getField('banner');
$fld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width'] . ' x ' . $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']) . '</span>';
$fld->value = '<span id="imageListingJs"></span>';

$imageLangFld = $bannerFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');

$screenFld = $bannerFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');

if (1 < count($languages)) {
    $imageLangFld->developerTags['colWidthValues'] = [null, '6', null, null];
    $screenFld->developerTags['colWidthValues'] = [null, '6', null, null];
}
/* Image Form */
$mediaTabActive = true;
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) ? Labels::getLabel('LBL_Request_New_Brand', $siteLangId) : Labels::getLabel('LBL_New_Brand', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <?php require_once(CONF_THEME_PATH . '/seller-requests/_partial/brand-request/top-nav.php'); ?>
    <div class="form-edit-body loaderContainerJs" id="brandReqFormJs">
        <?php echo $logoFrm->getFormHtml(); ?>
        <div class="separator separator-dashed my-4"></div>
        <?php echo $bannerFrm->getFormHtml(); ?>
    </div>
</div>

<script>
    var minWidthLogoEle = $('#<?php echo $logoFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightLogoEle = $('#<?php echo $logoFrm->getFormTagAttribute('id'); ?> input[name=min_height]');
    var minWidthBaneerEle = $('#<?php echo $bannerFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightBaneerEle = $('#<?php echo $bannerFrm->getFormTagAttribute('id'); ?> input[name=min_height]');

    $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width'];  ?>');
    $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;

    var selectedRatioType = <?php echo $ratio_type; ?>;
    if (selectedRatioType == ratioTypeSquare) {
        $(minWidthLogoEle).val('<?php echo $getBrandRequestLogoSquare['width']; ?>');
        $(minHeightLogoEle).val('<?php echo $getBrandRequestLogoSquare['height']; ?>');
        $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestLogoSquare['width']; ?> x <?php echo $getBrandRequestLogoSquare['height']; ?>'));

    } else {
        $(minWidthLogoEle).val('<?php echo $getBrandRequestLogoRactangle['width']; ?>');
        $(minHeightLogoEle).val('<?php echo $getBrandRequestLogoRactangle['height']; ?>');
        $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestLogoRactangle['width']; ?> x <?php echo $getBrandRequestLogoRactangle['height']; ?>'));
    }

    $(document).off('change', '#slideScreenJs').on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');

        } else if ($(this).val() == screenIpad) {

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');

        } else {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBrandRequestDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');

        }

        var slide_screen = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        var lang_id = $("#imageLanguageJs").val();
        brandImages(brand_id, 'image', slide_screen, lang_id);
    });

    $(document).off('change', '.prefRatio-js').on('change', '.prefRatio-js', function() {
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

    $(document).off('change', '#logoLanguageJs').on('change', '#logoLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        brandImages(brand_id, 'logo', 1, lang_id);
    });

    $(document).off('change', '#imageLanguageJs').on('change', '#imageLanguageJs', function () {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="brand_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        brandImages(brand_id, 'image', slide_screen, lang_id);
    }); 
</script>