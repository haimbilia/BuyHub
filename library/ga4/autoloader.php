<?php
function ga4AutoLoader($className)
{
    require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
    
    if (file_exists(CONF_INSTALLATION_PATH . 'library/ga4/' . $className . '.php')) {
        require_once CONF_INSTALLATION_PATH . 'library/ga4/' . $className . '.php';
    }
}

spl_autoload_register('ga4AutoLoader');
