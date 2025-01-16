<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'isGuest' => $isGuest ? 0 : 1,
    'verificationRequired' => $verificationRequired,
    'rfq_id' => $record_id
);