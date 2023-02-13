<?php
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
header("Content-Security-Policy: frame-ancestors 'self'");
header('X-Frame-Options: SAMEORIGIN');
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
define('HTTP_YOKART_PUBLIC', $protocol . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), 'install'), '/.\\') . '/');
define('HTTP_YOKART', preg_replace('~/[^/]*/([^/]*)$~', '/\1', HTTP_YOKART_PUBLIC));

if (is_file('settings.php')) {
	require_once('settings.php');
}

require_once dirname(__DIR__) . '/conf/conf-admin.php';

require_once dirname(__FILE__) . '/application-top.php';

FatApp::unregisterGlobals();

if (file_exists(CONF_APPLICATION_PATH . 'utilities/prehook.php')) {
	require_once CONF_APPLICATION_PATH . 'utilities/prehook.php';
}

FatApplication::getInstance()->callHook();
