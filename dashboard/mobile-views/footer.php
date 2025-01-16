<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = empty($data) ? array() : $data;
$data = array_merge($commonData, $data);

$responseCode = isset($responseCode) ? $responseCode : LibHelper::RC_OK;

if (applicationConstants::FAILURE == $status && (!isset($msg) || empty($msg))) {
    $msg = Labels::getLabel('ERR_NO_RESULT_FOUND', $siteLangId);
} else if (applicationConstants::SUCCESS == $status && (!isset($msg) || empty($msg))) {
    $msg = Labels::getLabel('MSG_SUCCESS', $siteLangId);
}

$response = LibHelper::formatResponse($status, $msg, $data, $responseCode);

/* This line is added because we don't want to display web messages from APP. */
$messages = Message::getHtml();
/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

CommonHelper::jsonEncodeUnicode($response, true);
