<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if ($records) {
    $serialNo = ($page > 1) ? $recordCount - (($page - 1) * $pageSize) : $recordCount;

    $tbl = new HtmlElement('table', array('class' => 'table table-responsive table--hovered recordListing--js'));
    foreach ($records as $record) {
        $tr = $tbl->appendElement('tr', ['class' => 'recordRow--js', 'id' => 'record-' . $badgeLinkCondId . '-' . $record['badgelink_record_id']]);
        $tr->appendElement('td')->appendElement('plaintext', [], $serialNo, true);
        $tr->appendElement('td')->appendElement('plaintext', [], $record['record_name'], true);

        if (BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType) {
            $tr->appendElement('td')
                ->appendElement('a', array('class' => 'text-dark', 'href' => 'javascript:void(0)', 'title' => Labels::getLabel('LBL_REMOVE', $adminLangId), "onclick" => "removeBadgeLinkRecord(event, " . $badgeLinkCondId . "," . $record['badgelink_record_id'] . ")"), "<i class='icon ion-close'></i>", true);
        }

        $serialNo--;
    }
    echo $tbl->getHtml();
    
    if (BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType) {
        $pagingArr = array('pageCount' => $pageCount, 'page' => $page, 'recordCount' => $recordCount, 'adminLangId' => $adminLangId, 'callBackJsFunc' => 'reloadRecordsList', 'arguments' => $badgeLinkCondId);
        $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
    }

} else {
    echo Labels::getLabel('MSG_NO_RECORD_FOUND', $adminLangId);
}
