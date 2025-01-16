 
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
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['addr_id']]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'addr_phone':
                $addrPhone = (strlen((string)$row['addr_phone']) > 0) ? $row['addr_phone'] : '';
                if (!empty($addrPhone) && array_key_exists('addr_phone_dcode', $row)) {
                    $addrPhone = '<span class="default-ltr">' . ValidateElement::formatDialCode($row['addr_phone_dcode']) . $addrPhone . '</span>';
                }
                $td->appendElement('plaintext', array(), $addrPhone, true);
                break;
            case 'addr_detail':
                $addrName = (strlen((string)$row['addr_name']) > 0) ? $row['addr_name'] . '<br>' : '';
                $addr2 = (strlen((string)$row['addr_address2']) > 0) ? ', ' . $row['addr_address2'] . '<br>' : '';
                $addrCity = (strlen((string)$row['addr_city']) > 0) ? $row['addr_city'] . ', ' : '';
                $addrState = (strlen((string)$row['state_name']) > 0) ? $row['state_name'] . ', ' : '';
                $addrCountry = (strlen((string)$row['country_name']) > 0) ? $row['country_name'] . '<br>' : '';
                $addrZip = (strlen((string)$row['addr_zip']) > 0) ? Labels::getLabel('LBL_Zip:', $siteLangId) . $row['addr_zip'] : '';
                $address = "<address>
                                <p>" . $addrName . $row['addr_address1'] . ' ' . $addr2 . $addrCity . $addrState . $addrCountry . $addrZip .
                        "</address>";
                $td->appendElement('plaintext', array(), $address, true);
                break;

            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['addr_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [
                        'onclick' => 'editRecord(' . $row['addr_id'] . ',' . $row['addr_lang_id'] . ')'
                    ];
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

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}