<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$buyQuantity = $frmBuyProduct->getField('quantity');
$buyQuantity->addFieldTagAttribute('class', 'qty-input cartQtyTextBox productQty-js');
$buyQuantity->addFieldTagAttribute('data-page', 'product-view'); ?>
<div id="body" class="body detail-page">
    <section class="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="breadcrumb">
                        <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php');  ?>
                    </div>
                    <div class="detail-first-fold">
                        <?php include('product-detail-gallery.php'); ?>
                        <?php include('product-description.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="relatedProductsSectionJs"></div>

    <section class="section">
        <div class="container">
            <?php include('prod-desc-nav-detail.php'); ?>
        </div>
    </section>

    <div class="recommendedProductsSectionJs"></div>

    <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0) && (!empty($reviews) || $canSubmitFeedback)) {
        echo $frmReviewSearch->getFormHtml();
        $product_id = $product['product_id'];
        include(CONF_THEME_PATH . '_partial/product-reviews.php');
    } ?>

    <!-- Banners -->
    <?php include('banners.php'); ?>
    <!-- Banners -->


    <div class="recentlyViewedProductsSectionJs"></div>

</div>

<script>
    var mainSelprodId = <?php echo $product['selprod_id']; ?>;
    var layout = '<?php echo CommonHelper::getLayoutDirection(); ?>';

    $(function() {
        let fnCalled = false;
        $(window).scroll(function() {
            if (false == fnCalled) {
                fnCalled = true;
                interRelatedProducts(<?php echo $product['selprod_id']; ?>);
            }
        });

        /*zheight = $(window).height() - 180; */
        zwidth = $(window).width() / 3 - 15;

        window.setInterval(function() {
            var scrollPos = $(window).scrollTop();
            if (scrollPos > 0) {
                setProductWeightage('<?php echo $product['selprod_code']; ?>');
            }
        }, 5000);

        $("#btnAddToCart").addClass("quickView");
        // $('#slider-for').slick(getSlickGallerySettings(false));
        // $('#slider-nav').slick(getSlickGallerySettings(true, '<?php /* echo CommonHelper::getLayoutDirection(); */ ?>'));

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
        <?php } ?> "image": "<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id'])), CONF_IMG_CACHE_TIME, '.jpg'); ?>",
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
<script>
    jwplayer.key = '<?php echo FatApp::getConfig("CONF_JW_PLAYER_KEY", null, ''); ?>';
</script>
<!-- JWPlayer -->