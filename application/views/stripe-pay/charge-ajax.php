<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
if (false === $processRequest) {
    $frm->setFormTagAttribute('onsubmit', 'confirmOrder(this); return(false);');
}

$frm->setFormTagAttribute('id', 'paymentFormJs');
$btn = $frm->getField('btn_submit');
if (null != $btn) {
    $btn->developerTags['noCaptionTag'] = true;
    $btn->setFieldTagAttribute('class', "btn btn-secondary btn-wide");
}
?>
<div class="text-center" id="paymentFormElement-js">
    <?php if (false === $processRequest) { ?>
        <h6><?php echo Labels::getLabel('LBL_PROCEED_TO_PAYMENT_?', $siteLangId); ?></h6>
    <?php } else { ?>
        <h6><?php echo Labels::getLabel('LBL_REDIRECTING_TO_PAYMENT_PAGE...', $siteLangId); ?></h6>
    <?php } ?>
    <?php echo $frm->getFormHtml(); ?>
</div>
<script type="text/javascript">
    function confirmOrder(frm) {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action');
        var submitBtn = $("form#paymentFormJs input[type='submit']");
        fcom.displayProcessing();
        submitBtn.attr('disabled', 'disabled');
        fcom.ajax(action, data, function(res) {
            var json = $.parseJSON(res);

            if (1 > json.status) {
                submitBtn.removeAttr('disabled');
                fcom.displayErrorMessage(json.msg);
                return false;
            }
            // $("#paymentFormElement-js").replaceWith(json.html);
            window.location.href = json.redirectUrl;
        });
    }
</script>