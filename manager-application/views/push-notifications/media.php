<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'mediaForm(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');

$fld = $frm->getField('pnotification_image');
$fld->value = HtmlHelper::getfileInputHtml(
    [
        'onChange' => 'loadImageCropper(this)',
        'accept' => 'image/*',
        'data-name' => Labels::getLabel("FRM_PUSH_NOTIFICATION_IMAGE", $siteLangId),
        'data-frm'=> $frm->getFormTagAttribute('name')
    ],
    $siteLangId,
    '',
    '',
    [],
    'dropzone-custom dropzoneContainerJs'
);
$htmlAfterField = '<span>' . Labels::getLabel('LBL_SIZE_MUST_BE_LESS_THAN_300KB', $siteLangId) . '</span>';
$htmlAfterField .= '<div id="imageListingJs"></div>';
$fld->htmlAfterField = $htmlAfterField;

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => "editPushNotification(" . $recordId . ", " . $langId . ");",
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => false
];

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => '',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => true
    ]
];

if (User::AUTH_TYPE_GUEST != $userAuthType) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'notifyUsersForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_BIND_USERS_FOR_THIS_NOTIFICATION', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_NOTIFY_TO', $siteLangId),
        'isActive' => false
    ];
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">
    $('input[name=min_width]').val('<?php echo $getNotificationDimensions['width']; ?>');
    $('input[name=min_height]').val('<?php echo $getNotificationDimensions['height']; ?>');
    var getAspectRatio = '<?php echo $getNotificationDimensions[ImageDimension::VIEW_DEFAULT]['aspectRatio']; ?>';
    getAspectRatio = getAspectRatio.split(":");
    if (getAspectRatio) {
        var getAspectRatio = getAspectRatio[0] / getAspectRatio[1];
    } else {
        var getAspectRatio =  1000 / 563;
    }


  
</script>