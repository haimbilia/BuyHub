<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form');
$frm->setFormTagAttribute('data-callback', 'loadImages(' . $bannerLocationId . ',' . $recordId . ',"logo",' . $slideScreen . ',' . $langId . ')');
$imageLangFld = $frm->getField('lang_id');
if (1 < count($languages)) {
    $imageLangFld->developerTags['colWidthValues'] = [null, '6', null, null];
}
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');
$screenFld = $frm->getField('slide_screen');
if (1 < count($languages)) {
    $screenFld->developerTags['colWidthValues'] = [null, '6', null, null];
}
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');

$imgArr = [];
$imageRecordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $getBannerRatio = ImageDimension::getData(ImageDimension::TYPE_BANNER, ImageDimension::VIEW_THUMB);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Banner',
                'BannerImage',
                array(
                    $recordId,
                    $image['afile_lang_id'],
                    $image['afile_screen'],
                    ImageDimension::VIEW_THUMB,
                ),
                CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime,
            CONF_IMG_CACHE_TIME,
            '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $getBannerRatio[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ];
}

$slideImage = $frm->getField('banner_image');
$slideImage->value = '<span id="imageListingJs"></span>';
$slideImage->value = "<span id='imageListingJs'>" . HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_BANNER_IMAGE", $siteLangId)
    ],
    $siteLangId,
    ($canEdit ? 'deleteMedia(' . $bannerLocationId . ',' . $recordId . ',' . $image['afile_id'] . ',' . $image['afile_type'] . ',' . $image['afile_lang_id'] . ',' . $image['afile_screen'] . ')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
) . "</span>";

$slideImage->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['width'] . ' x ' . $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['height']) . '</span>';

$generalTab = [
    'attr' => [
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId),
        'href' => 'javascript:void(0);',
        'onclick' => 'editRecord(' . $recordId . ',' . $bannerLocationId . ');'
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => false
];

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ',' . $bannerLocationId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ]
];
$formTitle  = Labels::getLabel('LBL_BANNER_SETUP', $siteLangId);
$displayFooterButtons = false;
$activeGentab = '';
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    var minWidthBaneerEle = $('#<?php echo $frm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightBaneerEle = $('#<?php echo $frm->getFormTagAttribute('id'); ?> input[name=min_height]');

    $(minWidthBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
    $(minHeightBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');

    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var getAspectRatioDes = '<?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['aspectRatio']; ?>';


    $(document).off('change', '#slideScreenJs').on('change', '#slideScreenJs', function(e) {
        e.stopPropagation();
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;
        var screenMobile = <?php echo applicationConstants::SCREEN_MOBILE ?>;

        if ($(this).val() == screenDesktop) {

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?> x <?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');


        } else if ($(this).val() == screenIpad) {

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBannerDimensions[ImageDimension::VIEW_TABLET]['width']; ?> x <?php echo $getBannerDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');

        } else {

            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $getBannerDimensions[ImageDimension::VIEW_MOBILE]['width']; ?> x <?php echo $getBannerDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_MOBILE]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $getBannerDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');

        }

        let slideScreen = $(this).val();
        let recordId = $(this).closest("form").find('input[name="banner_id"]').val();
        let bannerLocationId = $(this).closest("form").find('input[name="blocation_id"]').val();
        let langId = $("#imageLanguageJs").val();
        loadImages(bannerLocationId, recordId, 'logo', slideScreen, langId);
    });
</script>