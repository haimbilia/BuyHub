<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchUsers(this); return(false);');

$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->developerTags['col'] = 8;
$keyFld->developerTags['noCaptionTag'] = true;

$submitBtnFld = $frmSearch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
$submitBtnFld->developerTags['col'] = 2;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmSearch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$cancelBtnFld->developerTags['col'] = 2;
$cancelBtnFld->developerTags['noCaptionTag'] = true;


$headingLabel =  Labels::getLabel('LBL_Seller_Users', $siteLangId);
$otherButtons[] = [
    'label' => '<i class="fa fa-plus"></i>',
    'attr' => [
        'onclick' => 'addUserForm(0);',
        'title' => Labels::getLabel('LBL_Add_User', $siteLangId)
    ],
];

$data = [
    'otherButtons' => [
        [
            'label' => Labels::getLabel('LBL_Activate', $siteLangId),
            'attr' => [
                'onclick' => 'toggleBulkStatues(1);',
                'title' => Labels::getLabel('LBL_Activate', $siteLangId),
                'class'=>'formActionBtn-js disabled',
            ],
        ],
        [
            'label' => Labels::getLabel('LBL_Deactivate', $siteLangId),
            'attr' => [
                'onclick' => 'toggleBulkStatues(0);',
                'title' => Labels::getLabel('LBL_Deactivate', $siteLangId),
                'class'=>'formActionBtn-js disabled' ,
            ],
        ]
        
    ],
    'siteLangId' => $siteLangId,
    'deleteButton' => false,
    'statusButtons' => false,    
];

require_once(CONF_THEME_PATH . '_partial/index-page-common.php');
?>
