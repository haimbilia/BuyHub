<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$userIdFld = $frm->getField('user_id');
$userId = $userIdFld->value;

$frm->setFormTagAttribute('class', 'form form--normal');
$frm->developerTags['fld_default_col'] = 2;

$frm->setFormTagAttribute('class', 'form form-otp');
$frm->setFormTagAttribute('name', 'frmGuestLoginOtp');
$frm->setFormTagAttribute('id', 'frmGuestLoginOtp');
$frm->setFormTagAttribute('onsubmit', 'return validateOtp(this);');

$btnFld = $frm->getField('btn_submit');
$btnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
?>

<div class="login-wrapper otpForm-js">
    <div class="card-sign">
        <div class="card-sign_head">
            <h2 class="formTitle-js"><?php echo Labels::getLabel('LBL_VERIFY_YOUR_PHONE_NUMBER', $siteLangId); ?></h2>
            <p><?php echo Labels::getLabel('LBL_ENTER_THE_OTP_YOU_RECEIVED_ON_YOUR_PHONE_NUMBER', $siteLangId); ?></p>
        </div>
        <div class="card-sign_body">
            <?php echo $frm->getFormTag(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="otp-row">
                            <?php for ($i = 0; $i < User::OTP_LENGTH; $i++) { ?>
                                <div class="otp-col otpCol-js">
                                    <?php
                                    $fld = $frm->getField('upv_otp[' . $i . ']');
                                    $fld->setFieldTagAttribute('class', 'otpVal-js');
                                    echo $frm->getFieldHtml('upv_otp[' . $i . ']'); ?>
                                    <?php if ($i < (User::OTP_LENGTH - 1)) { ?>
                                        <span class="dash">-</span>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col d-none">
                        <p class="otp-seconds countdownFld--js">
                            <?php
                            $msg = Labels::getLabel('LBL_PLEASE_WAIT_{SECONDS}_SECONDS_TO_RESEND', $siteLangId);
                            $replace = [
                                '{SECONDS}' => '<span class="intervaltime intervalTimer-js">' . User::OTP_INTERVAL . '</span>',
                            ];
                            echo CommonHelper::replaceStringData($msg, $replace);
                            ?>
                        </p>
                    </div>
                    <div class="col-auto d-none">
                        <a class="link resendOtp-js disabled" href="javascript:void(0);" onClick="resendOtp(<?php echo $userId; ?>, <?php echo applicationConstants::YES; ?>)"><?php echo Labels::getLabel('LBL_RESEND_OTP?', $siteLangId); ?></a>
                    </div>
                </div>
                <?php echo $frm->getFieldHtml('user_id'); ?>
                <div class="row">
                    <div class="col">
                        <?php echo $frm->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
            </form>
            <?php echo $frm->getExternalJs(); ?>
        </div>
    </div>
</div>