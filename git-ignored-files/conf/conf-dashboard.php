<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'conf-common.php';
define('CONF_APPLICATION_PATH', CONF_INSTALLATION_PATH . 'dashboard/');
define('CONF_VIEW_DIR_PATH', CONF_APPLICATION_PATH . 'views/');
define('CONF_MAIN_CSS_DIR_PATH', 'css');
define('CONF_FRONT_END_APPLICATION_PATH', CONF_INSTALLATION_PATH . CONF_FRONT_END_APPLICATION_DIR);
define('CONF_FRONT_END_THEME_PATH', CONF_FRONT_END_APPLICATION_PATH . 'views/');

if (strpos($_SERVER['REQUEST_URI'], '/mobile-app-api/') !== false) {
    define('CONF_THEME_PATH', CONF_APPLICATION_PATH . 'mobile-views/');
} elseif (strpos($_SERVER['REQUEST_URI'], '/app-api/') !== false) {
    define('CONF_THEME_PATH', CONF_APPLICATION_PATH . 'mobile-views/');
} else {
    define('CONF_THEME_PATH', CONF_VIEW_DIR_PATH);
}

define('CONF_WEBROOT_URL', CONF_WEBROOT_FRONTEND . 'dashboard/');
define('CONF_WEBROOT_FRONT_URL', CONF_WEBROOT_FRONTEND);
define('CONF_WEBROOT_URL_TRADITIONAL', CONF_WEBROOT_FRONTEND . 'public/dashboard.php?url=');
define('CONF_HTML_EDITOR', 'innova');
define('CONF_FAT_CACHE_DIR', CONF_INSTALLATION_PATH . 'public/cache/');
define('CONF_FAT_CACHE_URL', CONF_WEBROOT_URL . 'cache/');
define('CONF_BACK_END_THEME_PATH', CONF_INSTALLATION_PATH . 'admin-application/views/');
