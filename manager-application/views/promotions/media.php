<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($mediaFrm);

$mediaFrm->setFormTagAttribute('class', 'modal-body form');
$langFld = $mediaFrm->getField('lang_id');
$langFld->addFieldTagAttribute('class', 'languageJs');
$screenFld = $mediaFrm->getField('banner_screen');
$screenFld->addFieldTagAttribute('class', 'displayJs');

$fld = $mediaFrm->getField('banner_image');
$fld->value = '<span id="imageListingJs"></span>';

$fld->htmlAfterField = '<span class="form-text text-muted logoPreferredDimensionsJs"></span>';

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'promotionMediaForm(' . $recordId . ', 0, ' . applicationConstants::SCREEN_DESKTOP . ')',
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
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script>
    $(document).on('change', '.displayJs', function() {
        var promotionType = <?php echo $promotionType ?>;
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if (promotionType == <?php echo Promotion::TYPE_SLIDES ?>) {
            if ($(this).val() == screenDesktop) {
                $('input[name=min_width]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_DESKTOP]['width'];?>);
                $('input[name=min_height]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_DESKTOP]['height'];?>);               
                
            } else if ($(this).val() == screenIpad) {
                $('input[name=min_width]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_DESKTOP]['width'];?>);
                $('input[name=min_height]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_TABLET]['height'];?>); 
            } else {
                $('input[name=min_width]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_MOBILE]['width'];?>);
                $('input[name=min_height]').val(<?php echo $silesScreenDimensions[ImageDimension::VIEW_MOBILE]['height'];?>);                
            }
            $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, $('input[name=min_width]').val() +' * '+ $('input[name=min_height]').val()));
        } else if (promotionType == <?php echo Promotion::TYPE_BANNER ?>) {
            var deviceType = $(this).val();
            fcom.ajax(fcom.makeUrl('Promotions', 'getBannerLocationDimensions', [<?php echo $recordId; ?>, deviceType]), '', function(t) {
                var ans = $.parseJSON(t);
                $('.logoPreferredDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, ans.bannerWidth + ' * ' + ans.bannerHeight));
            });
        }
    });
    $('.displayJs').trigger('change');
</script>