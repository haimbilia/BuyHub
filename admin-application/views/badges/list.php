<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$badgeLbl = (Badge::TYPE_BADGE == $badgeType);
$headingLabel = $badgeLbl ? Labels::getLabel('LBL_MANAGE_BADGES', $adminLangId) : Labels::getLabel('LBL_MANAGE_RIBBONS', $adminLangId);
$listingLabel = $badgeLbl ? Labels::getLabel('LBL_BADGES_LIST', $adminLangId) : Labels::getLabel('LBL_RIBBONS_LIST', $adminLangId);

$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => true,
    'statusButtons' => true,
];

if ($badgeLbl) {
    $data['otherButtons'][] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'form(' . Badge::TYPE_BADGE . ')',
            'title' => Labels::getLabel('LBL_ADD_BADGE', $adminLangId)
        ],
        'label' => '<i class="fa fa-award"></i>'
    ];
} else {
    $data['otherButtons'][] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'form(' . Badge::TYPE_RIBBON . ')',
            'title' => Labels::getLabel('LBL_ADD_RIBBON', $adminLangId)
        ],
        'label' => '<i class="fas fa-shapes"></i>'
    ];
}

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');