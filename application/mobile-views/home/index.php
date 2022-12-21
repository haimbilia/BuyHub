<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$appScreenType = CommonHelper::getAppScreenType();
$resType = $appScreenType == applicationConstants::SCREEN_IPAD ? ImageDimension::VIEW_TABLET : ImageDimension::VIEW_MOBILE;

foreach ($slides as &$slideDetail) {
    $uploadedTime = AttachedFile::setTimeParam($slideDetail['slide_img_updated_on']);
    $slideDetail['slide_image_url'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'slide', array($slideDetail['slide_id'], $appScreenType, $siteLangId, $resType)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $urlTypeData = CommonHelper::getUrlTypeData($slideDetail['slide_url']);

    $slideDetail['slide_url'] = $slideDetail['slide_url_type'] = $slideDetail['slide_url_title'] = "";
    if (false != $urlTypeData) {
        $slideDetail['slide_url'] = ($urlTypeData['urlType'] == applicationConstants::URL_TYPE_EXTERNAL ? $slideDetail['url'] : $urlTypeData['recordId']);
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

$data = array(
    'slides' => $slides,
    'collections' => array_values($collections),
);

if (empty($sponsoredProds) && empty($sponsoredShops) && empty($slides) && empty($collections)) {
    $status = applicationConstants::OFF;
}
