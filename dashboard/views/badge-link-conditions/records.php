<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ($records) {
    $tbl = '<table class="table recordListing--js"><tbody>';
    foreach ($records as $record) {
        $tbl .= '<tr class="recordRow--js" id="record-' . $badgeLinkCondId . "-" . $record['badgelink_record_id'] . '">';
        $tbl .= '<td><a class="text-dark" href="javascript:void(0)" title="Remove" onClick="removeBadgeLinkRecord(event, ' . $badgeLinkCondId . ',' . $record['badgelink_record_id'] . ');"><i class="fa fa-times"></i></a></id>';
        $tbl .= '<td>' . $record['record_name'] . '</td>';
        $tbl .= '</tr>';
    }
    $tbl .= '</tbody></table>';
    echo $tbl;

    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId, 'callBackJsFunc' => 'reloadRecordsList', 'arguments' => $badgeLinkCondId);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
} else {
    echo Labels::getLabel('MSG_NO_RECORD_FOUND', $siteLangId);
}