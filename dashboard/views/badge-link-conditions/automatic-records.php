<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if ($records) {
    $tbl = '<table class="table recordListing--js"><tbody>';

    $sr_no = $page == 1 ? 0 : $pageSize * ($page - 1);
    foreach ($records as $record) {
        $sr_no++;
        $tbl .= '<tr class="recordRow--js">';
        $tbl .= '<td>' . $sr_no . '</td>';
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