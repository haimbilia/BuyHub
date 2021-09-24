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
        switch ($key) {
            case 'select_all':
                if ($row['commsetting_is_mandatory'] != 1) {
                    $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="commsetting_ids[]" value=' . $row['commsetting_id'] . '><i class="input-helper"></i></label>', true);
                }
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'commsetting_prodcat_id':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayText($row['prodcat_name']), true);
                break;
            case 'commsetting_user_id':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayText($row['vendor']), true);
                break;
            case 'commsetting_product_id':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayText($row['product_name']), true);
                break;
            case 'commsetting_fees':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::numberFormat($row[$key]), true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['commsetting_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];

                    if ($row['commsetting_is_mandatory'] != 1) {
                        $data['deleteButton'] = [];
                    }

                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "viewHistory(" . $row['commsetting_id'] . ")",
                                'title' => Labels::getLabel('LBL_HISTORY', $adminLangId)
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#view">
                                            </use>
                                        </svg>'
                        ]
                    ];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                break;
            default:
                $td->appendElement('plaintext', array(), $row[$key], true);
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