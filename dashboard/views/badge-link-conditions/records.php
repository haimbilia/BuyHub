<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ($records) {
    $tbl = '<table class="table recordListing--js"><tbody>';
    
    $sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;
    foreach ($records as $record) {
        $tbl .= '<tr class="recordRow--js" id="record-' . $badgeLinkCondId . "-" . $record['badgelink_record_id'] . '">';
        $tbl .= '<td>' . $sr_no . '</td>';
        $tbl .= '<td>' . $record['record_name'] . '</td>';
        if (true === $canEditRecords) {
            $tbl .= '<td><a class="text-dark" href="javascript:void(0)" title="Remove" onClick="removeBadgeLinkRecord(event, ' . $badgeLinkCondId . ',' . $record['badgelink_record_id'] . ');"><i class="fa fa-times"></i></a></td>';
        }
        $tbl .= '</tr>';

        $sr_no--;
    }
    $tbl .= '</tbody></table>';
    echo $tbl;

    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId, 'callBackJsFunc' => 'reloadRecordsList', 'arguments' => $badgeLinkCondId);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
} else {
    $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
}