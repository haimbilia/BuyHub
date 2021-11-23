<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$tableId = "faqCategoryJs";

$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['width'=> '100%', 'class' => $cls, 'data-row' => $serialNo, 'id' => $row['faqcat_id']]);

    if ($row['faqcat_active'] == applicationConstants::ACTIVE) {
        $tr->setAttribute("id", $row['faqcat_id']);
    }

    if ($row['faqcat_active'] != applicationConstants::ACTIVE) {
        $tr->setAttribute("class", "nodrag nodrop");
    }
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'dragdrop':
                $td->appendElement('plaintext', $tdAttr, '<svg class="svg" width="18" height="18">
                    <use
                        xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#drag">
                    </use>
                </svg>', true);
                break;
            case 'select_all':
                $td->appendElement('plaintext', array(), '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="faqcat_ids[]" value=' . $row['faqcat_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'faqcat_identifier':
                if ($row['faqcat_name'] != '') {
                    $td->appendElement('plaintext', array(), $row['faqcat_name'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array(), $row[$key], true);
                }
                break;
            case 'faqcat_active':
                $statusAct = ($canEdit) ? 'updateStatus(event, this, ' . $row['faqcat_id'] . ', ' . ((int) !$row[$key]) . ')' : 'return false;';
                $statusClass = ($canEdit) ? '' : 'disabled';
                $checked = applicationConstants::ACTIVE == $row[$key] ? 'checked' : '';

                $htm = '<span class="switch switch-sm switch-icon">
                    <label>
                        <input type="checkbox" data-old-status="' . $row[$key] . '" value="' . $row['faqcat_id'] . '" ' . $checked . ' onclick="' . $statusAct . '" ' . $statusClass . '>
                        <span class="input-helper"></span>
                    </label>
                </span>';
                $td->appendElement('plaintext', $tdAttr, $htm, true);


                break;
            case 'action':

                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['faqcat_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = ['onClick'=>'editRecord(' . $row['faqcat_id'] . ', false, "modal-dialog-vertical-md")'];
                    $data['deleteButton'] = [];
                }
                $url = UrlHelper::generateUrl('Faq', 'index', array($row['faqcat_id']));
                $data['otherButtons'] = [
                    [
                        'attr' => [
                            'href' => 'javascript:void(0);',
                            'onClick' => 'redirectUrl("' . $url . '")',
                            'title' => Labels::getLabel('LBL_FAQ_Listing', $siteLangId),
                        ],
                        'label' => '<i class="icn">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="/admin/images/retina/sprite.yokart.svg#password">
                                </use>
                            </svg>
                        </i>'
                    ]
                ];
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
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}
?>
