<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($arrListing as &$row) {
    $row['order_net_amount'] = CommonHelper::displayMoneyFormat($row['order_net_amount']);
}

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
