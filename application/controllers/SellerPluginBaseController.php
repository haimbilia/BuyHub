<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

class SellerPluginBaseController extends SellerBaseController
{
    use PluginHelper;

    public function __construct($action)
    {
        parent::__construct($action);
    }
}
