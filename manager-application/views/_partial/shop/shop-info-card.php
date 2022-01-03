<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$uploadedTime = AttachedFile::setTimeParam($shop['shop_updated_on']);
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId, 'THUMB'), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$onclick = !empty($onclick) ? "onclick = " . $onclick : "onclick = 'redirectToShop(" . $shop['shop_id'] . ")'";
?>
<a href="javascript:void(0)" class="product-profile" <?php echo $onclick; ?>>
    <div class="product-profile__thumbnail" data-ratio="1:1">
        <img data-aspect-ratio="1:1" src="<?php echo $imgSrc; ?>">
    </div>
    <div class="product-profile__data">
        <div class="title"><?php echo $shop['shop_name']; ?></div>
        <?php if (!empty($shop['user_name'])) { ?>
            <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal' : 'list-options--vertical"'; ?>">
                <li>
                    <span class="label"><?php echo Labels::getLabel('LBL_SELLER', $siteLangId); ?>:</span>
                    <span class="value"><?php echo $shop['user_name']; ?></span>
                </li>
            </ul>
        <?php } ?>
    </div>
</a>