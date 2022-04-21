<div class="products-foot">
    <div class="products-category"><a href="<?php echo UrlHelper::generateUrl('Category', 'View', array($product['prodcat_id'])); ?>"><?php echo $product['prodcat_name']; ?> </a></div>
    <div class="products-title"><a title="<?php echo $product['selprod_title']; ?>" href="<?php echo !isset($product['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($product['promotion_record_id'])); ?>"><?php echo (mb_strlen($product['selprod_title']) > 50) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']; ?> </a></div>
    <?php include(CONF_THEME_PATH . '_partial/collection/product-price.php'); ?>
</div>