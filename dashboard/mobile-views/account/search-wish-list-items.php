<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($products as $key => $product) {
    $products[$key]['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);
    $products[$key]['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
    $products[$key]['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
    $products[$key]['discount'] = ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';

    $optionTitle = '';
    if (is_array($product['options']) && count($product['options'])) {
        foreach ($product['options'] as $op) {
            $optionTitle .= $op['option_name'] . ': ' . $op['optionvalue_name'] . ', ';
        }
    }
    $products[$key]['optionsTitle'] = rtrim($optionTitle, ', ');
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
