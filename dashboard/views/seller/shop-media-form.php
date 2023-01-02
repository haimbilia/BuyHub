<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$shopLogoFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
$shopLogoFrm->setFormTagAttribute('class', 'form');
$shopLogoFrm->developerTags['colClassPrefix'] = 'col-md-';
$shopLogoFrm->developerTags['fld_default_col'] = 12;
$ratioFld = $shopLogoFrm->getField('ratio_type');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld = HtmlHelper::configureRadioAsButton($shopLogoFrm, 'ratio_type');

$fld = $shopLogoFrm->getField('shop_logo');
$langFld = $shopLogoFrm->getField('lang_id');
if ($ratioFld && $langFld->fldType != 'hidden') {
    $ratioFld->developerTags['col'] = 6;
    $langFld->developerTags['col'] = 6;
}

$fld->value = '<div class="field-set"><div class="caption-wraper"><label class="field_label">' . Labels::getLabel('LBL_UPLOAD_LOGO', $siteLangId) . '</label></div><div class="field-wraper"><div class="field_cover"><span id="shopLogoHtml"></span></div></div></div>';
$fld->htmlAfterField = '<span class="form-text text-muted logoPreferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '' . $getShopLogoSquare['width'] . ' x ' . $getShopLogoSquare['height'] . '') . '</span>';
$shopBannerFrm->setFormTagAttribute('onsubmit', 'setupShopMedia(this); return(false);');
$shopBannerFrm->setFormTagAttribute('class', 'form');
$shopBannerFrm->developerTags['colClassPrefix'] = 'col-md-';
$shopBannerFrm->developerTags['fld_default_col'] = 12;
$screenFld = $shopBannerFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('class', 'prefDimensions-js');
$langFld = $shopBannerFrm->getField('lang_id');
if ($screenFld && $langFld->fldType != 'hidden') {
    $screenFld->developerTags['col'] = 6;
    $langFld->developerTags['col'] = 6;
}

$fld = $shopBannerFrm->getField('shop_banner');
$fld->value = '<div class="field-set"><div class="caption-wraper"><label class="field_label">' . Labels::getLabel('LBL_UPLOAD_BANNER', $siteLangId) . '</label></div><div class="field-wraper"><div class="field_cover"><span id="shopBannerHtml"></span></div></div></div>';
$fld->htmlAfterField = '<span class="form-text text-muted preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width'] . ' x ' . $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']) . '</span>';

?>

<div class="card-body">
    <div class="row">
        <div id="mediaResponse"></div>
        <div class="col-lg-6">
            <div class="media-block">
                <h5><?php echo Labels::getLabel('LBL_Banner_Setup', $siteLangId); ?></h5>
                <?php echo $shopBannerFrm->getFormHtml(); ?>
                </span>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="media-block">
                <h5><?php echo Labels::getLabel('LBL_Logo_Setup', $siteLangId); ?></h5>
                <?php echo $shopLogoFrm->getFormHtml(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('input[name=banner_min_width]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>);
    $('input[name=banner_min_height]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>);

    $('input[name=logo_min_width]').val(150);
    $('input[name=logo_min_height]').val(150);
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var ratioTypeCustom = <?php echo AttachedFile::RATIO_TYPE_CUSTOM; ?>;

    $(document).on('change', '.prefDimensions-js', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;
        if ($(this).val() == screenDesktop) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $('input[name=banner_min_width]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>);
            $('input[name=banner_min_height]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>);

        } else if ($(this).val() == screenIpad) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $('input[name=banner_min_width]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['width']; ?>);
            $('input[name=banner_min_height]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_TABLET]['height']; ?>);
        } else {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $('input[name=banner_min_width]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>);
            $('input[name=banner_min_height]').val(<?php echo $getShopDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>);
        }
    });

    $(document).on('change', '.prefRatio-js', function() {
        if ($(this).val() == ratioTypeSquare) {
            $('input[name=logo_min_width]').val(<?php echo $getShopLogoSquare['width']; ?>);
            $('input[name=logo_min_height]').val(<?php echo $getShopLogoSquare['height']; ?>);
            $('.logoPreferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopLogoSquare['width']; ?> x <?php echo $getShopLogoSquare['height']; ?>'));
        } else if ($(this).val() == ratioTypeCustom) {
            $('input[name=logo_min_width]').val('');
            $('input[name=logo_min_height]').val('');
            $('.logoPreferredDimensions-js').html('');
        } else {
            $('input[name=logo_min_width]').val(<?php echo $getShopLogoRactangle['width']; ?>);
            $('input[name=logo_min_height]').val(<?php echo $getShopLogoRactangle['height']; ?>);
            $('.logoPreferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getShopLogoRactangle['width']; ?> x <?php echo $getShopLogoRactangle['height']; ?>'));
        }
    });
</script>