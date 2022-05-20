<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$catBannerArr = [];
$showBanner = $showBanner ?? false;
if (true == $showBanner) {
    $catBannerArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_SHOP_BANNER, $shop['shop_id'], '', $siteLangId);

    if (!empty($catBannerArr)) {
        $catBannerArr = array_column($catBannerArr, 'afile_updated_at', 'afile_screen');
        $screenTypes = applicationConstants::getDisplaysArr($siteLangId);

        foreach ($screenTypes as $screenType => $screenName) {
            $uploadedTime = isset($catBannerArr[$screenType]) ?  AttachedFile::setTimeParam($catBannerArr[$screenType]) : '';
            switch ($screenType) {
                case applicationConstants::SCREEN_MOBILE:
                    $mobileUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, ImageDimension::VIEW_MOBILE, 0, applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mobileWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'WEBP' . ImageDimension::VIEW_MOBILE, 0, applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    break;
                case applicationConstants::SCREEN_IPAD:
                    $tabletUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, ImageDimension::VIEW_TABLET, 0, applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $tabletWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'WEBP' . ImageDimension::VIEW_TABLET, 0, applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    break;
                case applicationConstants::SCREEN_DESKTOP:
                    $desktopUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, ImageDimension::VIEW_DESKTOP, 0, applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $desktopWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopBanner', array($shop['shop_id'], $siteLangId, 'WEBP' . ImageDimension::VIEW_DESKTOP, 0, applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    break;
            }
        }
    }
}

if (!empty($catBannerArr)) { ?>
    <section class="shop-fold">
        <div class="shop-banner">
            <?php
            $pictureAttr = [
                'siteLangId' => $siteLangId,
                'webpImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileWebpUrl, ImageDimension::VIEW_TABLET => $tabletWebpUrl, ImageDimension::VIEW_DESKTOP => $desktopWebpUrl],
                'jpgImageUrl' => [ImageDimension::VIEW_MOBILE => $mobileUrl, ImageDimension::VIEW_TABLET => $tabletUrl, ImageDimension::VIEW_DESKTOP => $desktopUrl],
                'imageUrl' => $desktopUrl,
                'alt' => $shop['shop_name'],
            ];
            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
            ?>
        </div>
    </section>
<?php } ?>
<section class="shop-bar">
    <div class="container">
        <div class="shop-info-wrap">
            <?php
            include(CONF_THEME_PATH . 'shops/shop_info.php');
            $variables = array('template_id' => $template_id, 'shop_id' => $shop['shop_id'], 'shop_user_id' => $shop['shop_user_id'], 'action' => $action, 'siteLangId' => $siteLangId,'shopTotalReviews' => $shopTotalReviews);
            $this->includeTemplate('shops/shop-layout-navigation.php', $variables, false);
            ?>
        </div>
    </div>
</section>