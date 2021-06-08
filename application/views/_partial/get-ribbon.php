<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$ribSelProdId = isset($ribSelProdId) ? $ribSelProdId : 0;
$ribProdId = isset($ribProdId) ? $ribProdId : 0;
$ribShopId = isset($ribShopId) ? $ribShopId : 0;
$frontReturn = isset($frontReturn) ? $frontReturn : false;

$obj = new Badge();
$ribbonDetail = $obj->setSellerProdudtId($ribSelProdId)
                        ->setProductId($ribProdId)
                        ->setShopId($ribShopId)
                        ->getRibbonOrBadge($siteLangId);

$html = "";
if (is_array($ribbonDetail) && !empty($ribbonDetail)) {
    foreach ($ribbonDetail as $ribbRow) {
        $position = $ribbRow['blinkcond_position'];
        include CONF_BACK_END_THEME_PATH . '/_partial/get-ribbon.php';
        $html .= $ribbon;
    }
}

if (false === $frontReturn) {
    echo $html;
}
