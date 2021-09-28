<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* Logo Image */
HtmlHelper::formatFormFields($logoFrm);
$logoFld = $logoFrm->getField('logo');
$logoFld->addFieldTagAttribute('onChange', 'loadImageCropper(this)');

$htmlAfterField = '<small class="text--small logoPreferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $adminLangId), '500 x 500') . '</small>';
$htmlAfterField .= '<div id="logoListingJs"></div>';
$logoFld->htmlAfterField = $htmlAfterField;
/* Logo Image */


/* Image Form */
HtmlHelper::formatFormFields($imageFrm);
$imageFld = $imageFrm->getField('image');
$imageFld->addFieldTagAttribute('onChange', 'loadImageCropper(this)');
$htmlAfterField = '<div style="margin-top:15px;" class="preferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $adminLangId), '2000 x 500') . '</div>';
$htmlAfterField .= '<div id="image-listing"></div>';
$imageFld->htmlAfterField = $htmlAfterField;
/* Image Form */

$activeMediatab = true;

require_once(CONF_THEME_PATH . 'brands/form-head.php'); ?>

    <div class="form-edit-body loaderContainerJs">
        <div class="section section--first">
            <h3 class="section__title"><?php echo Labels::getLabel('LBL_LOGO', $adminLangId); ?></h3>
            <div class="section__body">
                <?php echo $logoFrm->getFormHtml(); ?>
            </div>
            <div class="separator separator--border-dashed separator--space-lg"></div>
            <h3 class="section__title"><?php echo Labels::getLabel('LBL_IMAGE', $adminLangId); ?></h3>
            <div class="section__body">
                <?php echo $imageFrm->getFormHtml(); ?>
            </div>
        </div>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php echo Labels::getLabel('LBL_UPDATE', $adminLangId); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('input[name=banner_min_width]').val(2000);
    $('input[name=banner_min_height]').val(500);
    $('input[name=logo_min_width]').val(150);
    $('input[name=logo_min_height]').val(150);
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var aspectRatio = 4 / 1;

    $(document).on('change', '.prefDimensionsJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.preferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
            $('input[name=banner_min_width]').val(2000);
            $('input[name=banner_min_height]').val(500);
            aspectRatio = 4 / 1;
        } else if ($(this).val() == screenIpad) {
            $('.preferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
            $('input[name=banner_min_width]').val(1024);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 128 / 45;
        } else {
            $('.preferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
            $('input[name=banner_min_width]').val(640);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 16 / 9;
        }
    });

    $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $('input[name=logo_min_width]').val(500);
            $('input[name=logo_min_height]').val(500);
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 500'));
        } else {
            $('input[name=logo_min_width]').val(500);
            $('input[name=logo_min_height]').val(280);
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '500 x 280'));
        }
    });
</script>