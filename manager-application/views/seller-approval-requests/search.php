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
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['usuprequest_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="brandIds[]" value=' . $row['usuprequest_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'user_details':
                $td->appendElement('plaintext', array(), '<strong>' . Labels::getLabel('LBL_U', $siteLangId) . ': </strong> ' . $row['credential_username'], true);
                $td->appendElement('br', array());
                $td->appendElement('plaintext', array(), '<strong>' . Labels::getLabel('LBL_E', $siteLangId) . ': </strong> ' . $row['credential_email'], true);
                break;
            case 'usuprequest_status':
                $td->appendElement('plaintext', array(), $reqStatusArr[FatUtility::int($row['usuprequest_status'])], true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['usuprequest_id']
                ];

                if ($canEdit && $canEdit && $row['usuprequest_status'] == User::SUPPLIER_REQUEST_PENDING) {
                    $data['editButton'] = [];
                }
                $data['otherButtons'] = [
                    [
                        'attr' => [
                            'href' => 'javascript:void(0)',
                            'onclick' => 'viewSellerRequest('.$row['usuprequest_id'].')',
                            'title' => Labels::getLabel('LBL_View', $siteLangId)
                        ],
                        'label' => "<i class='far fa-eye icon'></i>"
                    ]
                ];
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