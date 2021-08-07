<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($collections as $collectionIndex => &$collectionData) {
    if (array_key_exists('theprice', $collectionData)) {
        $collectionData['theprice'] = CommonHelper::displayMoneyFormat($collectionData['theprice'], true, true, true);
    }
}

$data = array(
    'recordCount' => !empty($recordCount) ? $recordCount : 0,
    'collection' => !empty($collection) ? $collection : (object)array(),
    'collectionItems' => !empty($collections) ? array_values($collections) : array(),
);


if (empty((array)$collection)) {
    $status = applicationConstants::OFF;
}
