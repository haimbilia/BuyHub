<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$returnDataArr = CommonHelper::getOrderProductRefundAmtArr($request);
$request['op_refund_amount'] = CommonHelper::displayMoneyFormat($returnDataArr['op_refund_amount'], true, false);

$request['charges'] = array_key_exists('charges', $request) && is_array($request['charges']) ? array_values($request['charges']) : array();
$request['orRequestTypeTitle'] = !empty($returnRequestTypeArr[$request['orrequest_type']]) ? $returnRequestTypeArr[$request['orrequest_type']] : '';
$request['orRequestStatusTitle'] = !empty($requestRequestStatusArr[$request['orrequest_status']]) ? $requestRequestStatusArr[$request['orrequest_status']] : '';

$request['attachmentFile'] = '';
if (isset($attachedFile)) {
    $request['attachmentFile'] = UrlHelper::generateFullUrl('Buyer', 'downloadAttachedFileForReturn', array($request['orrequest_id']));
}
$data = array(
    'canEscalateRequest' => $canEscalateRequest,
    'canWithdrawRequest' => $canWithdrawRequest,
    'request' => $request,
    'vendorReturnAddress' => !empty($vendorReturnAddress) ? $vendorReturnAddress : (object)array(),
    'returnRequestTypeArr' => $returnRequestTypeArr,
    'requestRequestStatusArr' => $requestRequestStatusArr,
    'returnRequestTypeArr' => $returnRequestTypeArr,
);
if (empty($request)) {
    $status = applicationConstants::OFF;
}
