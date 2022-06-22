<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('splatform_active');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$fld = $frm->getField('splatform_icon_class');
$fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('FRM_IF_YOU_HAVEN`T_UPLOADED_ICON_MEDIA_THEN_DEFAULT_ICON_IS_DISPLAYED_AS_PER_SELECTED_PLATFORM.', $siteLangId) . '</span>';

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];

$formTitle = Labels::getLabel('LBL_SOCIAL_PLATFORM_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
