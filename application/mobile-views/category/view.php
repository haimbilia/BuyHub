<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

unset($data['frmProductSearch'], $data['postedData']);

if (array_key_exists('products', $data)) {
    foreach ($data['products'] as &$product) {
        $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
        $product['product_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)).$uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
        $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], false, false, false);
    }
}
if (empty($data)) {
    $status = applicationConstants::OFF;
}
