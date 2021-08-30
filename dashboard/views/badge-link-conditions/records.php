<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if ($records) {
    $sr_no = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;

    $tbl = new HtmlElement('table', array('width' => '100%', 'class' => 'table recordListing--js'));
    foreach ($records as $record) {
        $tr = $tbl->appendElement('tr', ['class' => 'recordRow--js', 'id' => 'record-' . $badgeLinkCondId . '-' . $record['badgelink_record_id']]);
        $tr->appendElement('td')->appendElement('plaintext', [], $sr_no, true);
        $tr->appendElement('td')->appendElement('plaintext', [], $record['record_name'], true);

        if (true === $canEditRecords && BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType) {
            $tr->appendElement('td')
                ->appendElement("ul", array("class" => "actions"))
                ->appendElement("li")
                ->appendElement('a', array('href' => 'javascript:void(0)', 'title' => Labels::getLabel('LBL_REMOVE', $siteLangId), "onclick" => "removeBadgeLinkRecord(event, " . $badgeLinkCondId . "," . $record['badgelink_record_id'] . ")"), "<i class='fa fa-times'></i>", true);
        }

        $sr_no--;
    }
    echo $tbl->getHtml();

    if (BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType) {
        $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'siteLangId' => $siteLangId, 'callBackJsFunc' => 'reloadRecordsList', 'arguments' => $badgeLinkCondId);
        $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
    }
} else {
    $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
}
