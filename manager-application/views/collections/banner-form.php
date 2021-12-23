<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setupBanners($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');
$frm->addFormTagAttribute('data-onclear', 'bannerForm(' . $collectionId . ',' . $recordId . ')');

$fld = $frm->getField('banner_title');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('banner_target');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$extUrlField = $frm->getField('banner_url');
$extUrlField->addFieldTagAttribute('placeholder', 'http://');

$languages = $languages ?? [];
unset($languages[CommonHelper::getDefaultFormLangId()]);

$displayLangTab = false;

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'banners(' . $collectionId . ')',
        'title' => Labels::getLabel('LBL_BANNERS', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_BANNERS', $siteLangId),
    'isActive' => false
];

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => 'bannerForm(' . $collectionId . ',' . $recordId . ')',
        'title' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId),
    'isActive' => true,
    'isDisabled' => false,
];

if (!empty($languages)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerLangForm(' . $collectionId . ',' . $recordId . ',' . array_key_first($languages) . ')',
            'title' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNER_LANG_DATA', $siteLangId),
        'isActive' => false
    ];
}

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'bannerMediaForm(' . $collectionId . ',' . $recordId . ')',
        'title' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
    'isActive' => false
];


$includeTabs = ($collection_layout_type != Collections::TYPE_PENDING_REVIEWS1);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
