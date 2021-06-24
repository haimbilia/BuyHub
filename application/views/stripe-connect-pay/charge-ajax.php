<?php

use PhpParser\Node\Stmt\Label;

defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script type="text/javascript">
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
</script>