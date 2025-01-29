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
    $tr = $tbody->appendElement('tr', ['class' => $cls, 'data-row' => $serialNo, 'id' => $row['arv_id']]);

 
    foreach ($fields as $key => $val) {
        $tdAttr = ('action' == $key) ? ['class' => 'align-right'] : (('select_all' == $key) ? ['class' => 'col-check'] : []);
        $td = $tr->appendElement('td', $tdAttr);
        switch ($key) {
            case 'listserial':
                $td->appendElement('plaintext', [], $serialNo);
                break;
            case 'arv_app_name':
                $name = $row['arv_app_type'] == applicationConstants::LOGIN_VIA_ANDROID ? 'images/playstore.svg' : 'images/app-store.svg';
                $img = "<img title ='" . applicationConstants::getAppTypeArray($siteLangId)[$row['arv_app_type']] . "' width='20px' src='" . CONF_WEBROOT_FRONTEND . $name . "' />&nbsp;&nbsp;";
                $td->appendElement('plaintext', [], "<span style='display: flex;'>" . $img . $row[$key] . "</span>", true);
                break;

            case 'arv_added_on':
                $td->appendElement('plaintext', [], FatDate::format($row[$key]), true);
                break;
            case 'arv_is_critical':
                $td->appendElement('plaintext', [], applicationConstants::getYesNoArr($siteLangId)[$row[$key]], true);
                break;
            case 'action':
                $data = [
                    'siteLangId' => $siteLangId,
                    'recordId' => $row['arv_id']
                ];

                if ($canEdit) {
                    $data['editButton'] = [];
                }
                $actionItems = $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false, true);
                $td->appendElement('plaintext', $tdAttr, $actionItems, true);
                
                break;
            default:
                $td->appendElement('plaintext', [], nl2br($row[$key]), true);
                break;
        }
    }
}
include (CONF_THEME_PATH . '_partial/listing/no-record-found.php');

if ($printData) {
    echo $tbody->getHtml();
}
?>

