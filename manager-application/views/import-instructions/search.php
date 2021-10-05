<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = 0;
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'epage_identifier':
                if ($row['epage_label'] != '') {
                    $td->appendElement('plaintext', $tdAttr, $row['epage_label'], true);
                } else {
                    $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                }
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['epage_id']
                ];
                
                if ($canEdit) {
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "editLangData(" . $row['epage_id'] . "," . $row['epagelang_lang_id'] . ");",
                                'title' => Labels::getLabel('LBL_EDIT', $adminLangId)
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#edit">
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

if ($printData) {
    echo $tbody->getHtml();
}
