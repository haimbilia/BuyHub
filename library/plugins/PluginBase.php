<?php
require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

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
