<?php
//require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
//require_once CONF_PLUGIN_DIR . "shipping-services/rajathans/autoload.php";

require_once dirname(__FILE__) . '/autoload.php';

use Client as ShiprocketClient;

class ShipRocketApi extends ShiprocketClient
{
    use Channels,
        Pickups,
        OrderLabels,
        ReturnOrders,
        Couriers,
        Tracking,
        Users,
        Manifests,
        Products,
        SrOrders;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }
}
