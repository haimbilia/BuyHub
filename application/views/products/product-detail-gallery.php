<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="product-detail-gallery">
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
                    $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_ORIGINAL, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_LARGE, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                ?>

                    <img class="thumbnail featherLightJs" data-featherlight="image" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">

                <?php break;
                } ?>
            <?php } else {
                $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.jpg');
                $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_ORIGINAL, 0)), CONF_IMG_CACHE_TIME, '.jpg');
                $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'WEBP' . ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.webp');
            ?>

                <img class="thumbnail featherLightJs" data-featherlight="image" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">

            <?php } ?>
        </div>
        <?php if ($productImagesArr) { ?>
            <div class="slider-nav" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="slider-nav">
                <?php foreach ($productImagesArr as $afile_id => $image) {
                    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                    $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_ORIGINAL, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_MEDIUM, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'WEBP' . ImageDimension::VIEW_MEDIUM, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    /* $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */ ?>
                    <a class="thumb featherLightJs" href="<?php echo $originalImgUrl; ?>" data-featherlight="image">
                        <picture>
                            <source type="image/webp" srcset="<?php echo $mainWebpImgUrl; ?>">
                            <source type="image/jpeg" srcset="<?php echo $mainImgUrl; ?>">
                            <img width="80" height="80" src="<?php echo $mainImgUrl; ?>">
                        </picture>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>