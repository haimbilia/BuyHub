<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($mediaFrm, 6);
$mediaFrm->setFormTagAttribute('class', 'form form--horizontal');
$mediaFrm->setFormTagAttribute('onsubmit', 'setupPromotionMedia(this); return(false);');

$uploadfld = $mediaFrm->getField('banner_image');
$uploadfld->addFieldTagAttribute('onChange', 'popupImage(this)');

$langFld = $mediaFrm->getField('lang_id');
$langFld->addFieldTagAttribute('class', 'banner-language-js');

$screenFld = $mediaFrm->getField('banner_screen');
$screenFld->addFieldTagAttribute('class', 'banner-screen-js');

$preferredDimensionsStr = '<span class="form-text text-muted uploadimage--info" > ' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), $bannerWidth . ' * ' . $bannerHeight) . '</span>';

$htmlAfterField = $preferredDimensionsStr;
$htmlAfterField .= '<div id="image-listing-js"></div>';
$uploadfld->htmlAfterField = $htmlAfterField;

?>
<div class="col-md-12">
    <?php echo $mediaFrm->getFormHtml(); ?>
</div>
<script>
    $('input[name=banner_min_width]').val(1350);
    $('input[name=banner_min_height]').val(405);
    var aspectRatio = 10 / 3;
    $(document).on('change', '.banner-screen-js', function() {
        var promotionType = <?php echo $promotionType ?>;
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if (promotionType == <?php echo Promotion::TYPE_SLIDES ?>) {
            if ($(this).val() == screenDesktop) {
                $('.uploadimage--info').html((langLbl.preferredDimensions).replace(/%s/g, '1350 * 405'));
                $('input[name=banner_min_width]').val(1350);
                $('input[name=banner_min_height]').val(405);
                aspectRatio = 10 / 3;
            } else if ($(this).val() == screenIpad) {
                $('.uploadimage--info').html((langLbl.preferredDimensions).replace(/%s/g, '1024 * 360'));
                $('input[name=banner_min_width]').val(1024);
                $('input[name=banner_min_height]').val(360);
                aspectRatio = 128 / 45;
            } else {
                $('.uploadimage--info').html((langLbl.preferredDimensions).replace(/%s/g, '640 * 360'));
                $('input[name=banner_min_width]').val(640);
                $('input[name=banner_min_height]').val(360);
                aspectRatio = 16 / 9;
            }
        } else if (promotionType == <?php echo Promotion::TYPE_BANNER ?>) {
            var deviceType = $(this).val();
            fcom.ajax(fcom.makeUrl('Advertiser', 'getBannerLocationDimensions', [<?php echo $promotionId; ?>, deviceType]), '', function(t) {
                var ans = $.parseJSON(t);
                $('.uploadimage--info').html((langLbl.preferredDimensions).replace(/%s/g, ans.bannerWidth + ' * ' + ans.bannerHeight));
                $('input[name=banner_min_width]').val(ans.bannerWidth);
                $('input[name=banner_min_height]').val(ans.bannerHeight);
                if (deviceType == screenDesktop) {
                    aspectRatio = 10 / 3;
                } else if (deviceType == screenIpad) {
                    aspectRatio = 10 / 3;
                } else {
                    aspectRatio = 16 / 9;
                }
            });
        }
    });
</script>