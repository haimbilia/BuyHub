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
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="addr_ids[]" value=' . $row['addr_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo, true);
                break;
            case 'user_name':
                $str = $this->includeTemplate('_partial/user/user-info-card.php', ['user' => $row, 'siteLangId' => $siteLangId], false, true);
                $td->appendElement('plaintext', $tdAttr, '<div class="user-profile">' . $str . '</div>', true);
                break; 
            case 'user_address':
                $address1 = (!empty($row['addr_address1'])) ? $row['addr_address1'] . ', ' : '';
                $address2 = (!empty($row['add_address2'])) ? $row['addr_address2'] : '';

                $city = (!empty($row['addr_city'])) ? $row['addr_city'] . ', ' : '';
                $state = (!empty($row['state_name'])) ? $row['state_name'] . ', ' : '';
                $country = (!empty($row['country_name'])) ? $row['country_name'] . ', ' : '';
                $zip = (!empty($row['addr_zip'])) ? $row['addr_zip'] : '';
                
                $addrPhone = (!empty($row['addr_phone'])) ? $row['addr_phone'] : '';
                if (!empty($addrPhone) && array_key_exists('addr_phone_dcode', $row)) {
                    $addrPhone = ValidateElement::formatDialCode($row['addr_phone_dcode']) . $addrPhone;
                }

                $address = '<ul class="list-text users-addresses">
                                <li class="full">
                                    <span class="lable">' . Labels::getLabel('LBL_Name_&_Address', $siteLangId) . ':</span>
                                    <span class="value">' . 
                                        $row['addr_name'] . '<br/>' . 
                                        $address1 . ' ' . 
                                        $address2 . ' ' .
                                        '</span>
                                </li>
                                <li><span class="lable">' . Labels::getLabel('LBL_ADDRESS_LOCATION', $siteLangId) . ':</span>
                                    <span class="value">' . 
                                        $city . ' ' . 
                                        $state . ' ' . 
                                        $country . ' ' . 
                                        $zip . ' ' . 
                                        '</span>
                                </li>';
                                if (!empty($addrPhone)) {
                                    $address .= '<li><span class="lable">' . Labels::getLabel('LBL_PHONE', $siteLangId) . ':</span>
                                                    <span class="value">' . $addrPhone . '</span>
                                                </li>';
                                }
                $address .= '</ul>';

                $td->appendElement('plaintext', array(), $address, true);
                break;
            case 'addr_is_default':
                $str = ($row['addr_is_default'] == 1) ? Labels::getLabel('LBL_Yes', $siteLangId) : Labels::getLabel('LBL_No', $siteLangId);
                $statusHtm = Address::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['addr_id']
                ];

                if ($canEdit) {
                    $attr = [
                        'onclick' => 'editAddress(' . $row['addr_id'] . ', ' . $row['addr_record_id'] . ')'
                    ];
                    $data['editButton'] = $attr;
                    $data['deleteButton'] = [];
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