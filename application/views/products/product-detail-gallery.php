<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="img-static" class="product-detail-gallery">
    <?php $data['product'] = $product;
    $data['productImagesArr'] = $productImagesArr;
    $data['imageGallery'] = true;

    /* Get Ribbon */
    $ribSelProdId = $product['selprod_id'];
    $ribProdId = $product['product_id'];
    $ribShopId = $product['shop_id'];
    $isFront = true;
    include(CONF_THEME_PATH . '_partial/get-ribbon.php'); ?>

    <div class="slider-for" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="slider-for">
        <?php 
        if ($productImagesArr) { ?>
            <?php foreach ($productImagesArr as $afile_id => $image) {
                $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']); 
                $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>
                <img alt="" class="xzoom active" id="xzoom-default" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
            <?php break;
            } ?>
        <?php } else {
            $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'MEDIUM', 0)), CONF_IMG_CACHE_TIME, '.jpg');
            $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'ORIGINAL', 0)), CONF_IMG_CACHE_TIME, '.jpg'); ?>
            <img alt="" class="xzoom" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
        <?php } ?>
    </div>
    <?php if ($productImagesArr) { ?>
        <div class="slider-nav xzoom-thumbs" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="slider-nav">
            <?php foreach ($productImagesArr as $afile_id => $image) {
                $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']); 
                $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                /* $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */ ?>
                <div class="thumb"><a href="<?php echo $originalImgUrl; ?>"><img alt="" class="xzoom-gallery" width="80" src="<?php echo $mainImgUrl; ?>"></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>