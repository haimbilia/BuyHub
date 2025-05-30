<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ($records) {
    $tbl = '<table class="table table-responsive table--hovered recordListing--js"><tbody>';
    foreach ($records as $record) {
        $tbl .= '<tr id="record-' . $badgeReqId . "-" . $record['badgelink_record_id'] . '">';
        $tbl .= '<td><a class="text-dark" href="javascript:void(0)" title="'.Labels::getLabel('LBL_REMOVE', $siteLangId).'" onclick="removeRecordRow(this,' . $record['badgelink_record_id'] . ');"><i class="fa fa-times"></i></a></id>';
        $tbl .= '<td>' . $record['record_name'] . '</td>';
        $tbl .= '</tr>';
    }
    $tbl .= '</tbody></table>';
    echo $tbl;

    $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId, 'callBackJsFunc' => 'reloadRecordsList', 'arguments' => $badgeReqId);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
} else {
    echo Labels::getLabel('MSG_NO_RECORD_FOUND', $siteLangId);
}