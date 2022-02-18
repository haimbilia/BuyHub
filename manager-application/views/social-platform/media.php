<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image',
                'SocialPlatform',
                array(
                    $image['afile_record_id'],
                    "THUMB" 
                ),
                CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime,
            CONF_IMG_CACHE_TIME,
            '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
    ];
}

$frm->addFormTagAttribute('data-callbackfn','mediaFormCallback');

$fld = $frm->getField('image');
$fld->value = HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("FRM_BANNER_IMAGE", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteMedia('.$recordId.')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);

// $htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), '1000*563') . '</span>';
// $htmlAfterField .= '<div id="imageListingJs"></div>';
// $fld->htmlAfterField = $htmlAfterField;



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

$formTitle = Labels::getLabel('LBL_SOCIAL_PLATFORM_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>