<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$pmethodName = $paymentMethod["plugin_name"];
$pmethodCode = $paymentMethod["plugin_code"];

$frm->setFormTagAttribute('class', 'form form--normal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'confirmOrder(this); return(false);');
$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand");
?>
<div class="text-center paymentFormSection-js d-none">
    <?php if (!isset($error)) {
        echo $frm->getFormHtml();
    }
    ?>
</div>
<script type="text/javascript">
    var paymentMethodBlockJs = '<?php echo $pmethodCode; ?>-js';
    function confirmOrder(frm) {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action')
        var getExternalLibraryUrl = $(frm).data('external');
        fcom.displayProcessing();
        fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'confirmOrder'), data, function(res) {
            fcom.removeLoader();
            try {
                var ans = $.parseJSON(res);
                if (1 > ans.status) {
                    fcom.displayErrorMessage(ans.msg);
                    return false;
                }

            } catch (e) {
                // console.log(e);
            }

            if ('undefined' != typeof getExternalLibraryUrl) {
                fcom.ajax(getExternalLibraryUrl, '', function(t) {
                    var json = $.parseJSON(t);
                    if (1 > json.status) {
                        $("." + paymentMethodBlockJs + " form input[type='submit']").val(langLbl.confirmPayment);
                        fcom.displayErrorMessage(json.msg);
                        return;
                    }

                    if (0 < (json.libraries).length) {
                        $.each(json.libraries, function(key, src) {
                            loadScript(src, loadChargeForm, [action]);
                        });
                    } else {
                        loadChargeForm(action);
                    }
                });
            } else {
                loadChargeForm(action);
            }
        });
    }

    function loadChargeForm(action) {
        fcom.ajax(action, '', function(t) {
            $.ykmsg.close();
            fcom.removeLoader();
            try {
                var ans = $.parseJSON(t);
                if (1 > ans.status) {
                    fcom.displayErrorMessage(ans.msg);
                    $('.' + paymentMethodBlockJs).html(ans.msg);
                    return false;
                } else if ('undefined' != typeof ans.redirect) {
                    location.href = ans.redirect;
                } else {
                    $('.' + paymentMethodBlockJs).html(ans.html);
                    <?php if ('stripeconnect' == strtolower($pmethodCode)) { ?>
                        $('.' + paymentMethodBlockJs).addClass('p-0');
                    <?php } ?>
                }
            } catch (e) {
                // console.log(e);
            }
        });
    }

    <?php if (isset($error)) { ?>
        fcom.displayErrorMessage(<?php echo $error; ?>);
    <?php } ?>
</script>