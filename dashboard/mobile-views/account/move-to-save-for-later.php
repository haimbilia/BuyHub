<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$productsArr = [
    'notAvailable' => [],
    'available' => [],
    'saveForLater' => [],
];

$productsCount = count($products);
if (0 < $productsCount) {
    uasort($products, function ($a, $b) {
        return  $b['fulfillment_type'] - $a['fulfillment_type'];
    });

    foreach ($products as $key => &$product) {
        $product['productUrl'] = UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND);
        $product['shopUrl'] = UrlHelper::generateFullUrl('Shops', 'View', array($product['shop_id']), CONF_WEBROOT_FRONTEND);
        $product['imageUrl'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');

        $type = '';
        if ($product['fulfillment_type'] == Shipping::FULFILMENT_PICKUP) {
            $type = 'notAvailable';
        } else {
            $type = 'available';
        }
        $productsArr[$type][] = $product;
    }
}

$products = $productsArr['available'];

$tplFile = str_replace( CONF_APPLICATION_PATH, CONF_INSTALLATION_PATH.CONF_FRONT_END_APPLICATION_DIR, CONF_THEME_PATH );
$tplFile .= 'cart/price-detail.php';
require_once($tplFile);
