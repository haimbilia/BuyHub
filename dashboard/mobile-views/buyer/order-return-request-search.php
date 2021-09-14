<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($requests as &$request) {
    $request['statusName'] = array_key_exists('orrequest_status', $request) ? $OrderReturnRequestStatusArr[$request['orrequest_status']] : '';
    $request['orrequestTypeTitle'] = array_key_exists('orrequest_type', $request) ? $returnRequestTypeArr[$request['orrequest_type']] : '';
    $request['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($request['selprod_product_id'], "THUMB", $request['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
}
$data = array(
    'requests' => $requests,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'returnRequestTypeArr' => $returnRequestTypeArr,
    'OrderReturnRequestStatusArr' => $OrderReturnRequestStatusArr,
);
if (empty($requests)) {
    $status = applicationConstants::OFF;
}
