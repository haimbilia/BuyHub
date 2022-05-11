<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($imageFrm);
$imageFrm->setFormTagAttribute('class', 'modal-body form');

$fld = $imageFrm->getField('slide_screen');
if (1 < $languageCount) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$imageLangFld = $imageFrm->getField('lang_id');
$imageLangFld->developerTags['colWidthValues'] = [null, '6', null, null];
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');


$screenFld = $imageFrm->getField('slide_screen');
$screenFld->addFieldTagAttribute('id', 'slideScreenJs');
$screenFld->htmlAfterField = '<span class="form-text text-muted prefDimensionsJs">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $slideDimensions[ImageDimension::VIEW_DESKTOP]['width'] .
" x " . $slideDimensions[ImageDimension::VIEW_DESKTOP]['height']) . '</span>';

$imgArr = [];
$imageRecordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imageSlideDimensions = ImageDimension::getData(ImageDimension::TYPE_SLIDE, ImageDimension::VIEW_THUMB);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image',
                'Slide',
                array(
                    $recordId,
                    $image['afile_screen'],
                    $image['afile_lang_id'],
                    ImageDimension::VIEW_THUMB,
                    false
                ),
                CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime,
            CONF_IMG_CACHE_TIME,
            '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageSlideDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ];
}

$slideImage = $imageFrm->getField('slide_image');
$slideImage->value = '<span id="imageListingJs"></span>';
$slideImage->value = "<span id='imageListingJs'>" . HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_SLIDE_IMAGE", $siteLangId)
    ],
    $siteLangId,
    ($canEdit ? 'deleteMedia(' . $recordId . ',' . $image['afile_id'] . ',' . $image['afile_type'] . ',' . $image['afile_lang_id'] . ',' . $image['afile_screen'] . ')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
) . "</span>";

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

$formTitle = Labels::getLabel('LBL_SLIDE_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $imageFrm->getFormHtml(); ?>
    </div>
</div>


<script>
    var minWidthBaneerEle = $('#<?php echo $imageFrm->getFormTagAttribute('id'); ?> input[name=min_width]');
    var minHeightBaneerEle = $('#<?php echo $imageFrm->getFormTagAttribute('id'); ?> input[name=min_height]');

    $(minWidthBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
    $(minHeightBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
  
   
    $(document).on('change', '#slideScreenJs', function() {
        var screenDesktop = <?php echo applicationConstants::SCREEN_DESKTOP ?>;
        var screenIpad = <?php echo applicationConstants::SCREEN_IPAD ?>;

        if ($(this).val() == screenDesktop) {          
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $slideDimensions[ImageDimension::VIEW_DESKTOP]['width'] .
                                        " x " . $slideDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_DESKTOP]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_DESKTOP]['height']; ?>');
           
        } else if ($(this).val() == screenIpad) {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $slideDimensions[ImageDimension::VIEW_TABLET]['width'] .
                                        " x " . $slideDimensions[ImageDimension::VIEW_TABLET]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_TABLET]['width']; ?>');
            $(minHeightBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_TABLET]['height']; ?>');
          
        } else {
            $('.prefDimensionsJs').html((langLbl.preferredDimensions).replace(/%s/g, '<?php echo $slideDimensions[ImageDimension::VIEW_MOBILE]['width'] .
                                        " x " . $slideDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>'));
            $(minWidthBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');
            $(minHeightBaneerEle).val('<?php echo $slideDimensions[ImageDimension::VIEW_MOBILE]['height']; ?>');
           
        }

        let slideScreen = $(this).val();
        let recordId = $(this).closest("form").find('input[name="slide_id"]').val();
        let langId = $("#imageLanguageJs").val();
        loadImages(recordId, 'THUMB', slideScreen, langId);
    });
</script>