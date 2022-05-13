<?php
$file = CONF_INSTALLATION_PATH . 'vendor/autoload.php';
if (!file_exists($file)) {
    LibHelper::exitWithError(Labels::getLabel('ERR_UNABLE_TO_LOCATE_REQUIRED_LIBRARY_FILE._PLEASE_RUN_COMPOSER_TO_INSTALL.'));
}

require_once $file;

class PluginBase
{
    protected $userId = 0;
    use PluginHelper;
    
    public function setUserId(int $userId)
    {
        $this->userId = $userId;       
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    
}