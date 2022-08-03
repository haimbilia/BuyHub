<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($imageFrm);
$imageFrm->setFormTagAttribute('class', 'modal-body form');

$imagFld = $imageFrm->getField('testimonial_image');
$imagFld->value = '<span id="imageListingJs"></span>';

$imageLangFld = $imageFrm->getField('lang_id');
$imageLangFld->addFieldTagAttribute('id', 'imageLanguageJs');


$imgArr = [];
$imageRecordId = $image['afile_record_id'];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imageTestimonialDimensions = ImageDimension::getData(ImageDimension::TYPE_TESTIMONIAL, ImageDimension::VIEW_THUMB);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image', 
                'testimonial', 
                array(
                    $recordId, 
                    $image['afile_lang_id'], 
                    ImageDimension::VIEW_THUMB, 
                    $image['afile_id']
                ), CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageTestimonialDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ]; 
} 
$imagFld->value = "<span id='imageListingJs'>". HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)', 
        'accept' => 'image/*', 
        'data-name' => Labels::getLabel("FRM_PROFILE_IMAGE", $siteLangId)
    ],
    $siteLangId,
    ($canEdit ? 'deleteMedia(' . $recordId . ',' . $image['afile_type'].','.$image['afile_id'].','.$image['afile_screen'].','.$image['afile_lang_id'].')' :''),
    ($canEdit ? 'editDropZoneImages(this)': ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
)."</span>";

$imagFld->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions_%s', $siteLangId), $imageFrm->getField('min_width')->value . ' x ' . $imageFrm->getField('min_height')->value) . '</span>';

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

$formTitle = Labels::getLabel('LBL_TESTIMONIAL_SETUP', $siteLangId); ?>

<?php require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $imageFrm->getFormHtml(); ?>
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->