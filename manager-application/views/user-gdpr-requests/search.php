<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page - 1) * $pageSize + 1;
foreach ($arrListing as $sn => $row) {

    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['ureq_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'user':
                $userDetail = '<strong>' . Labels::getLabel('LBL_N:', $siteLangId) . ' </strong>' . $row['user_name'] . '<br/>';
                $userDetail .= '<strong>' . Labels::getLabel('LBL_UN:', $siteLangId) . ' </strong>' . $row['credential_username'] . '<br/>';
                $userDetail .= '<strong>' . Labels::getLabel('LBL_Email:', $siteLangId) . ' </strong>' . $row['credential_email'] . '<br/>';
                $userDetail .= '<strong>' . Labels::getLabel('LBL_User_ID:', $siteLangId) . ' </strong>' . $row['user_id'] . '<br/>';
                $td->appendElement('plaintext', array(), $userDetail, true);
                break;
            case 'ureq_date':
                $td->appendElement('plaintext', array(), FatDate::format($row[$key], true, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get())), true);
                break;
            case 'ureq_type':
                $str = ($row['ureq_type'] == UserGdprRequest::TYPE_TRUNCATE) ? UserGdprRequest::TYPE_TRUNCATE : UserGdprRequest::TYPE_DATA_REQUEST;
                $td->appendElement('plaintext', array(), $userRequestTypeArr[$str], true);
                break;
            case 'ureq_status':
                $str = ($row['ureq_status'] == UserGdprRequest::STATUS_COMPLETE) ? UserGdprRequest::STATUS_COMPLETE : UserGdprRequest::STATUS_PENDING;
                $td->appendElement('plaintext', array(), $userRequestStatusArr[$str], true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['ureq_id']
                ];

                if ($canEdit && $row['ureq_status'] == UserGdprRequest::STATUS_PENDING) {
                    $data['otherButtons'] = [];
                    $pending = [
                        'attr' => [
                            'href' => 'javascript:void(0)',
                            'onclick' => 'updateRequestStatus(' . $row['ureq_id'] . ',' . UserGdprRequest::STATUS_COMPLETE . ')',
                            'title' => Labels::getLabel('LBL_COMPLETE', $siteLangId)
                        ],
                        'label' => "<i class='far fa-calendar-check'></i>"
                    ];
                    $data['otherButtons'][] = $pending;

                    $truncate = [];
                    if ($row['ureq_type'] == UserGdprRequest::TYPE_TRUNCATE) {
                        $truncate = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'truncateUserData(' . $row['user_id'] . ',' . $row['ureq_id'] . ')',
                                'title' => Labels::getLabel('LBL_Truncate_User_Data', $siteLangId)
                            ],
                            'label' => "<i class='fas fa-user-times'></i>"
                        ];
                        $data['otherButtons'] [] = $truncate;
                    }
                    $requestData = [];
                    if ($row['ureq_type'] == UserGdprRequest::TYPE_DATA_REQUEST) {
                        $requestData = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'viewRequestPurpose(' . $row['ureq_id'] . ')',
                                'title' => Labels::getLabel('LBL_View', $siteLangId)
                            ],
                            'label' => "<i class='far fa-eye icon'></i>"
                        ];
                        $data['otherButtons'] [] = $requestData;
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