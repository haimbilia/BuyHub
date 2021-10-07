<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                if (1 > $row['afcommsetting_is_mandatory']) {
                    $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="afcommsetting_ids[]" value=' . $row['afcommsetting_id'] . '><i class="input-helper"></i></label>', true);
                }
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'afcommsetting_prodcat_id':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayText($row['prodcat_name']), true);
                break;
            case 'afcommsetting_user_id':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayText($row['credential_username']), true);
                break;
            case 'afcommsetting_fees':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::numberFormat($row[$key]), true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['afcommsetting_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];

                    if ($row['afcommsetting_is_mandatory'] != 1) {
                        $data['deleteButton'] = [];
                    }

                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "viewLog(" . $row['afcommsetting_id'] . ")",
                                'title' => Labels::getLabel('LBL_VIEW_LOG', $adminLangId)
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
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayText($row[$key]), true);
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