<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$url = $attachment_name = '';
$res = AttachedFile::getAttachment(AttachedFile::FILETYPE_RFQ, $recordId, 0, langId: -1);

if (!empty($res) && 0 < $res['afile_id']) {
    $url = UrlHelper::generateFullUrl('RequestForQuotes', 'downloadFile', array($recordId));
    $attachment_name = $res['afile_name'];
}

$rfqData['attachment_url'] = $url;
$rfqData['attachment_name'] = $attachment_name;
$rfqData['product_image'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($rfqData['rfq_product_id'], ImageDimension::VIEW_MEDIUM, $rfqData['rfq_selprod_id'], 0), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');

$data = array(
    'statusArr' => $statusArr,
    'approvalStatusArr' => $approvalStatusArr,
    'productTypes' => $productTypes,
    'rfqData' => $rfqData,
);

if (empty($rfqData)) {
    $status = applicationConstants::OFF;
}
