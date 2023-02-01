<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$data = ['collections' => array_values($collections),];

if (empty($sponsoredProds) && empty($sponsoredShops) && empty($slides) && empty($collections)) {
    $status = applicationConstants::OFF;
}
