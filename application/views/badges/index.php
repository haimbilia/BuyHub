<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_BADGES_&_RIBBONS', $siteLangId);

$fld = $frmSearch->getField('keyword');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$fld->developerTags['col'] = 4;

$fld = $frmSearch->getField('badge_type');
$fld->developerTags['col'] = 2;

$fld = $frmSearch->getField('badge_required_approval');
$fld->developerTags['col'] = 2;

$fld = $frmSearch->getField('btn_submit');
$fld->developerTags['col'] = 2;

$fld = $frmSearch->getField('btn_clear');
$fld->developerTags['col'] = 2;

$actionButtons = true;
$data = [
    'links' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'form(0, ' . Badge::TYPE_BADGE . ')',
                'title' => ''
            ],
            'label' => ''
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'form(0, ' . Badge::TYPE_RIBBON . ')',
                'title' => ''
            ],
            'label' => ''
        ],
    ]
];

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');