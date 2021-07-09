<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$typeArr = Badge::getTypeArr($adminLangId);
$headingLabel = $badgeName . ' ' . Labels::getLabel('LBL_BIND_CONDITIONS', $adminLangId);
$headingLabel .= ' <span class="badge badge--unified-brand badge--inline badge--pill">' . $typeArr[$badgeType] . '</span>';
$listingLabel = $badgeName . ' ' . Labels::getLabel('LBL_CONDITIONS_LIST', $adminLangId);

$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => true,
    'statusButtons' => false,
    'otherButtons' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'window.history.back();',
                'title' => Labels::getLabel('LBL_BACK', $adminLangId)
            ],
            'label' => '<i class="fas fa-arrow-left"></i>'
        ],
        [
            'attr' => [
                'href' => UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$badgeType, $badgeId]),
                'title' => Labels::getLabel('LBL_BIND_CONDITION', $adminLangId)
            ],
            'label' => '<i class="fa fa-plus"></i>'
        ]
    ]
];

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'web_form formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 4;

    $btn = $frmSearch->getField('btn_clear');
    if (null != $btn) {
        $btn->setFieldTagAttribute('onClick', 'clearSearch()');
    }

    $fld = $frmSearch->getField('blinkcond_user_id');
    if (null != $fld) {
        $fld->setFieldTagAttribute('style', 'width:100%');
    }
}

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');