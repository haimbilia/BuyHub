<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($arrListing as &$value) {
    $value['isBought'] = RfqOffers::isBought($value['rlo_accepted_offer_id']) ? 1 : 0;
}

$data = array(
    'offersCountArr' => array_values($offersCountArr),
    'statusArr' => $statusArr,
    'rfqStatusArr' => $rfqStatusArr,
    'approvalStatusArr' => $approvalStatusArr,
    'rfqStatus' => $rfqStatus,
    'rfqOffers' => array_values($arrListing),
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'page' => $page,
    'pageSize' => $pageSize,
);

if (empty($arrListing)) {
    $status = applicationConstants::OFF;
}
