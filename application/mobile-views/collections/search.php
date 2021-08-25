<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($collections as $collectionIndex => &$collectionData) {
    if (array_key_exists('theprice', $collectionData)) {
        $collectionData['theprice'] = CommonHelper::displayMoneyFormat($collectionData['theprice'], true, true, true);
    }

    if (array_key_exists('tLeftRibbons', $collectionData) || array_key_exists('tRightRibbons', $collectionData)) {
        $tLeftRibbons = $collectionData['tLeftRibbons'];
        $tRightRibbons = $collectionData['tRightRibbons'];
        unset($collectionData['tLeftRibbons'], $collectionData['tRightRibbons']);
        foreach ($collectionData['products'] as &$product) {
            $selProdRibbons = [];
            if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
                $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
            }

            if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
            }

            $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
            $product['product_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $product['discount'] = ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) ? CommonHelper::showProductDiscountedText($product, $siteLangId) : '';
            $product['selprod_price'] = CommonHelper::displayMoneyFormat($product['selprod_price'], false, false, false);
            $product['theprice'] = CommonHelper::displayMoneyFormat($product['theprice'], true, true, true);
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
