<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$badgeLbl = (Badge::TYPE_BADGE == $badgeType);
$headingLabel = $badgeLbl ? Labels::getLabel('LBL_MANAGE_BADGES', $adminLangId) : Labels::getLabel('LBL_MANAGE_RIBBONS', $adminLangId);
$listingLabel = $badgeLbl ? Labels::getLabel('LBL_BADGES_LIST', $adminLangId) : Labels::getLabel('LBL_RIBBONS_LIST', $adminLangId);

$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => true,
    'statusButtons' => true,
    'otherButtons' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'bulkBadgesUnlink(this)',
                'class' => 'deleteSelectedConds--js d-none',
                'title' => Labels::getLabel('LBL_DELETE_SELECTED', $adminLangId)
            ],
            'label' => '<i class="fas fa-trash"></i>'
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'form(' . $badgeType . ')',
                'title' => Labels::getLabel('LBL_ADD', $adminLangId)
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

    $fld = $frmSearch->getField('btn_clear');
    if (null != $fld) {
        $fld->setFieldTagAttribute('onClick', 'clearSearch()');
    }
}

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');