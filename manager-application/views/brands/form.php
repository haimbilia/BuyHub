<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$identiFierFld = $frm->getField('brand_identifier');
$identiFierFld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','brand_id');
getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$urlFld = $frm->getField('urlrewrite_custom');
$urlFld->setFieldTagAttribute('id', "urlrewrite_custom");
$urlFld->htmlAfterField = "<small class='text--small'>" . UrlHelper::generateFullUrl('Brands', 'View', array($recordId), CONF_WEBROOT_FRONT_URL) . '</small>';
$urlFld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");

$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $adminLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $adminLangId),
        'isActive' => false
    ]
]; 

$formTitle = Labels::getLabel('LBL_BRAND_SETUP', $adminLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');