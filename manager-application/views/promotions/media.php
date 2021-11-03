<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($mediaFrm);

$langFld = $mediaFrm->getField('lang_id');
$langFld->addFieldTagAttribute('class', 'language-js');
$screenFld = $mediaFrm->getField('banner_screen');
$screenFld->addFieldTagAttribute('class', 'displayJs');

$fld = $mediaFrm->getField('banner_image');
$fld->htmlAfterField = '<span class="form-text uploadimageInfoJs" > ' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), $bannerWidth . ' * ' . $bannerHeight) . '</span>';

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

$formTitle = Labels::getLabel('LBL_PROMOTION_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $mediaFrm->getFormHtml(); ?>
        <div id="image-listing-js"></div>
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script>
    $(document).on('change', '.displayJs', function() {
        var promotionType = <?php echo $promotionType ?>;
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if (promotionType == <?php echo Promotion::TYPE_SLIDES ?>) {
            if ($(this).val() == screenDesktop) {
                $('.uploadimageInfoJs').html((langLbl.preferredDimensions).replace(/%s/g, '1350 * 405'));
            } else if ($(this).val() == screenIpad) {
                $('.uploadimageInfoJs').html((langLbl.preferredDimensions).replace(/%s/g, '1024 * 360'));
            } else {
                $('.uploadimageInfoJs').html((langLbl.preferredDimensions).replace(/%s/g, '640 * 360'));
            }
        } else if (promotionType == <?php echo Promotion::TYPE_BANNER ?>) {
            var deviceType = $(this).val();
            fcom.ajax(fcom.makeUrl('Promotions', 'getBannerLocationDimensions', [<?php echo $recordId; ?>, deviceType]), '', function(t) {
                var ans = $.parseJSON(t);
                $('.uploadimageInfoJs').html((langLbl.preferredDimensions).replace(/%s/g, ans.bannerWidth + ' * ' + ans.bannerHeight));
            });
        }
    });
</script>