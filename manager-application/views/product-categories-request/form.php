<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$fld = $frm->getField('prodcat_name');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','prodcat_id');
getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('prodcat_id');
$fld->setFieldTagAttribute('id', "prodcat_id");

$fld = $frm->getField('prodcat_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true; 

$fld = $frm->getField('prodcat_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true; 
 
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

$formTitle = Labels::getLabel('LBL_PRODUCT_CATEGORY_REQUESTS_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');