<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($digitalDownloads as $index => $row) {
    $digitalDownloads[$index]['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($row['selprod_product_id'], ImageDimension::VIEW_THUMB, $row['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
    $digitalDownloads[$index]['downloadUrl'] = UrlHelper::generateFullUrl() . 'public/index.php?url=buyer/download-digital-file/' . $row['afile_id'] . '/' . $row['afile_record_id'];
    //$digitalDownloads[$index]['downloadUrl'] = UrlHelper::generateFullUrl('Buyer', 'downloadDigitalFile', array($row['afile_id'], $row['afile_record_id']),CONF_WEBROOT_URL,false);
}
$data = array(
    'digitalDownloads' => $digitalDownloads,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
);

if (empty($digitalDownloads)) {
    $status = applicationConstants::OFF;
}
