<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($requests as $key => &$request) {
    $request['statusName'] = array_key_exists('ocrequest_status', $request) ? $OrderCancelRequestStatusArr[$request['ocrequest_status']] : '';
    $request['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($request['selprod_product_id'], ImageDimension::VIEW_THUMB, $request['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
}

$data = array(
    'requests' => $requests,
    'page' => $page,
    'pageCount' => $pageCount,
    'recordCount' => $recordCount,
    'OrderCancelRequestStatusArr' => $OrderCancelRequestStatusArr
);

if (empty($requests)) {
    $status = applicationConstants::OFF;
}
