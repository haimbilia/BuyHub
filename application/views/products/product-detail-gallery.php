<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="product-detail-gallery">
    <?php
    /* Get Ribbon */
    $data['product'] = $product;
    $data['productImagesArr'] = $productImagesArr;
    $data['imageGallery'] = true; ?>
    <div class="badges-wrap">
        <?php
        if (!empty($selProdRibbons)) {
            foreach ($selProdRibbons as $ribbRow) {
                $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $ribbRow], false);
            }
        }
        ?>
    </div>
    <div class="product-gallery" id="detail">
        <div class="product-images demo-gallery">
            <div class="main-img-slider">
                <?php if ($productImagesArr) {
                    foreach ($productImagesArr as $afile_id => $image) {
                        $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                        $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_ORIGINAL, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_LARGE, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                ?>
                        <a data-fancybox="gallery" href="<?php echo $mainImgUrl; ?>">
                            <img class="img-fluid" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
                        </a>
                    <?php
                    }
                } else {
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.jpg');
                    $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_ORIGINAL, 0)), CONF_IMG_CACHE_TIME, '.jpg');
                    $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'WEBP' . ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.webp');
                    ?>
                    <a data-fancybox="gallery" href="<?php echo $mainImgUrl; ?>">
                        <img class="img-fluid" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
                    </a>
                <?php } ?>
            </div>

            <?php if ($productImagesArr) { ?>
                <ul class="thumb-nav">
                    <?php foreach ($productImagesArr as $afile_id => $image) {
                        $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                        $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_MEDIUM, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'WEBP' . ImageDimension::VIEW_MEDIUM, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'); ?>
                        <li>
                            <img src="<?php echo $mainImgUrl; ?>" />
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>

    </div>
</div>