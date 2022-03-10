<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script>
    events.initiateCheckout();
</script>

<section class="section" data-content="">
    <div class="container">
        <div class="checkout-page">
            <main class="checkout-page_main checkout-content-js"> </main>
            <aside class="checkout-page_aside sidebar" data-close-on-click-outside="">
                <div class="cart-total summary-listing-js">
                    <?php echo FatUtility::decodeHtmlEntities($pageData['epage_content']); ?>
                </div>
                <div class="secure">
                    <img class="svg" width="32" height="32" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/shield-fill-check.svg" alt="">
                    <p> <?php echo Labels::getLabel('LBL_Safe_and_Secure_Payments_Easy_returns_100%_Authentic_products', $siteLangId); ?>
                    </p>
                </div>
                <div class="review-total">
                    <div class="review-total-head">
                        <h3 class="review-total-title">
                            <?php echo Labels::getLabel('LBL_Review_Cart', $siteLangId); ?>
                            <span> 4 Items</span>
                        </h3>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</section>
<button class="btn-summary" data-trigger="order-summary">
    <span class="btn-summary-text">
        <?php echo Labels::getLabel('LBL_ORDER_SUMMARY', $siteLangId); ?>
        <svg class="svg arrow" width="16" height="16">
            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#arrow-right"></use>
        </svg> </span>
    <span class="btn-summary-price" id="netAmountSummary"></span>
</button>
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