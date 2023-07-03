<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script>
    ykevents.initiateCheckout();
</script>
<section class="section" data-content="">
    <div class="container">
        <div class="checkout-page checkoutPageJs">
            <main class="checkout-page_main checkout-content-js">
                <?php if (empty($addresses) || 0 == count($addresses)) { ?>
                    <ul class="review-block">
                        <li class="review-block-item">
                            <button class="btn btn-add-address" type="button" onclick="showAddressFormDiv()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="svg mb-2" width="38" height="38" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
                                </svg>
                                &nbsp;<?php echo Labels::getLabel('LBL_ADD_NEW_ADDRESS', $siteLangId); ?>
                            </button>
                        </li>
                    </ul>
                <?php } else {
                    include(CONF_THEME_PATH . 'checkout/_partial/shipping-summary-skeleton.php');
                } ?>
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
<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>
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

<?php if (FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '') && User::checkStatisticalCookiesEnabled() == true) {
    echo FatApp::getConfig('CONF_SITE_TRACKER_CODE', FatUtility::VAR_STRING, '');
}
