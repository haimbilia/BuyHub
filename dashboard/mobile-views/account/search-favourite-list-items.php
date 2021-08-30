<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($products as $key => &$product) {
    $selProdRibbons = [];
    if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
        $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
    }

    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
    }

    $product['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
    $product['discount'] = ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
    $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
    $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
    $product['ribbons'] = $selProdRibbons;
}

$data = array(
    'products' => $products,
    'showProductShortDescription' => $showProductShortDescription,
    'showProductReturnPolicy' => $showProductReturnPolicy,
    'page' => $page,
    'recordCount' => $recordCount,
    'pageCount' => $pageCount,
    'postedData' => $postedData,
    'startRecord' => $startRecord,
    'endRecord' => $endRecord,
);

if (1 > $recordCount) {
    $status = applicationConstants::OFF;
}
