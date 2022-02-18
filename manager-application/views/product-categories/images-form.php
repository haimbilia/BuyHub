<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'catMediaForm(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-callback', 'catMediaForm(' . $recordId . ')');

$iconLangFld = $frm->getField('icon_lang_id');
$iconLangFld->addFieldTagAttribute('class', 'catIconLanguageJs');

$fld = $frm->getField('heading_icon');
$fld->value = '<h3 class="h3">' . Labels::getLabel('LBL_ICON', $siteLangId) . '</h3>';

if($isParent){
    $fld = $frm->getField('heading_thumb');
    $fld->value = '<h3 class="h3">' . Labels::getLabel('LBL_THUMB', $siteLangId) . '</h3>';
    
}

$fld = $frm->getField('heading_banner');
$fld->value = '<h3 class="h3">' . Labels::getLabel('LBL_BANNER', $siteLangId) . '</h3>';

$iconFld = $frm->getField('cat_icon');
$iconFld->value = '<div id="icon-imageListingJs"></div>';
$iconFld->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_This_will_be_displayed_in_%s_on_your_store', $siteLangId), '60*60') . '</span>';


$bannerFld = $frm->getField('cat_banner');
$bannerFld->value = '<div id="banner-imageListingJs"></div>';
$bannerFld->htmlAfterField = '<span class="form-text text-muted preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '2000 x 500') . '</span>';

if($isParent){
$thumbFld = $frm->getField('cat_thumb');
$thumbFld->value = '<div id="thumb-imageListingJs"></div>';
$thumbFld->htmlAfterField = '<span class="form-text text-muted preferredDimensions-js">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '300 x 300') . '</span>';

}


$fld = $frm->getField('seperator');
$fld->value = '<div class="separator separator-dashed my-4"></div>';

if($isParent){
$fld = $frm->getField('seperatorthumb');
$fld->value = '<div class="separator separator-dashed my-4"></div>';
}
$bannerLangFld = $frm->getField('banner_lang_id');
$bannerLangFld->addFieldTagAttribute('class', 'catBannerLanguageJs');

if($isParent){
$thumbLangFld = $frm->getField('thumb_lang_id');
$thumbLangFld->addFieldTagAttribute('class', 'thumb-language-js');

}
$screenFld = $frm->getField('slide_screen');
$screenFld->addFieldTagAttribute('class', 'catPrefDimensionsJs');

if (1 < $languageCount) {
    $bannerLangFld->developerTags['colWidthValues'] = [null, '6', null, null];
    $screenFld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'catMediaForm(' . $recordId . ')',
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
    $('input[name=thumb_min_width]').val(300);
    $('input[name=thumb_min_height]').val(300);
    var aspectRatio = 4 / 1;
    $(document).on('change', '.catPrefDimensionsJs', function() {       
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