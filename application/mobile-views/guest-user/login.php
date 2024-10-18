<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$userImage = [
    'token' => $token,
    'app_session_id' => $app_session_id,
    'user_image' => (!empty($userInfo['user_id']) ? UrlHelper::generateFullUrl('image', 'user', array($userInfo['user_id'], ImageDimension::VIEW_THUMB)) : '')
];
$data = array_merge($userInfo, $userImage);

if (empty($userInfo)) {
    $status = applicationConstants::OFF;
}
