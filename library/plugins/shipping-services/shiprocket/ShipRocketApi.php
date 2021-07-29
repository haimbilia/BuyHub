<?php
require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
require_once dirname(__FILE__) . '/autoload.php';

use Shiprocket\Client as ShiprocketClient;

class ShipRocketApi extends ShiprocketClient
{
    use Channels,
        Pickups,
        OrderLabels;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }
}
