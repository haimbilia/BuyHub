<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($collections as $collectionIndex => &$collectionData) {
    if (array_key_exists('tRightRibbons', $collectionData)) {
        $tRightRibbons = $collectionData['tRightRibbons'];
        unset($collectionData['tRightRibbons']);
        foreach ($collectionData['products'] as &$product) {
            $selProdRibbons = [];
            if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
            }

            $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
            $product['product_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_CLAYOUT3, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $product['discount'] = ($product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
            $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price']);
            $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice']);
            $product['ribbons'] = $selProdRibbons;
        }
    }
}

$data = array(
    'recordCount' => !empty($recordCount) ? $recordCount : 0,
    'collection' => !empty($collection) ? $collection : (object)array(),
    'collectionItems' => !empty($collections) ? array_values($collections) : array(),
);


if (empty((array)$collection)) {
    $status = applicationConstants::OFF;
}
