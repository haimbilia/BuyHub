<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$imgArr = [];
if (!empty($image) && isset($image['afile_id']) && $image['afile_id'] != -1) {
    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
    $imageSocialDimensions = ImageDimension::getData(ImageDimension::TYPE_SOCIAL_PLATFORM, ImageDimension::VIEW_THUMB);
    $imgArr = [
        'url' => UrlHelper::getCachedUrl(
            UrlHelper::generateFileUrl(
                'Image',
                'SocialPlatform',
                array(
                    $image['afile_record_id'],
                    ImageDimension::VIEW_THUMB 
                ),
                CONF_WEBROOT_FRONT_URL
            ) . $uploadedTime,
            CONF_IMG_CACHE_TIME,
            '.jpg'
        ),
        'name' => $image['afile_name'],
        'afile_id' => $image['afile_id'],
        'data-aspect-ratio' => $imageSocialDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'],
    ];
}

$frm->addFormTagAttribute('data-callbackfn','mediaFormCallback');

$fld = $frm->getField('image');
$fld->value = '<label class="label">'.Labels::getLabel('LBL_ICON', $siteLangId).'</label>'.HtmlHelper::getfileInputHtml(
    ['onChange' => 'loadImageCropper(this)', 'accept' => 'image/*', 'data-name' => Labels::getLabel("LBL_ICON", $siteLangId)],
    $siteLangId,
    ($canEdit ? 'deleteMedia('.$recordId.')' : ''),
    ($canEdit ? 'editDropZoneImages(this)' : ''),
    $imgArr,
    'mt-3 dropzone-custom dropzoneContainerJs'
);

$fld->htmlAfterField = '<span class="form-text text-muted">'. Labels::getLabel('LBL_THIS_WILL_BE_DISPLAYED_IN_30X30_ON_YOUR_STORE.', $siteLangId).'<br/>'. Labels::getLabel('LBL_SVG_IMAGES_ARE_NOT_SUPPORTED_IN_EMAILS.', $siteLangId) .'</span>';

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