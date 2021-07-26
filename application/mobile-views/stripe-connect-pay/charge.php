<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$paymentIntendId = isset($paymentIntendId) ? $paymentIntendId : '';
$clientSecret = isset($clientSecret) ? $clientSecret : '';
$data = array(
    'paymentAmount' => $paymentAmount,
    'customerId' => isset($customerId) ? $customerId : '',
    'orderInfo' => $orderInfo,
    'paymentIntendId' => $paymentIntendId,
    'clientSecret' => $clientSecret,
);