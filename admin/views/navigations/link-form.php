<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('data-onclear', "addNewLinkForm(" . $nav_id . ", " . $nlink_id . ");");
$frm->setFormTagAttribute('onsubmit', 'setupLink(this); return(false);');

$fld = $frm->getField('nlink_type');
$fld->setFieldTagAttribute('onchange', 'callPageTypePopulate(this)');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('nlink_target');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('nlink_login_protected');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('nlink_display_order');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('nlink_cpage_id');
$fld->setWrapperAttribute('id', 'nlinkCpageIdWrapJs');

$fld = $frm->getField('nlink_category_id');
$fld->setWrapperAttribute('id', 'nlinkCategoryIdWrapJs');

$fld = $frm->getField('nlink_url');
$fld->setWrapperAttribute('id', 'nlinkUrlWrapJs');

$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);
$includeTabs = (0 < count($languages));

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => "addNewLinkForm(" . $nav_id . ", " . $nlink_id . ");",
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => true
];


$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'linkLangForm(' . $nav_id . ', ' . $nlink_id . ', ' . array_key_first($languages) . ')',
            'title' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        'isActive' => false
    ]
];
$displayLangTab = false;
$recordId = $nlink_id;
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        callPageTypePopulate($("select[name='nlink_type']"));
    });
</script>