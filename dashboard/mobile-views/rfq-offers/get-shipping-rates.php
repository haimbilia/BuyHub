<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = [
    'options' => array_values($options)
];
if (empty($options)) {
    $status = applicationConstants::OFF;
    $msg = Labels::getLabel('LBL_SHIPPING_CHARGES_WERE_NOT_DECLARED.');
}