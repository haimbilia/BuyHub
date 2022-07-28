<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($products as $key => &$product) {
    $selProdRibbons = [];
    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
    }

    $product['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_CLAYOUT3, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
    $product['discount'] = ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
    $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price']);
    $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice']);
    $product['ribbons'] = $selProdRibbons;

    $optionTitle = '';
    if (is_array($product['options']) && count($product['options'])) {
        foreach ($product['options'] as $op) {
            $optionTitle .= $op['option_name'] . ': ' . $op['optionvalue_name'] . ', ';
        }
    }
    $product['optionsTitle'] = rtrim($optionTitle, ', ');

    $currentStock = $product['selprod_stock'] - Product::tempHoldStockCount($product['selprod_id']);
    $product['isOutOfMinOrderQty'] = ((int)($product['selprod_min_order_qty'] > $currentStock));
}

$data = array(
    'products' => $products,
    'showProductShortDescription' => $showProductShortDescription,
    'showProductReturnPolicy' => $showProductReturnPolicy,
    'page' => $page,
    'recordCount' => $recordCount,
    'pageCount' => $pageCount,
);


if (empty($products)) {
    $status = applicationConstants::OFF;
}
