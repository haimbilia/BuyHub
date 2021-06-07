<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_MANAGE_BADGES_&_RIBBONS', $adminLangId);
$listingLabel = Labels::getLabel('LBL_BADGES_&_RIBBONS_LIST', $adminLangId);
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
                'title' => Labels::getLabel('LBL_PUBLISH', $adminLangId)
            ],
            'label' => Labels::getLabel('LBL_PUBLISH', $adminLangId)
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'toggleBulkStatues(0)',
                'title' => Labels::getLabel('LBL_UNPUBLISH', $adminLangId)
            ],
            'label' => Labels::getLabel('LBL_UNPUBLISH', $adminLangId)
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'deleteSelected()',
                'title' => Labels::getLabel('LBL_DELETE_SELECTED', $adminLangId)
            ],
            'label' => Labels::getLabel('LBL_DELETE_SELECTED', $adminLangId)
        ],
    ]
];

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');