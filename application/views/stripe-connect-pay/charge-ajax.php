<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script type="text/javascript">
    function proceedToPayment() {
        var stripe = Stripe("<?php echo $publishableKey; ?>");
        stripe.redirectToCheckout({
            // Make the id field from the Checkout Session creation API response
            // available to this file, so you can provide it as parameter here
            sessionId: "<?php echo $sessionId; ?>"
        }).then(function(result) {
            // If `redirectToCheckout` fails due to a browser or network
            // error, display the localized error message to your customer
            // using `result.error.message`.
            console.log(result);
        });
    }
</script>
<div class="text-center m-2">
    <p class="p-2"><?php echo Labels::getLabel('LBL_REDIRECTS_YOU_TO_PAYMENT_PAGE', $siteLangId); ?></p>
    <a href="javascript:void(0);" onclick="proceedToPayment();" class="btn btn-brand m-2">
        <?php echo Labels::getLabel('LBL_PAY_NOW', $siteLangId); ?>
    </a>
</div>