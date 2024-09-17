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
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="bcontributions_ids[]" value=' . $row['bcontributions_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'bcontributions_added_on':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row['bcontributions_added_on'], true), true);
                break;
            case 'author_name':
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
            case 'bcontributions_author_phone':
                $phone = '<span class="default-ltr">' . ValidateElement::formatDialCode($row['bcontributions_author_phone_dcode']) . $row[$key] . '</span>';
                $td->appendElement('plaintext', $tdAttr, $phone, true);
                break;
            case 'bcontributions_status':
                $statusHtm = BlogContribution::getStatusHtml($siteLangId, $row[$key]);
                $td->appendElement('plaintext', $tdAttr, $statusHtm, true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['bcontributions_id']
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
    $serialNo++;
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}