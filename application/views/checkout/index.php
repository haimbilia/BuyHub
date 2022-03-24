<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script>
    systemEvents.initiateCheckout();
</script>
<section class="section" data-content="">
    <div class="container">
        <div class="checkout-page">
            <main class="checkout-page_main checkout-content-js">
                <?php include(CONF_THEME_PATH . 'checkout/_partial/shipping-summary-skeleton.php'); ?>
            </main>
            <aside class="checkout-page_aside sidebar">
                <div class="sticky-summary">
                    <div class="cart-total summary-listing-js">
                        <?php include(CONF_THEME_PATH . 'checkout/_partial/price-summary-skeleton.php'); ?>
                    </div>
                    <div class="secure">
                        <img class="svg" width="32" height="32" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/shield-fill-check.svg" alt="">
                        <p>
                            <?php echo Labels::getLabel('LBL_SAFE_AND_SECURE_PAYMENTS_EASY_RETURNS_100%_AUTHENTIC_PRODUCTS', $siteLangId); ?>
                        </p>
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
        </svg>
    </span>
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

    $(function() {
        <?php if (empty($addresses) || count($addresses) == 0) { ?>
            showAddressFormDiv();
            loadFinancialSummary();
        <?php } else { ?>
            loadShippingSummaryDiv();
            loadFinancialSummary();
        <?php } ?>
    });
</script>