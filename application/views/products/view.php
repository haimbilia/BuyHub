<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$buyQuantity = $frmBuyProduct->getField('quantity');
$buyQuantity->addFieldTagAttribute('class', 'qty-input cartQtyTextBox productQty-js');
$buyQuantity->addFieldTagAttribute('data-page', 'product-view'); ?>
<div id="body" class="body detail-page">
    <section class="">
        <div class="container">
            <div class="py-4">
                <div class="breadcrumbs breadcrumbs--center">
                    <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php');  ?>
                </div>
            </div>
            <div class="detail-wrapper">
                <div class="detail-first-fold ">
                    <div class="row justify-content-between">
                        <div class="col-lg-7 relative">
                            <?php include('product-detail-gallery.php'); ?>
                        </div>
                        <div class="col-lg-5 col-details-right">
                            <?php include('product-description.php'); ?>
                        </div>
                    </div>
                </div>
                <?php include('more-sellers.php');  ?>
            </div>

            <?php 
                include('prod-desc-nav-detail.php'); 
                include('banners.php'); 
            ?>
        </div>
    </section>
    <?php if ($recommendedProducts) { ?>
    <section class="section bg-brand-light">
        <?php include(CONF_THEME_PATH . 'products/recommended-products.php'); ?>
    </section>
    <?php } ?>
    <?php if ($relatedProductsRs) { ?>
    <section class="section">
        <?php include(CONF_THEME_PATH . 'products/related-products.php'); ?>
    </section>
    <?php } ?>
    <div id="recentlyViewedProductsDiv"></div>
</div>
<script>
var mainSelprodId = <?php echo $product['selprod_id']; ?>;
var layout = '<?php echo CommonHelper::getLayoutDirection(); ?>';

$(document).ready(function() {
    recentlyViewedProducts(<?php echo $product['selprod_id']; ?>);
    /*zheight = $(window).height() - 180; */
    zwidth = $(window).width() / 3 - 15;

    if (layout == 'rtl') {
        $('.xzoom, .xzoom-gallery').xzoom({
            zoomWidth: zwidth,
            /*zoomHeight: zheight,*/
            title: true,
            tint: '#333',
            position: 'left'
        });
    } else {
        $('.xzoom, .xzoom-gallery').xzoom({
            zoomWidth: zwidth,
            /*zoomHeight: zheight,*/
            title: true,
            tint: '#333',
            Xoffset: 2
        });
    }

    window.setInterval(function() {
        var scrollPos = $(window).scrollTop();
        if (scrollPos > 0) {
            setProductWeightage('<?php echo $product['selprod_code']; ?>');
        }
    }, 5000);

    $("#btnAddToCart").addClass("quickView");
    $('#slider-for').slick(getSlickGallerySettings(false));
    $('#slider-nav').slick(getSlickGallerySettings(true, '<?php echo CommonHelper::getLayoutDirection(); ?>'));

    /* for toggling of tab/list view[ */
    $('.list-js').hide();
    $('.view--link-js').on('click', function(e) {
        $('.view--link-js').removeClass("btn--active");
        $(this).addClass("btn--active");
        if ($(this).hasClass('list')) {
            $('.tab-js').hide();
            $('.list-js').show();
        } else if ($(this).hasClass('tab')) {
            $('.list-js').hide();
            $('.tab-js').show();
        }
    });
    /* ] */

    $(".nav-scroll-js").click(function(event) {
        event.preventDefault();
        var full_url = this.href;
        var parts = full_url.split("#");
        var trgt = parts[1];
        /* var target_offset = $("#" + trgt).offset();
        var target_top = target_offset.top - $('#header').height();
        $('html, body').animate({
            scrollTop: target_top
        }, 800); */
        $('html, body').animate({
            scrollTop: parseInt($("#" + trgt).position().top) + parseInt($("#scrollUpTo-js")
                .position().top)
        }, 800);

    });
    $('.nav-detail-js li a').click(function() {
        $('.nav-detail-js li a').removeClass('is-active');
        $(this).addClass('is-active');
    });

    var headerHeight = $("#header").height();
    $(".nav-detail-js").css('top', headerHeight);

});
</script>

<!-- Product Schema Code -->
<?php
$image = AttachedFile::getAttachment(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']); ?>
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Product",
    <?php if (isset($reviews['prod_rating']) && 0 < $reviews['prod_rating']) { ?> "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "<?php echo round(FatUtility::convertToType($reviews['prod_rating'], FatUtility::VAR_FLOAT), 1); ?>",
        "reviewCount": "<?php echo FatUtility::int($reviews['totReviews']); ?>"
    },
    <?php } ?> "description": "<?php echo strip_tags(CommonHelper::renderHtml($product['product_description'])); ?>",
    "name": "<?php echo $product['selprod_title']; ?>",
    <?php if (isset($product['brand_name']) && $product['brand_name'] != '') { ?> "brand": "<?php echo $product['brand_name']; ?>",
    <?php } ?>
    <?php if (isset($product['selprod_sku']) && $product['selprod_sku'] != '') { ?> "sku": "<?php echo $product['selprod_sku']; ?>",
    <?php } ?> "image": "<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'])), CONF_IMG_CACHE_TIME, '.jpg'); ?>",
    "offers": {
        "@type": "Offer",
        "availability": "http://schema.org/InStock",
        "price": "<?php echo $product['theprice']; ?>",
        "url": "<?php echo UrlHelper::generateFullUrl('Products', 'view', [$product['selprod_id']]); ?>",
        "priceCurrency": "<?php echo CommonHelper::getCurrencyCode(); ?>"
    }
}
</script>

<!-- End Product Schema Code -->

<!--Here is the facebook OG for this product  -->
<?php echo $this->includeTemplate('_partial/shareThisScript.php'); ?>

<!-- JWPlayer -->
<script type="text/JavaScript">
    jwplayer.key='<?php echo FatApp::getConfig("CONF_JW_PLAYER_KEY", null, ''); ?>';
</script>
<!-- JWPlayer -->