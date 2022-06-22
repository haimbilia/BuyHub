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
    $tr->setAttribute("id", $row['post_id']);

    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'select_all':
                $td->appendElement('plaintext', $tdAttr, '<label class="checkbox"><input class="selectItemJs" type="checkbox" name="record_ids[]" value=' . $row['post_id'] . '><i class="input-helper"></i></label>', true);
                break;
            case 'post_published_on':
                $td->appendElement('plaintext', $tdAttr, HtmlHelper::formatDateTime($row['post_published_on'], true), true);
                break;
            case 'listSerial':
                $td->appendElement('plaintext', $tdAttr, $serialNo);
                break;
            case 'post_title':
                $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                break;
            case 'post_published':
                $htm = HtmlHelper::addStatusBtnHtml($canEdit, $row['post_id'], $row[$key],false,'','searchRecords()');
                $td->appendElement('plaintext', $tdAttr, $htm, true);
                break;
            case 'child_count':
                if ($row[$key] == 0) {
                    $td->appendElement('plaintext', $tdAttr, $row[$key], true);
                } else {
                    $td->appendElement('a', array('href' => UrlHelper::generateUrl('BlogPostCategories', 'index', array($row['post_id'])), 'title' => Labels::getLabel('LBL_View_Categories', $siteLangId)), $row[$key]);
                }
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['post_id']
                ];
                
                if ($canEdit) {
                    $data['editButton'] = [
                        'onclick' => 'editRecord(' . $row['post_id'] . ', false, "modal-dialog-vertical-md")'
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
}

include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
