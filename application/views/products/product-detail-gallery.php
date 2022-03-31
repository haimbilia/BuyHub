<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>


<script src="js/jquery.fancybox.min.js"></script>
<script id="rendered-js">
    /*--------------*/

    // Main/Product image slider for product page
    $("#detail .main-img-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 300,
        lazyLoad: "ondemand",
        asNavFor: ".thumb-nav",
        prevArrow: '<div class="slick-prev"><i class="i-prev"></i><span class="sr-only sr-only-focusable"><</span></div>',
        nextArrow: '<div class="slick-next"><i class="i-next"></i><span class="sr-only sr-only-focusable">></span></div>',
    });

    // Thumbnail/alternates slider for product page
    $(".thumb-nav").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        centerPadding: "0px",
        asNavFor: ".main-img-slider",
        dots: false,
        centerMode: false,
        draggable: true,
        speed: 200,
        focusOnSelect: true,
        prevArrow: '<div class="slick-prev"><i class="i-prev"></i><span class="sr-only sr-only-focusable"><</span></div>',
        nextArrow: '<div class="slick-next"><i class="i-next"></i><span class="sr-only sr-only-focusable">></span></div>',
    });

    //keeps thumbnails active when changing main image, via mouse/touch drag/swipe
    $(".main-img-slider").on("afterChange", function(event, slick, currentSlide, nextSlide) {
        //remove all active class
        $(".thumb-nav .slick-slide").removeClass("slick-current");
        //set active class for current slide
        $(".thumb-nav .slick-slide:not(.slick-cloned)").eq(currentSlide).addClass("slick-current");
    });
</script>

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
    <div class="product-gallery featherLightGalleryJs">
        <div class="slider-for main-thumb" dir="<?php echo CommonHelper::getLayoutDirection(); ?>" id="slider-for">
            <?php if ($productImagesArr) { ?>
                <?php foreach ($productImagesArr as $afile_id => $image) {
                    $uploadedTime = AttachedFile::setTimeParam($image['afile_updated_at']);
                    $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_ORIGINAL, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_LARGE, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id'])) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                ?>
                    <img class="thumbnail" data-featherlight="image" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
                <?php break;
                } ?>
            <?php } else {
                $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.jpg');
                $originalImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_ORIGINAL, 0)), CONF_IMG_CACHE_TIME, '.jpg');
                $mainWebpImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'WEBP' . ImageDimension::VIEW_MEDIUM, 0)), CONF_IMG_CACHE_TIME, '.webp');
            ?>
                <img class="thumbnail" data-featherlight="image" src="<?php echo $mainImgUrl; ?>" data-xoriginal="<?php echo $originalImgUrl; ?>">
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
                    <a class="thumb" href="<?php echo $originalImgUrl; ?>" data-featherlight="image">
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