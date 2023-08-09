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
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="user_ids[]" value=' . $row['user_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'user_name':
                $onclick = $canViewShops && !empty($row['shop_id']) ? 'redirectToShop(' . $row['shop_id'] . ')' : '';
                $title = '';
                if (!empty($row['shop_name'])) {
                    $str = Labels::getLabel('LBL_SHOP:_{SHOP}', $siteLangId);
                    $row['extra_text'] = CommonHelper::replaceStringData($str, ['{SHOP}' => $row['shop_name']]);
                    $title = Labels::getLabel('LBL_CLICK_HERE_TO_VISIT_SHOP_LIST', $siteLangId);
                }
                $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'addVerifiedBadge' => true, 'siteLangId' => $siteLangId, 'onclick' => $onclick, 'title' => $title, 'emailOnClick' => 'sendMailToUser(' . $row['user_id'] . ')'], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'credential_active':
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['user_id'], ($row[$key] ?? 0));
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'user_regdate':
                $date = HtmlHelper::formatDateTime(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                );
                $td->appendElement('plaintext', $tdAttr, $date, true);
                break;
            case 'user_type':
                $str = $this->includeTemplate('users/user-type.php', ['row' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, $str, true);
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
                    $data['editButton'] = [];
                    $data['deleteButton'] = [];

                    $data['dropdownButtons']['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'changeUserPassword(' . $row['user_id'] . ')',
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#password">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId),
                        ],
                        [
                            'attr' => [
                                'href' => UrlHelper::generateUrl('Users', 'login', array($row['user_id'])),
                                'target' => '_blank',
                                'id' => 'redirectJs',
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#login">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_LOGIN_TO_USER_PROFILE', $siteLangId),
                        ], [
                            'attr' => [
                                'href' => 'javascript::void(0)',
                                'onclick' => 'sendMailToUser(' . $row['user_id'] . ')',
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-mail">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_SEND_EMAIL', $siteLangId),
                        ]
                    ];
                    if (0 ==  $row['credential_verified'] && empty($row['credential_verified'])  && empty($row['credential_verified'])) {
                        $data['dropdownButtons']['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'sendSetPasswordEmail(' . $row['user_id'] . ')',
                            ],
                            'label' => '<i class="icn">
                                            <svg class="svg" width="18" height="18">
                                                <use
                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#password-email">
                                                </use>
                                            </svg>
                                        </i>' . Labels::getLabel('LBL_RESEND_SET_PASSWORD_EMAIL', $siteLangId),
                        ];
                    }

                    if (!$row['user_is_buyer']) {
                        $data['dropdownButtons']['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'markSellerAsBuyer(' . $row['user_id'] . ')',
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


                    $data['dropdownButtons']['otherButtons'][] = [
                        'attr' => [
                            'href' => 'javascript:void(0)',
                            'onclick' => 'redirectfunc(fcom.makeUrl("transactions"),{utxn_user_id:' . $row['user_id'] . '})',
                        ],
                        'label' => '<i class="icn">
                                        <svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#sync-currency">
                                            </use>
                                        </svg>
                                    </i>' . Labels::getLabel('LBL_TRANSACTIONS', $siteLangId),
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
    $serialNo++;
}

include(CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
