<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$headingLabel =  Labels::getLabel('LBL_SUB_USERS', $siteLangId);
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