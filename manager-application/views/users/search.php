<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="user_ids[]" value=' . $row['user_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'user_name':
                $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'shop_name':
                if ($row[$key] != '') {
                    if ($canViewShops) {
                        $td->appendElement('a', array('href' => 'javascript:void(0)', 'onClick' => 'redirectfunc("' . UrlHelper::generateUrl('Shops') . '", ' . $row['shop_id'] . ')'), $row[$key], true);
                    } else {
                        $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                    }
                } else {
                    $td->appendElement('plaintext', $tdAttr, Labels::getLabel('LBL_N/A', $siteLangId), true);
                }
                break;
            case 'credential_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['user_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                                    <label>
                                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['user_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                                        <span class="input-helper"></span>
                                    </label>
                                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'user_regdate':
                $td->appendElement('plaintext', $tdAttr, FatDate::format(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                ));
                break;
            case 'user_is_buyer':
                $class = ($row['user_is_buyer']) ? 'is-check' : '';
                $td->appendElement('plaintext', $tdAttr, '<div class="checkmark ' . $class . '"><img src="' . CONF_WEBROOT_URL . 'images/retina/tick-green.svg" alt=""></div>', true);
                break;
            case 'user_is_supplier':
                $class = ($row['user_is_supplier']) ? 'is-check' : '';
                $td->appendElement('plaintext', $tdAttr, '<div class="checkmark ' . $class . '"><img src="' . CONF_WEBROOT_URL . 'images/retina/tick-green.svg" alt=""></div>', true);
                break;
            case 'user_is_advertiser':
                $class = ($row['user_is_advertiser']) ? 'is-check' : '';
                $td->appendElement('plaintext', $tdAttr, '<div class="checkmark ' . $class . '"><img src="' . CONF_WEBROOT_URL . 'images/retina/tick-green.svg" alt=""></div>', true);
                break;
            case 'user_is_affiliate':
                $class = ($row['user_is_affiliate']) ? 'is-check' : '';
                $td->appendElement('plaintext', $tdAttr, '<div class="checkmark ' . $class . '"><img src="' . CONF_WEBROOT_URL . 'images/retina/tick-green.svg" alt=""></div>', true);
                break;
            case 'user_registered_initially_for':
                $statusHtm = User::getUserTypeHtml($siteLangId, $row[$key]);
                if (0 < $row['user_parent']) {
                    $statusHtm = '<span class="badge badge-info">' . Labels::getLabel('LBL_SUB_USER', $siteLangId) . '</span>';;
                }
                $td->appendElement('plaintext', $tdAttr, $statusHtm, true);
                break;
            case 'credential_verified':
                $statusHtm = User::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtm, true);
                break;

            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['user_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                    $data['deleteButton'] = [];
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'changePasswordForm(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId),
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#password">
                                            </use>
                                        </svg>'
                        ],
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'changePasswordForm(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_LOGIN_TO_USER_PROFILE', $siteLangId),
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#login">
                                            </use>
                                        </svg>'
                        ]
                    ];

                    if (!empty($row['credential_email'])) {
                        $data['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'changePasswordForm(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_EMAIL_USER', $siteLangId),
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#send-email">
                                            </use>
                                        </svg>'
                        ];
                    }
                    
                    if (!empty($row['credential_password'])) {
                        $data['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'sendSetPasswordEmail(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_RESEND_SET_PASSWORD_EMAIL', $siteLangId),
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#password-email">
                                            </use>
                                        </svg>'
                        ];
                    }
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
        }
    }
    $serialNo--;
}

if (count($arrListing) == 0) {
    $tbody->appendElement('tr')->appendElement(
        'td',
        array(
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}
