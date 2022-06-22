<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'mediaForm(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('badge_icon');
$fld->value = HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_BADGE_ICON", $siteLangId),
        'data-frm'=> $frm->getFormTagAttribute('name')
    ],
    $siteLangId,
    '',
    '',
    [],
    'dropzone-custom dropzoneContainerJs'
);

$htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_Preferred_Dimensions', $siteLangId), $getBadgeDimensions['width'].' * '.$getBadgeDimensions['height']) . '</span>';
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
    $('input[name=min_width]').val('<?php echo $getBadgeDimensions['width']; ?>');
    $('input[name=min_height]').val('<?php echo $getBadgeDimensions['height']; ?>');
    var aspectRatio = <?php echo $ratioJs; ?>;
</script>