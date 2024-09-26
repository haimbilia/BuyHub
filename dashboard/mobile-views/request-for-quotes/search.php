<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (!empty($arrListing)) {
    foreach ($arrListing as &$rfq) {
        $rfq['downloadRfqCopyUrl'] = '';
        if ($isBuyer && 0 < $rfq['acceptedOffers']) {
            $rfq['downloadRfqCopyUrl'] = UrlHelper::generateFullUrl('RequestForQuotes', 'downloadRfqCopy', [$rfq['rfq_id']]); 
        }
    }
}

$data = array(
    'approvalStatusArr' => $approvalStatusArr,
    'statusArr' => $statusArr,
    'listing' => array_values($arrListing),
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'page' => $page,
    'pageSize' => $pageSize,
);

if (empty($arrListing)) {
    $status = applicationConstants::OFF;
}
