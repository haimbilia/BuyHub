<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'messages' => $arrListing,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'page' => $page,
    'pageSize' => $pageSize,
);

if (empty($arrListing)) {
    $status = applicationConstants::OFF;
    $msg = Labels::getLabel('LBL_NO_MESSAGE_FOUND');
}
