<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($imageFrm);
$imageFrm->setFormTagAttribute('class', 'modal-body form');

$imageLangFld = $imageFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');
$imageLangFld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), '1350 x 405') . '</span>';

$screenFld = $imageFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');


$imgArr = [];
$imageRecordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image', 
                'Slide', 
                array(
                    $recordId, 
                    $image['afile_screen'], 
                    $image['afile_lang_id'], 
                    'THUMB', 
                    false
                ), CONF_WEBROOT_FRONT_URL
                ) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'
            ),
            'name' => $image['afile_name'],
            'afile_id' => $image['afile_id'],
        ]; 
    } 

$slideImage = $imageFrm->getField('slide_image');
$slideImage->value = '<span id="imageListingJs"></span>';
$slideImage->value = "<span id='imageListingJs'>". HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)', 
        'accept' => 'image/*', 
        'data-name' => Labels::getLabel("FRM_SLIDE_IMAGE", $siteLangId)
    ],
    $siteLangId,
    ($canEdit ? 'deleteMedia('.$recordId.','. $image['afile_id'].','.$image['afile_type'].','.$image['afile_lang_id'].','.$image['afile_screen'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
)."</span>";

/* Image Form */

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm('.$recordId.')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ]
];

$formTitle = Labels::getLabel('LBL_SHOP_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $imageFrm->getFormHtml(); ?>
    </div>
</div> 


<script>
    var minWidthBaneerEle = $('#<?php echo $imageFrm->getFormTagAttribute('id');?> input[name=min_width]');
    var minHeightBaneerEle = $('#<?php echo $imageFrm->getFormTagAttribute('id');?> input[name=min_height]');

    $(minWidthBaneerEle).val(2000);
    $(minHeightBaneerEle).val(500);
    var ratioTypeSquare = <?php echo AttachedFile::RATIO_TYPE_SQUARE; ?>;
    var ratioTypeRectangular = <?php echo AttachedFile::RATIO_TYPE_RECTANGULAR; ?>;
    var aspectRatio = 4 / 1;
    $(document).on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '2000 x 500'));
            $(minWidthBaneerEle).val(2000);
            $(minHeightBaneerEle).val(500);
            aspectRatio = 4 / 1;
        } else if ($(this).val() == screenIpad) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '1024 x 360'));
            $(minWidthBaneerEle).val(1024);
            $(minHeightBaneerEle).val(360);
            aspectRatio = 128 / 45;
        } else {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '640 x 360'));
            $(minWidthBaneerEle).val(640);
            $(minHeightBaneerEle).val(360);
            aspectRatio = 16 / 9;
        }

        let slideScreen = $(this).val();
        let recordId = $(this).closest("form").find('input[name="slide_id"]').val();
        let langId = $("#imageLanguageJs").val();
        console.log(recordId, 'THUMB', langId, slideScreen);
        loadImages(recordId, 'THUMB', slideScreen, langId);
    });

</script>