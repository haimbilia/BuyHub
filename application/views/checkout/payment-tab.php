<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$pmethodName = $paymentMethod["plugin_name"];
$pmethodCode = $paymentMethod["plugin_code"];

$isCodOrPayAtStore = (isset($pmethodCode) && in_array(strtolower($pmethodCode), ['cashondelivery', 'payatstore']));

$frm->setFormTagAttribute('class', 'form');

$otpVerification = (isset($paymentMethod["otp_verification"]) && 0 < $paymentMethod["otp_verification"]);
$btn = $frm->getField('btn_submit');
$btn->developerTags['noCaptionTag'] = true;

if ($isCodOrPayAtStore && true === $otpVerification) {
    $btn->value = Labels::getLabel('LBL_GET_OTP', $siteLangId);
} else {
    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
    $frm->developerTags['fld_default_col'] = 12;
    $frm->setFormTagAttribute('onsubmit', 'confirmOrder(this); return(false);');
}

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand btn-wide");

if ($isCodOrPayAtStore && true === $otpVerification) { ?>
    <div class="otp-block otpBlock-js">
        <div class="otp-block__head">
            <h6><?php echo Labels::getLabel('LBL_PLEASE_ENTER_THE_VERIFICATION_CODE_TO_CONFIRM_YOUR_ORDER', $siteLangId); ?></h6>
            <p class="d-none" id="codCodeSentOnInfo">
                <?php
                $msg = Labels::getLabel('LBL_VERIFICATION_CODE_SENT_TO_{EMAIL}', $siteLangId);
                if (true == $canSendSms) {
                    $phone = $userData['user_phone'];
                    $msg = Labels::getLabel('LBL_VERIFICATION_CODE_SENT_TO_{PHONE}_AND_{EMAIL}', $siteLangId);
                    $maskedPhoneNumber = LibHelper::phoneNumberMasking(ValidateElement::formatDialCode($userData['user_phone_dcode']) . $phone);
                    $msg =  CommonHelper::replaceStringData($msg, ['{PHONE}' => '<br><strong>' . $maskedPhoneNumber . '</strong>']);
                }
                $maskedEmail = LibHelper::emailAddressMasking($userData['credential_email']);
                echo CommonHelper::replaceStringData($msg, ['{EMAIL}' => '<strong>' . $maskedEmail . '</strong>']);
                ?>
            </p>
        </div>
        <div class="otp-block__body">
            <p class="text-muted text-center">
                <?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_OTP_WILL_EXPIRES_AFTER_{AGE}_MINUTES', $siteLangId), ['{AGE}' => User::OTP_AGE]); ?>
            </p>
            <div class="otp-enter">
                <div class="otp-inputs">
                    <?php
                    $frm->setFormTagAttribute('class', 'form otpForm-js');
                    $frm->setFormTagAttribute('onsubmit', 'sendOtp(this); return(false);');

                    for ($i = 0; $i < User::OTP_LENGTH; $i++) {
                        $fld = $frm->getField('upv_otp[' . $i . ']');
                        $fld->setFieldTagAttribute('class', 'field-otp otpVal-js');
                        $fld->developerTags['noCaptionTag'] = true;
                        $fld->setWrapperAttribute('class', 'otpCol-js');
                    }
                    $submitFld->developerTags['noCaptionTag'] = true;
                    $submitFld->developerTags['col'] = 12;
                    echo $frm->getFormHtml();
                    ?>
                </div>
            </div>
        </div>
        <div class="otp-block__footer text-center">
            <span>
                <p>
                    <?php
                    $msg = Labels::getLabel('LBL_RESEND_OTP_AFTER_{TIMER}_SECONDS', $siteLangId);
                    $htm = '<span class="txt-success font-weight-bold intervalTimer-js">
                                ' . User::OTP_INTERVAL . '
                            </span>';
                    echo CommonHelper::replaceStringData($msg, ['{TIMER}' => $htm]);
                    ?>
                </p>
            </span>
            <p class="d-none resendOtpDiv-js">
                <?php echo Labels::getLabel("LBL_DIDN'T_GET_OTP.", $siteLangId); ?>
                <a href="javaScript:void(0)" class="txt-success font-weight-bold resendOtp-js" onClick="resendOtp()">
                    <?php echo Labels::getLabel('LBL_RESEND_?', $siteLangId); ?>
                </a>
            </p>
        </div>
    </div>
    <div class="otp-block successOtp-js d-none">
        <div class="otp-success">
            <img class="img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/otp-complete.svg" alt="">
            <h5><?php echo Labels::getLabel('LBL_VERIFIED_SUCCESSFULLY', $siteLangId); ?></h5>
        </div>
    </div>
<?php } else { ?>
    <div class="text-center paymentFormSection-js <?php echo (false == $isCodOrPayAtStore) ? 'd-none' : ''; ?>">
        <?php if ($isCodOrPayAtStore) { ?>
            <h6><?php echo Labels::getLabel('LBL_PLEASE_CONFIRM_YOUR_ORDER', $siteLangId); ?></h6>
        <?php } ?>
        <?php if (!isset($error)) {
            echo $frm->getFormHtml();
        }
        ?>
    </div>
<?php } ?>
<script type="text/javascript">
    var paymentMethodBlockJs = '<?php echo $pmethodCode; ?>-js';
    $(document).ready(function() {
        <?php if (isset($error)) { ?>
            fcom.displayErrorMessage(<?php echo $error; ?>);
        <?php } ?>
        <?php if ($isCodOrPayAtStore) { ?>
            $(".intervalTimer-js").parent().parent().hide();
            $(".otpForm-js").removeAttr('action');
            $(".otpVal-js").attr('disabled', 'disabled');
        <?php } ?>
    });

    function confirmOrder(frm) {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action')
        var getExternalLibraryUrl = $(frm).data('external');
        fcom.displayProcessing();
        fcom.updateWithAjax(fcom.makeUrl('Checkout', 'confirmOrder'), data, function(res) {
            if ('undefined' != typeof getExternalLibraryUrl) {
                fcom.displayProcessing();
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
                    fcom.removeLoader();
                });
            } else {
                loadChargeForm(action);
            }
            fcom.removeLoader();
            fcom.displaySuccessMessage(res.msg);
        });
    }

    function loadChargeForm(action) {
        fcom.displayProcessing();
        fcom.ajax(action, '', function(t) {
            fcom.closeProcessing();
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

    function sendOtp(frm) {
        fcom.displayProcessing();
        resendOtp(frm);
    }

    function showElements() {
        $(".resendOtpDiv-js").removeClass("d-none");
    }
</script>