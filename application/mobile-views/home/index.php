<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$data = [
    'page' => $page,
    'pageSize' => $pageSize,
    'pageCount' => $pageCount,
    'collections' => array_values($collections),
];

if (empty($sponsoredProds) && empty($sponsoredShops) && empty($slides) && empty($collections)) {
    $status = applicationConstants::OFF;
}
