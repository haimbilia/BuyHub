<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$data = array(
    'wish_list_id' => $wish_list_id,
    'totalWishListItems' => $totalWishListItems,
);

if (0 < $removeFromCart) {
    $tplFile = str_replace( CONF_APPLICATION_PATH, CONF_INSTALLATION_PATH.CONF_FRONT_END_APPLICATION_DIR, CONF_THEME_PATH );
    $tplFile .= 'cart/price-detail.php';
    require_once($tplFile);
}