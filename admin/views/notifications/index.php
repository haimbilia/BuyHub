<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->getField('user_id')->addFieldTagAttribute('id', 'searchFrmUserIdJs');
$actionItemsData['otherButtons'] = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-outline-gray btn-icon toolbarBtnJs disabled',
            'onclick' => "toggleBulkStatues(1, '')",
            'title' => Labels::getLabel('BTN_READ', $siteLangId)
        ],
        'label' => '<svg class="svg btn-icon-start" width="18" height="18">
                                <use
                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#view">
                                </use>
                            </svg><span>' . Labels::getLabel('BTN_READ', $siteLangId) . '</span>',
    ],
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-outline-gray btn-icon toolbarBtnJs disabled',
            'onclick' => "toggleBulkStatues(0, '')",
            'title' => Labels::getLabel('BTN_UNREAD', $siteLangId)
        ],
        'label' => '<svg class="svg btn-icon-start" width="18" height="18">
                                <use
                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#hide">
                                </use>
                            </svg><span>' . Labels::getLabel('BTN_UNREAD', $siteLangId) . '</span>',
    ],

];
require_once(CONF_THEME_PATH . '_partial/listing/index.php');
