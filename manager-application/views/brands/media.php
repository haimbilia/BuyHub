<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* Logo Image */
HtmlHelper::formatFormFields($logoFrm);
$logoFld = $logoFrm->getField('logo');
$logoFrm->setFormTagAttribute('class', 'modal-body form');
$logoFld->addFieldTagAttribute('onChange', 'logoPopupImage(this)');
$logoFld->developerTags['colWidthValues'] = [null, '6', null, null];
$logoFld->htmlAfterField = '<small class="text--small logoPreferredDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '500 x 500') . '</small>';

$logoLangFld = $logoFrm->getField('lang_id');
$logoLangFld->addFieldTagAttribute('id', 'logoLanguageJs');

$ratioFld = $logoFrm->getField('ratio_type');
$ratioFld->addOptionListTagAttribute('class', 'list-radio');
$ratioFld->addFieldTagAttribute('class', 'prefRatio-js');
$ratioFld->developerTags['colWidthValues'] = [null, '6', null, null];

HtmlHelper::configureRadioAsButton($logoFrm,'ratio_type');

$fld = $logoFrm->getField('logo_html');
$fld->value = '<div id="logoListingJs"></div>';

/* Logo Image */


/* Image Form */
HtmlHelper::formatFormFields($imageFrm);
$imageFld = $imageFrm->getField('image');
$imageFrm->setFormTagAttribute('class', 'modal-body form');
$imageFld->addFieldTagAttribute('onChange', 'bannerPopupImage(this)');
$htmlAfterField = '<div style="margin-top:15px;" class="prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '2000 x 500') . '</div>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$imageFld->htmlAfterField = $htmlAfterField;

$imageLangFld = $imageFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');


$screenFld = $imageFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');
/* Image Form */

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

$formTitle = Labels::getLabel('LBL_BRAND_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <?php echo $logoFrm->getFormHtml(); ?>
    <div class="separator separator-dashed my-4"></div>
    <?php echo $imageFrm->getFormHtml(); ?>
</div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->

<script>
    $('input[name=banner_min_width]').val(2000);
    $('input[name=banner_min_height]').val(500);
    $('input[name=logo_min_width]').val(150);
    $('input[name=logo_min_height]').val(150);
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var aspectRatio = 4 / 1;
    $(document).on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
            $('input[name=banner_min_width]').val(2000);
            $('input[name=banner_min_height]').val(500);
            aspectRatio = 4 / 1;
        } else if ($(this).val() == screenIpad) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
            $('input[name=banner_min_width]').val(1024);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 128 / 45;
        } else {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
            $('input[name=banner_min_width]').val(640);
            $('input[name=banner_min_height]').val(360);
            aspectRatio = 16 / 9;
        }

        var slide_screen = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="banner_id"]').val();
        var lang_id = $("#imageLanguageJs").val();
        brandImages(brand_id, 'image', slide_screen, lang_id);
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

    $(document).on('change', '#logoLanguageJs', function() {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="banner_id"]').val();
        brandMediaForm(brand_id, lang_id, 1);
        brandImages(brand_id, 'logo', 1, lang_id);
    });
    $(document).on('change', '#imageLanguageJs', function() {
        var lang_id = $(this).val();
        var brand_id = $(this).closest("form").find('input[name="banner_id"]').val();
        var slide_screen = $("#slideScreenJs").val();
        brandImages(brand_id, 'image', slide_screen, lang_id);
    });
</script>