<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$headingLabel = $badgeName . ' ' . Labels::getLabel('LBL_BIND_CONDITIONS', $siteLangId);
$listingLabel = $badgeName . ' ' . Labels::getLabel('LBL_CONDITIONS_LIST', $siteLangId);

$data = [
    'siteLangId' => $siteLangId,
    'deleteButton' => false,
    'statusButtons' => false,
    'otherButtons' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'window.history.back();',
                'title' => Labels::getLabel('LBL_BACK', $siteLangId)
            ],
            'label' => '<i class="fas fa-arrow-left"></i>'
        ],
        [
            'attr' => [
                'href' => UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$badgeType, $badgeId]),
                'title' => Labels::getLabel('LBL_BIND_CONDITION', $siteLangId)
            ],
            'label' => '<i class="fa fa-plus"></i>'
        ]
    ]
];

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');