<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$response = [
    'data' => [
        'app_version' => empty($versionDetails['app_version']) ? '' : $versionDetails['app_version'],
        'is_version_critical' => empty($versionDetails['is_version_critical']) ? 0 : $versionDetails['is_version_critical'],
        'version_features' => empty($versionDetails['version_features']) ? '' : $versionDetails['version_features'],
        'appstore_url' => empty($versionDetails['appstore_url']) ? '' : $versionDetails['appstore_url']
        
    ]
];

$msg = Labels::getLabel('LBL_Latest_App_versions', $siteLangId);
MobileAppUtility::response(MobileAppUtility::STATUS_SUCCESS, $msg, $response);
