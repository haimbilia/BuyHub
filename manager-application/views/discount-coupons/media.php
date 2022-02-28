<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'mediaForm(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('coupon_image');
$fld->value = HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_DISCOUNT_COUPON_IMAGE", $siteLangId),
        'data-frm'=> $frm->getFormTagAttribute('name')
    ],
    $siteLangId,
    '',
    '',
    [],
    'dropzone-custom dropzoneContainerJs'
);

$htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), ' '.$getImageDimensions['width'].'*'.$getImageDimensions['height'].'') . '</span>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$fld->htmlAfterField = $htmlAfterField;

$langFld = $frm->getField('lang_id');
$langFld->addFieldTagAttribute('onchange', 'loadImages(' . $recordId . ', this.value);');

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
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">

var getAspectRatio = '<?php echo $getImageDimensions[ImageDimension::VIEW_DEFAULT]['aspectRatio']; ?>';

getAspectRatio = getAspectRatio.split(":");
            if (getAspectRatio) {
                var getAspectRatio = getAspectRatio[0] / getAspectRatio[1];
            } else {
                var getAspectRatio = 60 / 60;
            }


    $('input[name=min_width]').val('<?php echo $getImageDimensions['width']; ?>');
    $('input[name=min_height]').val('<?php echo $getImageDimensions['height']; ?>');
    var aspectRatio = getAspectRatio;
</script>