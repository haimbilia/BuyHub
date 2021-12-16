<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setupBanners(this); return(false);');
$frm->addFormTagAttribute('data-onclear', 'bannerForm(' . $recordId . ',' . $collection_type . ')');

$extUrlField = $frm->getField('banner_url');
$extUrlField->addFieldTagAttribute('placeholder', 'http://');

$generalTab['attr']['onclick'] = 'collectionForm(' . $collection_type . ', ' . $collection_layout_type . ', ' . $recordId . ');';

if (!in_array($collection_type, Collections::COLLECTION_WITHOUT_RECORDS)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'recordForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_LINK_RECORDS', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LINK_RECORDS', $siteLangId),
        'isActive' => false
    ];
}

if ($collection_type == Collections::COLLECTION_TYPE_BANNER) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_ADD_BANNER', $siteLangId),
        'isActive' => false
    ];
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'bannerMedia(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNER_MEDIA', $siteLangId),
        'isActive' => false
    ];
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'banners(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_BANNERS_LISTING', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_BANNERS_LISTING', $siteLangId),
        'isActive' => false
    ];
}

if (!in_array($collection_type, Collections::COLLECTION_WITHOUT_MEDIA)) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'collectionMediaForm(' . $recordId . ',' . $collection_type . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ];
}

$includeTabs = ($collection_layout_type != Collections::TYPE_PENDING_REVIEWS1);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');