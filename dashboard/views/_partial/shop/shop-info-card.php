<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$uploadedTime = AttachedFile::setTimeParam($shop['shop_updated_on']);
$shopId = (int)$shop['shop_id'];
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shopId, $siteLangId, ImageDimension::VIEW_THUMB), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$getShopAspectRatio = ImageDimension::getData(ImageDimension::TYPE_SHOP_LOGO, ImageDimension::VIEW_THUMB);
$onclick = !empty($onclick) ? "onclick = '" . $onclick . "'" : "onclick = 'redirectToShop(" . $shopId . ")'";
$useFeatherLightJs = $useFeatherLightJs ?? 0;
$showImage = $showImage ?? true;

$imgOrgUrl = 'javascript:void(0)';
$cls = 'product-profile';
if (1 == $useFeatherLightJs) {
    $imgOrgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shopId, $siteLangId, ImageDimension::VIEW_ORIGINAL), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $onclick = 'data-featherlight="image"';
    $cls .= ' featherLightJs';
}

$showAdminImage = $showAdminImage ?? false;
?>
<div class="<?php echo $cls; ?>">
    <?php if ($showImage) { ?>
        <div class="product-profile-thumbnail" data-ratio="<?php echo $getShopAspectRatio[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>">
            <?php if ($showAdminImage) {
                $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateUrl('image', 'favicon', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            ?>
                <img src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId); ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId) ?>" width="60" height="60">
            <?php } else { ?>
                <a href="<?php echo $imgOrgUrl; ?>" <?php echo $onclick; ?>>
                    <img data-aspect-ratio="<?php echo $getShopAspectRatio[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>" src="<?php echo $imgSrc; ?>" width="60" height="60">
                </a>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="product-profile-data">
        <div class="title"><?php echo $shop['shop_name']; ?></div>
        <?php if (!empty($shop['user_name'])) { ?>
            <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal' : 'list-options--vertical"'; ?>">
                <li>
                    <span class="label">
                        <?php
                        $lbl = Labels::getLabel('LBL_SELLER', $siteLangId);
                        $userIsAdvertiser = $shop['user_is_advertiser'] ?? 0;
                        if (1 > $shopId && 0 < $userIsAdvertiser) {
                            $lbl = Labels::getLabel('LBL_ADVERTISER', $siteLangId);
                        } ?>
                        <?php echo $lbl; ?>:
                    </span>
                    <span class="value"><?php echo $shop['user_name']; ?></span>
                </li>
            </ul>
        <?php } ?>

        <?php
        if (isset($shop['extra_text']) || !empty($shop['extra_text'])) {
            if (is_array($shop['extra_text'])) {
                foreach ($shop['extra_text'] as $d) {
                    $class = $d['class'] ?? '';
                    $text = $d['text'] ?? '';
                    echo '<span class="' . $class . '">' . $text . '</span>';
                }
            } else {
                $class = $shop['extra_text_class'] ?? '';
                echo '<span class="' . $class . '">' . $shop['extra_text'] . '</span>';
            }
        }
        ?>
    </div>
</div>