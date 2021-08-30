<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$appScreenType = CommonHelper::getAppScreenType();
$resType = $appScreenType == applicationConstants::SCREEN_IPAD ? 'TABLET' : 'MOBILE';

foreach ($slides as &$slideDetail) {
    $uploadedTime = AttachedFile::setTimeParam($slideDetail['slide_img_updated_on']);
    $slideDetail['slide_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'slide', array($slideDetail['slide_id'], $appScreenType, $siteLangId, $resType)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $urlTypeData = CommonHelper::getUrlTypeData($slideDetail['slide_url']);

    $slideDetail['slide_url'] = $slideDetail['slide_url_type'] = $slideDetail['slide_url_title'] = "";
    if (false != $urlTypeData) {
        $slideDetail['slide_url'] = ($urlTypeData['urlType'] == applicationConstants::URL_TYPE_EXTERNAL ? $slideDetail['slide_url'] : $urlTypeData['recordId']);
        $slideDetail['slide_url_type'] = $urlTypeData['urlType'];

        switch ($urlTypeData['urlType']) {
            case applicationConstants::URL_TYPE_SHOP:
                $slideDetail['slide_url_title'] = Shop::getName($urlTypeData['recordId'], $siteLangId);
                break;
            case applicationConstants::URL_TYPE_PRODUCT:
                $slideDetail['slide_url_title'] = SellerProduct::getProductDisplayTitle($urlTypeData['recordId'], $siteLangId);
                break;
            case applicationConstants::URL_TYPE_CATEGORY:
                $slideDetail['slide_url_title'] = ProductCategory::getProductCategoryName($urlTypeData['recordId'], $siteLangId);
                break;
            case applicationConstants::URL_TYPE_BRAND:
                $slideDetail['slide_url_title'] = Brand::getBrandName($urlTypeData['recordId'], $siteLangId);
                break;
        }
    }
}

foreach ($collections as &$collectionData) {
    if (array_key_exists('products', $collectionData)) {
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
    } elseif (array_key_exists('categories', $collectionData)) {
        foreach ($collectionData['categories'] as &$category) {
            $imgUpdatedOn = ProductCategory::getAttributesById($category['prodcat_id'], 'prodcat_updated_on');
            $uploadedTime = AttachedFile::setTimeParam($imgUpdatedOn);
            $category['prodcat_name'] = html_entity_decode($category['prodcat_name'], ENT_QUOTES, 'utf-8');
            $category['prodcat_description'] = strip_tags(html_entity_decode($category['prodcat_description'], ENT_QUOTES, 'utf-8'));

            $category['category_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Category', 'banner', array($category['prodcat_id'], $siteLangId, 'MOBILE', applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            
            if (array_key_exists('tLeftRibbons', $category) || array_key_exists('tRightRibbons', $category)) {
                $tLeftRibbons = $category['tLeftRibbons'];
                $tRightRibbons = $category['tRightRibbons'];
                unset($category['tLeftRibbons'], $category['tRightRibbons']);
                foreach ($category['products'] as &$product) {
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
    } elseif (array_key_exists('shops', $collectionData)) {
        foreach ($collectionData['shops'] as &$shop) {
            $shopId = isset($shop['shopData']['shop_id']) ? $shop['shopData']['shop_id'] : $shop['shop_id'];
            $shop['shop_id'] = $shopId;
            $shop['shop_logo'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'shopLogo', array($shopId, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
            $shop['shop_banner'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'shopBanner', array($shopId, $siteLangId, 'MOBILE', 0, applicationConstants::SCREEN_MOBILE)), CONF_IMG_CACHE_TIME, '.jpg');

            if (array_key_exists('tLeftRibbons', $shop) || array_key_exists('tRightRibbons', $shop)) {
                $tLeftRibbons = $shop['tLeftRibbons'];
                $tRightRibbons = $shop['tRightRibbons'];
                unset($shop['tLeftRibbons'], $shop['tRightRibbons']);
                foreach ($shop['products'] as &$product) {
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
    } elseif (array_key_exists('brands', $collectionData)) {
        foreach ($collectionData['brands'] as &$shop) {
            $shop['brand_image'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'brand', array($shop['brand_id'], $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
        }
    } elseif (array_key_exists('testimonials', $collectionData)) {
        foreach ($collectionData['testimonials'] as &$testimonial) {
            $testimonial['user_image'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'testimonial', array($testimonial['testimonial_id'], $siteLangId, 'THUMB')), CONF_IMG_CACHE_TIME, '.jpg');
        }
    } elseif (array_key_exists('banners', $collectionData) && 0 < count((array)$collectionData['banners']) && array_key_exists('banners', $collectionData['banners'])) {
        foreach ($collectionData['banners']['banners'] as &$banner) {
            $uploadedTime = AttachedFile::setTimeParam($banner['banner_updated_on']);
            $urlTypeData = CommonHelper::getUrlTypeData($banner['banner_url']);
            if (false === $urlTypeData) {
                $urlTypeData = array(
                    'url' => $banner['banner_url'],
                    'recordId' => 0,
                    'urlType' => applicationConstants::URL_TYPE_EXTERNAL
                );
            }

            $banner['banner_image'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Banner', 'HomePageBannerTopLayout', array($banner['banner_id'], $siteLangId, CommonHelper::getAppScreenType())) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

            $banner['banner_url'] = ($urlTypeData['urlType'] == applicationConstants::URL_TYPE_EXTERNAL ? $banner['banner_url'] : $urlTypeData['recordId']);
            $banner['banner_url_type'] = $urlTypeData['urlType'];

            switch ($urlTypeData['urlType']) {
                case applicationConstants::URL_TYPE_SHOP:
                    $banner['banner_url_title'] = Shop::getName($urlTypeData['recordId'], $siteLangId);
                    break;
                case applicationConstants::URL_TYPE_PRODUCT:
                    $banner['banner_url_title'] = SellerProduct::getProductDisplayTitle($urlTypeData['recordId'], $siteLangId);
                    break;
                case applicationConstants::URL_TYPE_CATEGORY:
                    $banner['banner_url_title'] = ProductCategory::getProductCategoryName($urlTypeData['recordId'], $siteLangId);
                    break;
                case applicationConstants::URL_TYPE_BRAND:
                    $banner['banner_url_title'] = Brand::getBrandName($urlTypeData['recordId'], $siteLangId);
                    break;
            }
        }
    }
}

$data = array(
    'isWishlistEnable' => $isWishlistEnable,
    'slides' => $slides,
    'collections' => array_values($collections),
);

if (empty($sponsoredProds) && empty($sponsoredShops) && empty($slides) && empty($collections)) {
    $status = applicationConstants::OFF;
}
