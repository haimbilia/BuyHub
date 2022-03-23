<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script>
    events.initiateCheckout();
</script>
<section class="section" data-content="">
    <div class="container">
        <div class="checkout-page">
            <main class="checkout-page_main checkout-content-js">
                <?php include(CONF_THEME_PATH . 'checkout/_partial/shipping-summary-skeleton.php'); ?>
            </main>
            <aside class="checkout-page_aside sidebar">
                <div class="cart-total summary-listing-js">
                    <?php include(CONF_THEME_PATH . 'checkout/_partial/price-summary-skeleton.php'); ?>
                </div>
                <div class="secure m-4">
                    <img class="svg" width="32" height="32" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/shield-fill-check.svg" alt="">
                    <p>
                        <?php echo Labels::getLabel('LBL_SAFE_AND_SECURE_PAYMENTS_EASY_RETURNS_100%_AUTHENTIC_PRODUCTS', $siteLangId); ?>
                    </p>
                </div>
                <div class="review-total">
                    <div class="review-total-head">
                        <h3 class="review-total-title dropdown-toggle-custom collapsed" data-bs-toggle="collapse" data-bs-target="#review-cart" aria-haspopup="true" aria-expanded="false" aria-controls="review-cart">
                            <?php echo Labels::getLabel('LBL_Review_Cart', $siteLangId); ?>
                            <span class="count-items"> 4 Items</span><i class="dropdown-toggle-custom-arrow"></i>
                        </h3>
                    </div>
                    <div class="review-total-body collapse" id="review-cart">
                        <ul class="list-cart">
                            <li class="list-cart-item block-cart block-cart-sm">
                                <div class="block-cart-img">
                                    <div class="products-img">
                                        <a href="/yokart/apple-iphone-12-187">
                                            <picture>
                                                <source type="image/webp" srcset="/yokart/image/product/76/WEBPEXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <source type="image/jpeg" srcset="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <img loading="lazy" data-ratio="" src="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" alt="Apple iPhone 12" title="Apple iPhone 12">
                                            </picture>
                                        </a>
                                    </div>
                                </div>
                                <div class="block-cart-detail">
                                    <div class="block-cart-detail-top">
                                        <div class="product-profile">
                                            <div class="product-profile-data">

                                                <a class="title" title="Apple iPhone 12" href="/yokart/apple-iphone-12-187">Apple iPhone 12</a>
                                                <div class="products-price">
                                                    <span class="products-price-new">
                                                        $250.00 </span>
                                                </div>
                                                <div class="options">
                                                    Storage: 64 GB | Color: Green | Quantity: 1 </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                            <li class="list-cart-item block-cart block-cart-sm">
                                <div class="block-cart-img">
                                    <div class="products-img">
                                        <a href="/yokart/apple-iphone-12-187">
                                            <picture>
                                                <source type="image/webp" srcset="/yokart/image/product/76/WEBPEXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <source type="image/jpeg" srcset="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <img loading="lazy" data-ratio="" src="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" alt="Apple iPhone 12" title="Apple iPhone 12">
                                            </picture>
                                        </a>
                                    </div>
                                </div>
                                <div class="block-cart-detail">
                                    <div class="block-cart-detail-top">
                                        <div class="product-profile">
                                            <div class="product-profile-data">

                                                <a class="title" title="Apple iPhone 12" href="/yokart/apple-iphone-12-187">Apple iPhone 12</a>
                                                <div class="products-price">
                                                    <span class="products-price-new">
                                                        $250.00 </span>
                                                </div>
                                                <div class="options">
                                                    Storage: 64 GB | Color: Green | Quantity: 1 </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                            <li class="list-cart-item block-cart block-cart-sm">
                                <div class="block-cart-img">
                                    <div class="products-img">
                                        <a href="/yokart/apple-iphone-12-187">
                                            <picture>
                                                <source type="image/webp" srcset="/yokart/image/product/76/WEBPEXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <source type="image/jpeg" srcset="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <img loading="lazy" data-ratio="" src="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" alt="Apple iPhone 12" title="Apple iPhone 12">
                                            </picture>
                                        </a>
                                    </div>
                                </div>
                                <div class="block-cart-detail">
                                    <div class="block-cart-detail-top">
                                        <div class="product-profile">
                                            <div class="product-profile-data">

                                                <a class="title" title="Apple iPhone 12" href="/yokart/apple-iphone-12-187">Apple iPhone 12</a>
                                                <div class="products-price">
                                                    <span class="products-price-new">
                                                        $250.00 </span>
                                                </div>
                                                <div class="options">
                                                    Storage: 64 GB | Color: Green | Quantity: 1 </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                            <li class="list-cart-item block-cart block-cart-sm">
                                <div class="block-cart-img">
                                    <div class="products-img">
                                        <a href="/yokart/apple-iphone-12-187">
                                            <picture>
                                                <source type="image/webp" srcset="/yokart/image/product/76/WEBPEXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <source type="image/jpeg" srcset="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" media="(max-width: 767px),(max-width: 1024px)">
                                                <img loading="lazy" data-ratio="" src="/yokart/image/product/76/EXTRA-SMALL/187/0/1?t=1625562358" alt="Apple iPhone 12" title="Apple iPhone 12">
                                            </picture>
                                        </a>
                                    </div>
                                </div>
                                <div class="block-cart-detail">
                                    <div class="block-cart-detail-top">
                                        <div class="product-profile">
                                            <div class="product-profile-data">

                                                <a class="title" title="Apple iPhone 12" href="/yokart/apple-iphone-12-187">Apple iPhone 12</a>
                                                <div class="products-price">
                                                    <span class="products-price-new">
                                                        $250.00 </span>
                                                </div>
                                                <div class="options">
                                                    Storage: 64 GB | Color: Green | Quantity: 1 </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

            </aside>
        </div>
    </div>
</section>
<button class="btn-summary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    <span class="btn-summary-text">
        <?php echo Labels::getLabel('LBL_ORDER_SUMMARY', $siteLangId); ?>
        <svg class="svg arrow" width="16" height="16">
            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#arrow-right"></use>
        </svg> </span>
    <span class="btn-summary-price" id="netAmountSummary"></span>
</button>
<!-- offcanvas-order-summary -->
<div class="offcanvas offcanvas-start  offcanvas-order-summary" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h3>Order summery data goes here</h3>

    </div>
</div>

<input id="hasAddress" class="d-none" value="<?php echo (empty($addresses) || count($addresses) == 0) ? 0 : 1 ?>">
<script type="text/javascript">
    <?php if (isset($defaultAddress)) { ?>
        $defaultAddress = 1;
    <?php } else { ?>
        $defaultAddress = 0;
    <?php } ?>

    $("document").ready(function() {
        <?php if (empty($addresses) || count($addresses) == 0) { ?>
            showAddressFormDiv();
            loadFinancialSummary();
        <?php } else { ?>
            loadShippingSummaryDiv();
            loadFinancialSummary();
        <?php } ?>
    });
</script>