<div class="slider-for" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="quickView-slider-for">
    <?php if ($productImagesArr) { ?>
        <?php
        foreach ($productImagesArr as $afile_id => $image) {
            $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_MEDIUM, 0, $image['afile_id'])), CONF_IMG_CACHE_TIME, '.jpg');
            $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id'])), CONF_IMG_CACHE_TIME, '.jpg'); ?>
            <div class="item__main">
                <?php if (isset($imageGallery) && $imageGallery) { ?>
                    <a href="<?php echo $mainImgUrl; ?>" class="gallery" rel="gallery">
                    <?php } ?>
                    <img src="<?php echo $mainImgUrl; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MEDIUM);?>>
                    <?php if (isset($imageGallery) && $imageGallery) { ?>
                    </a>
                <?php } ?>
            </div>
        <?php
        } ?>
    <?php } else {
        $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.jpg'); ?>
        <div class="item__main"><img src="<?php echo $mainImgUrl; ?>">
        </div>
    <?php
    } ?>
</div>
<?php if ($productImagesArr) { ?>
    <div class="slider slider-nav" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="quickView-slider-nav">
        <?php foreach ($productImagesArr as $afile_id => $image) {
            $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_MEDIUM, 0, $image['afile_id'])), CONF_IMG_CACHE_TIME, '.jpg');
            $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id'])), CONF_IMG_CACHE_TIME, '.jpg'); ?>

            <img class="thumb" main-src="<?php echo $mainImgUrl; ?>" src="<?php echo $thumbImgUrl; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_THUMB);?>>

        <?php
        } ?>
    </div>
<?php }
