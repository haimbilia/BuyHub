<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

unset($data['frmProductSearch'], $data['postedData']);

if (array_key_exists('products', $data)) {
    $tRightRibbons = $data['tRightRibbons'];
    unset($data['tRightRibbons']);
    foreach ($data['products'] as &$product) {
        $selProdRibbons = [];
        if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
            $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
        }

        $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
        $product['product_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_CLAYOUT3, $product['selprod_id'], 0, $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $product['discount'] = ($product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
        $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price']);
        $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice']);
        $product['ribbons'] = $selProdRibbons;

        $currentStock = $product['selprod_stock'] - Product::tempHoldStockCount($product['selprod_id']);
        $product['isOutOfMinOrderQty'] = ((int)($product['selprod_min_order_qty'] > $currentStock));
    }
}
if (empty($data)) {
    $status = applicationConstants::OFF;
}
