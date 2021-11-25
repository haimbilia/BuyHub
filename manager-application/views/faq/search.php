<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$tableId = "faqJs";
$serialNo = $page == 1 ? 0 : $pageSize * ($page - 1);
foreach ($arrListing as $sn => $row) {
    $serialNo++;
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['width'=> '100%', 'class' => $cls, 'data-row' => $serialNo, 'id' => $row['faq_id']]);
    if ($row['faq_active'] == applicationConstants::ACTIVE) {
        $tr->setAttribute("id", $row['faq_id']);
    }

    if ($row['faq_active'] != applicationConstants::ACTIVE) {
        $tr->setAttribute("class", "fat-inactive nodrag nodrop");
    }
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'dragdrop':
                $td->appendElement('plaintext', $tdAttr, '<svg class="svg" width="18" height="18">
                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#drag"></use>
                </svg>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', array(), $serialNo);
                break;
            case 'faq_identifier':
                if ($row['faq_title'] != '') {
                    $td->appendElement('plaintext', array(), $row['faq_title'], true);
                    $td->appendElement('br', array());
                    $td->appendElement('plaintext', array(), '(' . $row[$key] . ')', true);
                } else {
                    $td->appendElement('plaintext', array()  , $row[$key], true);
                }
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['faq_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [
                        'onClick'=>'editRecord(' . $row['faq_id'] .','.$row['faq_faqcat_id']. ')'
                    ];
                    $data['deleteButton'] = [];
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
            'colspan' => count($fields),
            'class' => 'noRecordFoundJs'
        ),
        Labels::getLabel('LBL_NO_RECORDS_FOUND', $siteLangId)
    );
}

if ($printData) {
    echo $tbody->getHtml();
}
