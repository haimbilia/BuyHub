<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

class SellerPluginBaseController extends SellerBaseController
{
    use PluginHelper;

    /**
     * __construct
     *
     * @param  string $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
    }

    
    /**
     * updateUserMeta
     *
     * @param  string $key
     * @param  string $value
     * @return bool
     */
    protected function updateUserMeta(string $key, string $value): bool
    {
        $user = new User(UserAuthentication::getLoggedUserId());
        if (false === $user->updateUserMeta($key, $value)) {
            $this->error = $user->getError();
            return false;
        }
        return true;
    }
    
    protected function getUserMeta($key = '')
    {
        return User::getUserMeta(UserAuthentication::getLoggedUserId(), $key);
    }
}
