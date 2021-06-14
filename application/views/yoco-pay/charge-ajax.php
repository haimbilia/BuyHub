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

$fld = $frm->getField('card_frame');
$fld->value = '<div id="card_frame"></div>';
?>
<div class="text-center">   
    <?php echo $frm->getFormHtml(); ?>
</div>
<script type="text/javascript">
    var sdk = new window.YocoSDK({
        publicKey: '<?php echo $publicKey; ?>'
    });
    var inline = sdk.inline({
        layout: 'basic',
        amountInCents: <?php echo $paymentAmount; ?>,
        currency: '<?php echo $orderInfo["order_currency_code"]; ?>'
    });
    inline.mount('#card_frame');

    function confirmOrder() {
        $.mbsmessage(langLbl.processing, false, 'alert--process alert');
        inline.createToken().then(function (result) {
            if (result.error) {
                const errorMessage = result.error.message;
                errorMessage && $.systemMessage(errorMessage, 'alert--danger', false);
            } else {
                fcom.updateWithAjax(fcom.makeUrl('YocoPay', 'chargeCard', ['<?php echo $orderInfo["id"]; ?>']), {token: result.id}, function (t) {
                    if (t.status == 1) {
                        window.location.href = t.redirectUrl;
                    }
                });
            }
        }).catch(function (error) {
            $.systemMessage(error, 'alert--danger', false);
        });

    }

</script>