<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'mediaForm(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');
$frm->setFormTagAttribute('data-callback', 'mediaForm(' . $recordId . ')');

$iconLangFld = $frm->getField('icon_lang_id');
$iconLangFld->addFieldTagAttribute('class', 'icon-language-js');



$iconFld = $frm->getField('cat_icon');
$iconFld->value ='<div id="icon-imageListingJs"></div>';
$iconFld->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_This_will_be_displayed_in_%s_on_your_store', $siteLangId), '60*60') . '</span>';


$bannerFld = $frm->getField('cat_banner');
$bannerFld ->value ='<div id="banner-imageListingJs"></div>';
$bannerFld->htmlAfterField = '<span class="form-text text-muted preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '2000 x 500') . '</span>';


$fld = $frm->getField('seperator');
$fld->value= '<div class="separator separator-dashed my-4"></div>';

$bannerLangFld = $frm->getField('banner_lang_id');
$bannerLangFld->addFieldTagAttribute('class', 'banner-language-js');

$screenFld = $frm->getField('slide_screen');
$screenFld->addFieldTagAttribute('class', 'prefDimensions-js');

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

$formTitle = Labels::getLabel('LBL_CATEGORY_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>   
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script type="text/javascript">
    $('input[name=banner_min_width]').val(2000);
    $('input[name=banner_min_height]').val(500);
    $('input[name=logo_min_width]').val(150);
    $('input[name=logo_min_height]').val(150);
    var aspectRatio = 4 / 1;
    $(document).on('change', '.prefDimensions-js', function() {
        console.log('vvv')
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
            $('input[name=banner_min_width]').val(2000);
            $('input[name=banner_min_height]').val(500);
            aspectRatio = 4 / 1;
        } else if ($(this).val() == screenIpad) {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
            $('input[name=banner_min_width]').val(1024);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 128 / 45;
        } else {
            $('.preferredDimensions-js').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
            $('input[name=banner_min_width]').val(640);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 16 / 9;
        }
    });
</script>