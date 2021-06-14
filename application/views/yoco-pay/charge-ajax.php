<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--normal');
$frm->setFormTagAttribute('onsubmit', 'confirmOrder(); return(false);');
$frm->setFormTagAttribute('action', 'javascript:void(0)');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$btn = $frm->getField('btn_submit');
$btn->developerTags['noCaptionTag'] = true;
$btn->setFieldTagAttribute('class', "btn btn-secondary btn-wide");
?>
<div class="text-center">
    <h6><?php echo Labels::getLabel('LBL_PROCEED_TO_PAYMENT_?', $siteLangId); ?></h6>
<?php echo $frm->getFormHtml(); ?>
</div>
<script type="text/javascript">
    var yoco = new window.YocoSDK({
        publicKey: '<?php echo $publicKey; ?>',
    });
    function confirmOrder() {
        yoco.showPopup({
            amountInCents: <?php echo $paymentAmount; ?>,
            currency: '<?php echo $orderInfo["order_currency_code"]; ?>',
            name: 'Your Store or Product',
            description: 'Awesome description',
            callback: function (result) {
                // This function returns a token that your server can use to capture a payment
                if (result.error) {
                    const errorMessage = result.error.message;
                    alert("error occured: " + errorMessage);
                } else {
                    var data = {token: result.id, amount:<?php echo $paymentAmount; ?>, currencyCode:'<?php echo $orderInfo["order_currency_code"]; ?>'};
                    fcom.updateWithAjax(fcom.makeUrl('YocoPay', 'createOrder'), data, function (t) {
                        console.log(t);
                    });
                }
                // In a real integration - you would now pass this chargeToken back to your
                // server along with the order/basket that the customer has purchased.
            }
        })
    }


</script>