<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$printData = false;
if (!isset($tbody)) {
    $printData = true;
    $tbody = new HtmlElement('tbody', ['class' => 'listingRecordJs']);
}

$serialNo = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
foreach ($arrListing as $sn => $row) {
    $cls = (($serialNo % 2) == 0) ? 'even' : 'odd';
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo]);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : [];
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="bpcomment_ids[]" value=' . $row['bpcomment_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'bpcomment_added_on':
                $td->appendElement('plaintext', $tdAttr, FatDate::format($row['bpcomment_added_on'], true));
                break;
            case 'bpcomment_author_name':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayName($row[$key]), true);
                break;
            case 'bpcomment_approved':
                $statusHtm = BlogComment::getStatusHtml($adminLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtm, true);
                break;
            case 'post_title':
                $td->appendElement('plaintext', $tdAttr, CommonHelper::displayName($row[$key]), true);
                break;
            case 'action':
                $data = [
                    'adminLangId' => $adminLangId,
                    'recordId' => $row['bpcomment_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
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
    $serialNo--;
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