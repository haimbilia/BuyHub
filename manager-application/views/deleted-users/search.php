<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $row['user_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'user_id':
                $td->appendElement('plaintext', $tdAttr, $row['user_id']);
                break;
            case 'user_name':
                $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break;
            case 'user_regdate':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime(
                    $row[$key],
                    true,
                    true,
                    FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())
                ), true);
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
            case 'credential_verified':
                $class = (applicationConstants::NO == $row[$key]) ? 'is-verified' : '';
                $img = '<div class="verified '. $class .'"><svg class="svg" >
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
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "restoreUser(" . $row['user_id'] . ")",
                                'title' => Labels::getLabel('LBL_Restore_User', $siteLangId)
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-restore">
                                            </use>
                                        </svg>'
                        ]
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
