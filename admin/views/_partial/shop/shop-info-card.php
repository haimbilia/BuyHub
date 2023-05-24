<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
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
?>
<div class="<?php echo $cls; ?>">
    <?php if ($showImage) { ?>
        <div class="product-profile__thumbnail" data-ratio="<?php echo $getShopAspectRatio[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>">
            <a href="<?php echo $imgOrgUrl; ?>" <?php echo $onclick; ?>>
                <img data-aspect-ratio="<?php echo $getShopAspectRatio[ImageDimension::VIEW_THUMB]['aspectRatio']; ?>" src="<?php echo $imgSrc; ?>">
            </a>
        </div>
    <?php } ?>
    <div class="product-profile__data">
        <div class="title"><?php echo $shop['shop_name']; ?></div>
        <?php if (!empty($shop['user_name'])) { ?>
            <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal' : 'list-options--vertical"'; ?>">
                <li>
                    <span class="label"><?php echo Labels::getLabel('LBL_SELLER', $siteLangId); ?>:</span>
                    <a href="javascript:void();" onclick="redirectUser(<?php echo $shop['user_id'] ?? $shop['shop_user_id']; ?>);" class="value"><?php echo $shop['user_name']; ?></a>
                </li>
            </ul>
        <?php } ?>
    </div>
</div>