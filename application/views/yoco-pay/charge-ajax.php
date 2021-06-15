<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--normal');
$frm->setFormTagAttribute('id', 'paymentForm');
$frm->setFormTagAttribute('onsubmit', 'confirmOrder(); return(false);');
$frm->setFormTagAttribute('action', 'javascript:void(0)');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$btn = $frm->getField('btn_submit');
$btn->developerTags['noCaptionTag'] = true;
$btn->setFieldTagAttribute('class', "btn btn-brand btn-wide mt-4");
$btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));

$fld = $frm->getField('card_frame');
$fld->value = '<div class="yoco-form" id="card_frame"></div>';
?>

<?php echo $frm->getFormHtml(); ?>

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
        var btnEle = $("#paymentForm input[type='submit']");
        var btnText = btnEle.val();
        btnEle.val(btnEle.data('processing-text')).attr('disabled', 'disabled');    
        inline.createToken().then(function (result) {
            if (result.error) {         
                btnEle.val(btnText).removeAttr('disabled');
                const errorMessage = result.error.message;
                errorMessage && $.systemMessage(errorMessage, 'alert--danger');
            } else {
                $.mbsmessage(langLbl.processing, false, 'alert--process alert');
                fcom.updateWithAjax(fcom.makeUrl('YocoPay', 'chargeCard', ['<?php echo $orderInfo["id"]; ?>']), {token: result.id}, function (t) {
                    btnEle.val(btnText).removeAttr('disabled');
                    if (t.status == 1) {
                        window.location.href = t.redirectUrl;
                    }
                });
            }
        }).catch(function (error) {
            $.systemMessage(error, 'alert--danger');
            btnEle.val(btnText).removeAttr('disabled');
        });

    }

</script>