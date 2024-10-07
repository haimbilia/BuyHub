<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$url = '';
$res = AttachedFile::getAttachment(AttachedFile::FILETYPE_RFQ, $recordId, 0, langId: -1);

if (!empty($res) && 0 < $res['afile_id']) {
    $url = UrlHelper::generateFullUrl('RequestForQuotes', 'downloadFile', array($recordId));
}

$rfqData['attachment_url'] = $url;

$data = array(
    'statusArr' => $statusArr,
    'approvalStatusArr' => $approvalStatusArr,
    'productTypes' => $productTypes,
    'rfqData' => $rfqData,
);

if (empty($rfqData)) {
    $status = applicationConstants::OFF;
}
