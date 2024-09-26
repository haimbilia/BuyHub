<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'giftCards' => $arrListing,
    'orderPaymentStatusArr' => $orderPaymentStatusArr,
    'useStatusArr' => $useStatusArr,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'page' => $page,
    'pageSize' => $pageSize,
);

if (empty($arrListing)) {
    $status = applicationConstants::ON;
}
