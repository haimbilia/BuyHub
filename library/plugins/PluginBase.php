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

    /**
     * setUserId
     *
     * @param  mixed $userId
     * @return void
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * getUserId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * validateKeys : Called when this function not defined in called pugin class.
     *
     * @param  array $keys
     * @return bool
     */
    public function validateKeys(array $keys): bool
    {
        return true;
    }
}
