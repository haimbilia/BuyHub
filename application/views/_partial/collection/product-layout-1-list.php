<!--product tile-->
<div
    class="products <?php echo (isset($layoutClass)) ? $layoutClass : ''; ?> <?php if ($product['selprod_stock'] <= 0) { ?> item--sold  <?php } ?>">
    <?php if ($product['selprod_stock'] <= 0) { ?>
    <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId); ?></span>
    <?php  } ?>
    <?php $this->includeTemplate('_partial/quick-view.php', ['product' => $product,  'siteLangId' => $siteLangId], false); ?>
    <div class="products_body">
        <?php if (true == $displayProductNotAvailableLable && array_key_exists('availableInLocation', $product) && 0 == $product['availableInLocation']) { ?>
        <div class="not-available">
            <svg class="svg">
                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info"
                    href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                </use>
            </svg> <?php echo Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId); ?>
        </div>
        <?php } ?>
        <?php include(CONF_THEME_PATH . '_partial/collection-ui.php'); ?>
        <?php $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']); ?>
        <div class="products_img">
            <a title="<?php echo $product['selprod_title']; ?>"
                href="<?php echo !isset($product['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($product['promotion_record_id'])); ?>">
                <?php
                $pictureAttr = [
                    'webpImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], (isset($prodImgSize) && isset($i) && ($i == 1)) ? $prodImgSize : "WEBPCLAYOUT3", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'),
                    'jpgImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], (isset($prodImgSize) && isset($i) && ($i == 1)) ? $prodImgSize : "CLAYOUT3", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                    'ratio' => '1:1',
                    'alt' => $product['prodcat_name'],
                ];

                $this->includeTemplate('_partial/picture-tag.php', $pictureAttr); 
            ?>
            </a>
        </div>
    </div>
    <?php $selprod_condition = true;
    include(CONF_THEME_PATH . '_partial/product-listing-footer-section.php'); ?>
</div>
<!--/product tile-->