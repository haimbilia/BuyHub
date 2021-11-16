<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$fld = $langFrm->getField('post_title');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $langFrm->getField('post_author_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
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

$formTitle = Labels::getLabel('LBL_BLOG_POST_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');