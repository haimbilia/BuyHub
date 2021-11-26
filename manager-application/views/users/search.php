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
                        //$str = $this->includeTemplate('_partial/shop/shop-info-card.php', ['shop' => $row, 'siteLangId' => $siteLangId], false, true);
                        //$td->appendElement('plaintext', $tdAttr, $str, true); 

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
                $date = FatDate::format(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                );
                $htm = '<p class="date">' . $date . '</p>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);
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
                $class = (applicationConstants::NO == $row[$key]) ? 'is-verified' : '';
                $img = '<div class="verified ' . $class . '"><svg class="svg" >
                            <use
                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-verified">
                            </use>
                        </svg>';
                $td->appendElement('plaintext', $tdAttr, $img, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['user_id']
                ];
                if ($canEdit) {
                    $data['dropdownButtons']['editButton'] = [];
                    $data['dropdownButtons']['deleteButton'] = [];

                    $data['dropdownButtons']['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'changeUserPassword(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#password">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId),
                        ],
                        [
                            'attr' => [
                                'href' => UrlHelper::generateUrl('Users', 'login', array($row['user_id'])),
                                'target' => '_blank',
                                'id' => 'redirectJs',
                                'title' => Labels::getLabel('LBL_LOGIN_TO_USER_PROFILE', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#login">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_LOGIN_TO_USER_PROFILE', $siteLangId),
                        ]
                    ];


                    if (!empty($row['credential_email'])) {
                        $data['dropdownButtons']['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'sendMailToUser(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_EMAIL_USER', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#send-email">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_EMAIL_USER', $siteLangId),
                        ];
                    }

                    if (!empty($row['credential_password'])) {
                        $data['dropdownButtons']['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'sendSetPasswordEmail(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_RESEND_SET_PASSWORD_EMAIL', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#password-email">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_RESEND_SET_PASSWORD_EMAIL', $siteLangId),
                        ];
                    }

                    if ($row['user_is_supplier'] && !$row['user_is_buyer']) {
                        $data['dropdownButtons']['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'markSellerAsBuyer(' . $row['user_id'] . ')',
                                'title' => Labels::getLabel('LBL_MARK_AS_BUYER', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-users">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_MARK_AS_BUYER', $siteLangId),
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
