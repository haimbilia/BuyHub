<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$formOnSubmit = 'saveRecord($("#frmCMSPage")); return(false);';
$fld = $frm->getField('cpage_title');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','cpage_id');getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = '<span class="form-text text-muted">' . UrlHelper::generateFullUrl('Cms', 'View', array($recordId), CONF_WEBROOT_FRONT_URL) . '</span>';
$fld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");

$pageLayout = $frm->getField('cpage_layout');
// $pageLayout->setFieldTagAttribute('onchange', "showLayout($(this))");
$displayLangTab = false;
$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'editLangData('.$recordId.','.array_key_first($languages).');',
            'title' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        'isActive' => false
    ],
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

$formTitle = Labels::getLabel('LBL_CONTENT_PAGE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
