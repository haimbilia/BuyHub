<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$headingLabel = Labels::getLabel('LBL_MANAGE_RATING_TYPES', $adminLangId);
$listingLabel = Labels::getLabel('LBL_RATING_TYPES_LIST', $adminLangId);
$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => false,
    'otherButtons' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'ratingTypesForm(0)',
                'title' => Labels::getLabel('LBL_ADD_RATING_TYPE', $adminLangId)
            ],
            'label' => '<i class="fas fa-plus"></i>'
        ],
    ]
];

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'web_form formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 6;

    $btn = $frmSearch->getField('btn_clear');
    if (null != $btn) {
        $btn->setFieldTagAttribute('onClick', 'clearSearch()');
    }
}

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');
