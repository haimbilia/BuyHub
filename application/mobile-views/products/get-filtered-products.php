<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (array_key_exists('products', $data)) {
    $tLeftRibbons = $data['tLeftRibbons'];
    $tRightRibbons = $data['tRightRibbons'];
    unset($data['tLeftRibbons'], $data['tRightRibbons']);
    foreach ($data['products'] as $index => &$product) {
        $selProdRibbons = [];
        if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
            $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
        }

        if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
            $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
        }

        $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
        $product['product_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $product['discount'] = ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
        $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
        $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
        $product['ribbons'] = $selProdRibbons;
    }
}
