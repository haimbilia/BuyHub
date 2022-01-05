<div class="shop-layout-2">
    <?php $i = 0;
    foreach ($collection['shops'] as $shop) {
        $uploadedTime = AttachedFile::setTimeParam($shop['shopData']['shop_updated_on']); ?>
        <div class="shop">
            <div class="shop-body">
                <a title="" href="">
                    <?php
                    $pictureAttr = [
                        'webpImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shop['shopData']['shop_id'], $siteLangId, "WEBPTHUMB", 0, false), CONF_WEBROOT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'),
                        'jpgImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shop['shopData']['shop_id'], $siteLangId, "THUMB", 0, false), CONF_WEBROOT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                        'alt' => $shop['shopData']['shop_name'],
                        'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shop['shopData']['shop_id'], $siteLangId, "THUMB", 0, false), CONF_WEBROOT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                        'siteLangId' => $siteLangId,
                    ];

                    $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                    ?>
                </a>
            </div>
            <div class="shop-foot">

                <div class="shop-title"><a href="<?php echo (!isset($shop['shopData']['promotion_id']) ? UrlHelper::generateUrl('shops', 'view', array($shop['shopData']['shop_id'])) : UrlHelper::generateUrl('shops', 'track', array($shop['shopData']['promotion_record_id'], Promotion::REDIRECT_SHOP, $shop['shopData']['promotion_record_id']))); ?>"><?php echo $shop['shopData']['shop_name']; ?></a>
                </div>
                <div class="shop-location">
                    <?php echo $shop['shopData']['state_name']; ?><?php echo ($shop['shopData']['country_name'] && $shop['shopData']['state_name']) ? ', ' : ''; ?><?php echo $shop['shopData']['country_name']; ?>
                </div>


                <?php if (round($collection['rating'][$shop['shopData']['shop_id']]) > 0) { ?>
                    <div class="product-ratings">
                        <i class="icn"><svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                            </svg></i>
                        <span class="rate">
                            <?php echo  round($collection['rating'][$shop['shopData']['shop_id']], 1); ?><span>

                            </span>
                        </span>
                    </div>
                <?php } ?>

                <div class="shop-action">
                    <a href="<?php echo (!isset($shop['shopData']['promotion_id']) ? UrlHelper::generateUrl('shops', 'view', array($shop['shopData']['shop_id'])) : UrlHelper::generateUrl('shops', 'track', array($shop['shopData']['promotion_record_id'], Promotion::REDIRECT_SHOP, $shop['shopData']['promotion_record_id']))); ?>"> <button class="btn btn-outline-black btn-sm" type="button"><?php echo Labels::getLabel('LBL_Shop_Now', $siteLangId); ?></button></a>
                </div>

            </div>
        </div>


    <?php $i++;
        isset($shop['shopData']['promotion_id']) ? Promotion::updateImpressionData($shop['shopData']['promotion_id']) : '';
        if ($i == Collections::LIMIT_SHOP_LAYOUT2) break;
    } ?>
</div>