<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$selProdRate = [];
foreach ($selProdRating as $key => $value) {
    if (array_key_exists($key, $otherRatingTypesArr)) continue;

    $selProdRate[] = [
        'id' => $key,
        'title' => $value,
    ];
}

$otherRate = [];
foreach ($otherRatingTypesArr as $key => $value) {
    $otherRate[] = [
        'id' => $key,
        'title' => $value,
    ];
}

$shopRate = [];
foreach ($shopRatingTypesArr as $key => $value) {
    $shopRate[] = [
        'id' => $key,
        'title' => $value,
    ];
}

$deliveryRate = [];
foreach ($deliveryRatingTypesArr as $key => $value) {
    $deliveryRate[] = [
        'id' => $key,
        'title' => $value,
    ];
}

if (!empty($selProdRate)) {
    $data['selProdRating'] = current($selProdRate);
}

if (!empty($shopRate)) {
    $data['shopRating'] = current($shopRate);
}

if (!empty($deliveryRate)) {
    $data['deliveryRating'] = current($deliveryRate);
}

if (!empty($otherRate)) {
    $data['otherRating'] = $otherRate;
}