<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmTestimonial');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#frmTestimonial")); return(false);');

$fld = $frm->getField('testimonial_active');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

$formTitle = Labels::getLabel('LBL_TESTIMONIAL_SETUP', $siteLangId);
$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm('.$recordId.')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
]; 
require_once(CONF_THEME_PATH . '_partial/listing/form.php');