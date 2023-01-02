<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$frm->setFormTagAttribute('class', 'form form--normal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'confirmOrder(this); return(false);');
?>
<div class="">
    <p><strong><?php echo sprintf(Labels::getLabel('LBL_PAY_USING_PAYMENT_METHOD', $siteLangId), $paymentMethod["plugin_name"]) ?>:</strong></p><br />
    <?php
    if (!isset($error)) {
        echo $frm->getFormHtml();
    }
    ?>
</div>
<script type="text/javascript">
    $("document").ready(function() {
        <?php if (isset($error)) { ?>
            fcom.displaySuccessMessage(<?php echo $error; ?>);
        <?php } ?>
    });

    function confirmOrder(frm) {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action');
        $('.checkout-content-js').prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('WalletPay', 'confirmOrder'), data, function(ans) {
            fcom.removeLoader();
            fcom.closeProcessing();
            $(location).attr("href", action);
        });
    }
</script>
<?php
$siteKey = FatApp::getConfig('CONF_RECAPTCHA_SITEKEY', FatUtility::VAR_STRING, '');
$secretKey = FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY', FatUtility::VAR_STRING, '');
if (!empty($siteKey) && !empty($secretKey) && isset($paymentMethod['plugin_code']) && in_array(strtolower($paymentMethod['plugin_code']), ['cashondelivery', 'payatstore'])) { ?>
    <script src='https://www.google.com/recaptcha/api.js?onload=googleCaptcha&render=<?php echo $siteKey; ?>'></script>
<?php } ?>