<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_MANAGE_BADGES_&_RIBBONS', $adminLangId);
$listingLabel = Labels::getLabel('LBL_BADGES_LIST', $adminLangId);
$addBadgeLabel = Labels::getLabel('LBL_ADD_BADGE', $adminLangId);
$addRibbonLabel = Labels::getLabel('LBL_ADD_RIBBON', $adminLangId);

$actionButtons = false;
$data = [
    'links' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'form(0, ' . Badge::TYPE_BADGE . ')',
                'title' => $addBadgeLabel
            ],
            'label' => $addBadgeLabel
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'form(0, ' . Badge::TYPE_RIBBON . ')',
                'title' => $addRibbonLabel
            ],
            'label' => $addRibbonLabel
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'toggleBulkStatues(1)',
                'title' => Labels::getLabel('LBL_ACTIVE', $adminLangId)
            ],
            'label' => Labels::getLabel('LBL_ACTIVE', $adminLangId)
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'toggleBulkStatues(0)',
                'title' => Labels::getLabel('LBL_IN_ACTIVE', $adminLangId)
            ],
            'label' => Labels::getLabel('LBL_IN_ACTIVE', $adminLangId)
        ],
    ]
];

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');