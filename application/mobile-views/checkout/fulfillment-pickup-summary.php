<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

ksort($shippingRates);

foreach ($shippingRates as $pickUpBy => $levelItems) {
    /*  Physical Products */
    if (isset($levelItems['products']) && 0 < count($levelItems['products'])) {
        $productItems[$pickUpBy]['pickup_by'] = $pickUpBy;

        $productData = current($levelItems['products']);
        if (!isset($productItems[$pickUpBy]['title'])) {
            $productItems[$pickUpBy]['title'] =  (0 < $pickUpBy) ? $productData['shop_name'] : FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, null, '');
        }

        
        $productItems[$pickUpBy]['pickup_address'] = (object)[];
        if (!empty($levelItems['pickup_address'])) {
            $productItems[$pickUpBy]['pickup_address'] = (object)$levelItems['pickup_address'];
        }

        $productItems[$pickUpBy]['pickup_addresses'] = [];
        if (count($levelItems['pickup_options']) > 0) {
            $productItems[$pickUpBy]['pickup_addresses'] = $levelItems['pickup_options'];
        }

        foreach ($levelItems['products'] as $product) {
            $product['productUrl'] = UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']));
            $product['shopUrl'] = UrlHelper::generateFullUrl('Shops', 'View', array($product['shop_id']));
            $product['imageUrl'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');

            $productItems[$pickUpBy]['products'][] = $product;
        }
    }

    if (isset($levelItems['digital_products']) && 0 < count($levelItems['digital_products'])) {
        $digiProductData = current($levelItems['digital_products']);
        foreach ($levelItems['digital_products'] as $product) {
            $productItems[$pickUpBy]['title'] = (0 < $pickUpBy) ? $digiProductData['shop_name'] : FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, null, '');;
            $productItems[$pickUpBy]['products'][] = $product;
        }
    }
}
