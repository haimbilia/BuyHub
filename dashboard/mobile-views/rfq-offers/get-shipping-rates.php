<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = [
    'options' => array_values($options)
];
if (empty($options)) {
    $status = applicationConstants::OFF;
}