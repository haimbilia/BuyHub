<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$tableHeadAttrArr = [
    'dragdrop' => [
        'width' => '5%'
    ],
    'select_all' => [
        'width' => '10%'
    ],
    'listSerial' => [
        'width' => '10%'
    ],
    'plugin_icon' => [
        'width' => '20%'
    ],
    'plugin_identifier' => [
        'width' => '30%'
    ],
    'plugin_active' => [
        'width' => '15%'
    ],
    'action' => [
        'width' => '10%'
    ],
];

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$allPlugins = $arrListing;
$pluginType = (!empty($allPlugins)) ? (array_shift($allPlugins))['plugin_type'] : '';

if (!in_array($pluginType, Plugin::getSeparateIconTypeArr())) {
    unset($fields['plugin_icon']);
}

$isKingPinType = in_array($pluginType, Plugin::getKingpinTypeArr());

if (!$canEdit || 2 > count($arrListing) || $isKingPinType) {
    unset($fields['dragdrop'], $fields['select_all']);
}

$tableId = "pluginsJs";
require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');

$aspectRatioArr = AttachedFile::getRatioTypeArray($adminLangId);
$msg = '';

$serialNo = 0;
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['plugin_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'dragdrop':
                $td->appendElement('plaintext', $tdAttr, '<svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#drag">
                                                            </use>
                                                        </svg>', true);
                break;
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="plugin_ids[]" value=' . $row['plugin_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'plugin_icon':
                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_PLUGIN_LOGO, $row['plugin_id']);
                $uploadedTime = '';
                $aspectRatio = '';
                if (!empty($fileData)) {
                    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                    $aspectRatio = ($fileData['afile_aspect_ratio'] > 0 && isset($aspectRatioArr[$fileData['afile_aspect_ratio']])) ? $aspectRatioArr[$fileData['afile_aspect_ratio']] : '';
                }

                $imageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'plugin', array($row['plugin_id'], 'ICON'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                $imgHtm = '<img src="' . $imageUrl . '" data-ratio="' . $aspectRatio . '">';
                $td->appendElement('plaintext', $tdAttr, $imgHtm, true);
                break;
            case 'plugin_name':
                $defaultCurrConvAPI = FatApp::getConfig('CONF_DEFAULT_PLUGIN_' . $row['plugin_type'], FatUtility::VAR_INT, 0);
                $htm = '';
                if (!empty($defaultCurrConvAPI) && $row['plugin_id'] == $defaultCurrConvAPI) {
                    $htm = ' <span class="badge badge-success">'  . Labels::getLabel('LBL_DEFAULT', $adminLangId) . '</span>';
                }

                if (in_array($row['plugin_code'], Plugin::PAY_LATER)) {
                    $htm .= ' <span class="badge badge-warning">'  . Labels::getLabel('LBL_PAY_LATER', $adminLangId) . '</span>';
                }
                $td->appendElement('plaintext', $tdAttr, $row[$key] . $htm, true);
                break;
            case 'plugin_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['plugin_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                if (!empty($otherPluginTypes) && $canEdit) {
                    if (empty($msg)) {
                        $msg = Labels::getLabel("MSG_TURNING_ON_{PLUGIN-TYPE}_WILL_TURN_OFF_{OTHER-PLUGIN-TYPE}_PLUGINS._DO_YOU_WANT_TO_CONTINUE_?", $adminLangId);
                        $msg = CommonHelper::replaceStringData($msg, ['{PLUGIN-TYPE}' => $pluginTypes[$row['plugin_type']], '{OTHER-PLUGIN-TYPE}' => $otherPluginTypes]);
                    }
                    $statusAct = "changeStatusEitherPluginTypes(this, " . ($row['plugin_active'] > 0 ? 0 : 1) . ", '" . $msg . "')";
                }

                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                                    <label>
                                        <input type="checkbox" id="' . $row['plugin_id'] . '" data-old-status="' . $row[$key] . '" value="' . $row['plugin_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['plugin_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "editSettingForm('" . $row['plugin_code'] . "')",
                                'title' => Labels::getLabel('LBL_SETTINGS', $adminLangId)
                            ],
                            'label' => '<svg class="svg" width="20" height="20">
                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-system-setting">
                                            </use>
                                        </svg>'
                        ],
                    ];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields)
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $adminLangId)
    );
}

$formAction = isset($formAction) ? $formAction : 'toggleBulkStatuses';
$attr = [
    'class' => 'actionButtonsJs',
    'onsubmit' => 'formAction(this, reloadList); return(false);',
    'action' => UrlHelper::generateUrl('Plugins', $formAction),
];
$frm = new Form('listingForm', $attr);
$frm->addHiddenField('', 'plugin_type', $pluginType);
$frm->addHiddenField('', 'status'); ?>

<div class="card-head">
    <h3 class="card-head-label">
        <span class="card-head-title">
            <?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_{PLUGIN-NAME}_PLUGINS', $adminLangId), ['{PLUGIN-NAME}' =>  $pluginTypes[$type]]); ?>
        </span>
        <span class="text-muted">
            <?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_PLUGINS', $adminLangId), ['{PLUGIN-NAME}' =>  $pluginTypes[$type], '{COUNT}' => $recordCount]); ?>
        </span>
    </h3>
    <div class="card-toolbar">
        <?php
        $data = [
            'canEdit' => $canEdit,
            'adminLangId' => $adminLangId,
            'statusButtons' => (1 < count($arrListing) && $canEdit && !$isKingPinType),
        ];
        $this->includeTemplate('_partial/listing/action-buttons.php', $data, false);
        ?>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive listingTableJs">
        <?php
        echo $frm->getFormTag();
        echo $frm->getFieldHtml('plugin_type');
        echo $frm->getFieldHtml('status');
        echo $tbl->getHtml();
        echo '</form>';
        ?>
    </div>
</div>