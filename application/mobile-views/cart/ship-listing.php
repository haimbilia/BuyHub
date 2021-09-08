<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$productsArr = $availableProductsArr;
$productsCount = $pickUpProductsCount;

$cartSummary['orderNetAmount'] = CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], false, false, false);

$data = array(
    'products' => $productsArr,
    'cartSummary' => $cartSummary,
    'cartSelectedBillingAddress' => empty($cartSelectedBillingAddress) ? (object)array() : $cartSelectedBillingAddress,
    'cartSelectedShippingAddress' => empty($cartSelectedShippingAddress) ? (object)array() : $cartSelectedShippingAddress,
    'hasPhysicalProduct' => $hasPhysicalProduct,
    'isShippingSameAsBilling' => $isShippingSameAsBilling,
    'selectedBillingAddressId' => $selectedBillingAddressId,
    'selectedShippingAddressId' => $selectedShippingAddressId,
    'cartProductsCount' => $cartProductsCount,
    'shipProductsCount' => $shipProductsCount,
    'pickUpProductsCount' => $pickUpProductsCount,
);

require_once(CONF_THEME_PATH . 'cart/price-detail.php');

if (empty(array_filter($productsArr))) {
    $status = applicationConstants::OFF;
}
