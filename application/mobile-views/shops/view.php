<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (array_key_exists('products', $data)) {
    $tRightRibbons = $data['tRightRibbons'];
    unset($data['tRightRibbons']);

    foreach ($data['products'] as $index => &$product) {
        $selProdRibbons = [];
        if (isset($tRightRibbons)) {
            if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
            }
        } else if (isset($product['ribbons'])) {
            $selProdRibbons = $product['ribbons'];
        }
        $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
        $product['product_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_ORIGINAL, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $product['discount'] = ($product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
        $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price']);
        $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice']);
        $product['ribbons'] = $selProdRibbons;
    }
}

if (!empty($data['shop'])) {
    if (isset($data['shop']['shop_payment_policy']) && !empty(array_filter((array)$data['shop']['shop_payment_policy']))) {
        $data['shop']['policies'][] = $data['shop']['shop_payment_policy'];
    }
    if (isset($data['shop']['shop_delivery_policy']) && !empty(array_filter((array)$data['shop']['shop_delivery_policy']))) {
        $data['shop']['policies'][] = $data['shop']['shop_delivery_policy'];
    }
    if (isset($data['shop']['shop_refund_policy']) && !empty(array_filter((array)$data['shop']['shop_refund_policy']))) {
        $data['shop']['policies'][] = $data['shop']['shop_refund_policy'];
    }
    if (isset($data['shop']['shop_additional_info']) && !empty(array_filter((array)$data['shop']['shop_additional_info']))) {
        $data['shop']['policies'][] = $data['shop']['shop_additional_info'];
    }
    if (isset($data['shop']['shop_seller_info']) && !empty(array_filter((array)$data['shop']['shop_seller_info']))) {
        $data['shop']['policies'][] = $data['shop']['shop_seller_info'];
    }

    $data['shop']['policies'] = !empty($data['shop']['policies']) ? $data['shop']['policies'] : [];

    $data['shop']['socialPlatforms'] = !empty($socialPlatforms) ? $socialPlatforms : [];
    unset($data['shop']['shop_payment_policy'], $data['shop']['shop_delivery_policy'], $data['shop']['shop_refund_policy'], $data['shop']['shop_additional_info'], $data['shop']['shop_seller_info']);
}

$data['shop'] = !empty($data['shop']) ? $data['shop'] : (object)array();

if (empty($data['products'])) {
    $status = applicationConstants::OFF;
}
