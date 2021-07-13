<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$typeArr = Badge::getTypeArr($siteLangId);
$headingLabel = $badgeName . ' ' . Labels::getLabel('LBL_BIND_CONDITIONS', $siteLangId);
$headingLabel .= ' <span class="label label-inline label-info rounded-pill">' . $typeArr[$badgeType] . '</span>';

$listingLabel = $badgeName . ' ' . Labels::getLabel('LBL_CONDITIONS_LIST', $siteLangId);

$otherButtons = [
    [
        'attr' => [
            'href' => UrlHelper::generateUrl('Badges', 'list', [$badgeType]),
            'title' => Labels::getLabel('LBL_BACK', $siteLangId)
        ],
        'label' => '<i class="fas fa-arrow-left"></i>'
    ]
];

if (Badge::COND_MANUAL == $conditionType) {
    $otherButtons[] = [
        'attr' => [
            'href' => UrlHelper::generateUrl('BadgeLinkConditions', 'conditionForm', [$badgeType, $badgeId]),
            'title' => Labels::getLabel('LBL_BIND_CONDITION', $siteLangId)
        ],
        'label' => '<i class="fa fa-plus"></i>'
    ];
}

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onSubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'form formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 4;

    $fld = $frmSearch->getField('btn_submit');
    if (null != $fld) {
        $fld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
        $fld->developerTags['col'] = 2;
    }

    $fld = $frmSearch->getField('btn_clear');
    if (null != $fld) {
        $fld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
        $fld->setFieldTagAttribute('onClick', 'clearSearch()');
        $fld->developerTags['col'] = 2;
    }
}
require_once(CONF_THEME_PATH . '_partial/index-page-common.php');
