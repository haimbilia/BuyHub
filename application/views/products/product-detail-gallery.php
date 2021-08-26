<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="img-static" class="product-detail-gallery">
    <?php $data['product'] = $product;
    $data['productImagesArr'] = $productImagesArr;
    $data['imageGallery'] = true; ?>
    <div class="badges-wrap">
        <?php 
            /* Get Ribbon */
            if (!empty($selProdRibbons)) {
                foreach ($selProdRibbons as $ribbRow) {
                    $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $ribbRow], false);
                }
            }
        ?>
    </div>
    <div class="product-gallery">
        <div class="slider-for main-thumb" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="slider-for">
            <?php if ($productImagesArr) { ?>
                <?php foreach ($productImagesArr as $afile_id => $image) {
                    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                    $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                ?>
                    <img alt="" class="xzoom active" id="xzoom-default" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
                <?php break;
                } ?>
            <?php } else {
                $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'MEDIUM', 0)), CONF_IMG_CACHE_TIME, '.jpg');
                $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'ORIGINAL', 0)), CONF_IMG_CACHE_TIME, '.jpg');
                $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'WEBPMEDIUM', 0)), CONF_IMG_CACHE_TIME, '.webp');
            ?>
                <img alt="" class="xzoom" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
            <?php } ?>
        </div>
        <?php if ($productImagesArr) { ?>
            <div class="slider-nav xzoom-thumbs" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="slider-nav">
                <?php foreach ($productImagesArr as $afile_id => $image) {
                    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                    $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'WEBPMEDIUM', 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    /* $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */ ?>
                    <div>
                        <div class="thumb">
                            <a href="<?php echo $originalImgUrl; ?>">
                                <picture>
                                    <source type="image/webp" srcset="<?php echo $mainWebpImgUrl; ?>">
                                    <source type="image/jpeg" srcset="<?php echo $mainImgUrl; ?>">
                                    <img alt="" class="xzoom-gallery" width="80" src="<?php echo $mainImgUrl; ?>">
                                </picture>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>