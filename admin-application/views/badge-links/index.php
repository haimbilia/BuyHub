<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_MANAGE_BADGE_LINKS', $adminLangId);
$listingLabel = Labels::getLabel('LBL_BADGE_LINKS_LIST', $adminLangId);
$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => false,
    'statusButtons' => false,
    'otherButtons' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'form(0)',
                'title' => Labels::getLabel('LBL_BIND_BADGE_LINKS', $adminLangId)
            ],
            'label' => '<i class="fas fa-plus"></i>'
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'bulkBadgesUnlink()',
                'title' => Labels::getLabel('LBL_DELETE_SELECTED', $adminLangId)
            ],
            'label' => '<i class="fas fa-trash"></i>'
        ],
    ]
];

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');