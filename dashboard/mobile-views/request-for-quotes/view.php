<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'statusArr' => $statusArr,
    'approvalStatusArr' => $approvalStatusArr,
    'productTypes' => $productTypes,
    'rfqData' => $rfqData,
);

if (empty($rfqData)) {
    $status = applicationConstants::OFF;
}
