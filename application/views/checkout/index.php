<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script>
    ykevents.initiateCheckout();
</script>
<section class="section" data-content="">
    <div class="container">
        <div class="checkout-page checkoutPageJs">
            <main class="checkout-page_main checkout-content-js">
                <?php include(CONF_THEME_PATH . 'checkout/_partial/shipping-summary-skeleton.php'); ?>
            </main>
            <aside class="checkout-page_aside">
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