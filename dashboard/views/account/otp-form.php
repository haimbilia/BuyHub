<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$userIdFld = $frm->getField('user_id');
$userId = $userIdFld->value;

$frm->setFormTagAttribute('class', 'form form-otp otpForm-js');
$frm->developerTags['fld_default_col'] = 2;
$frm->setFormTagAttribute('name', 'frmGuestLoginOtp');
$frm->setFormTagAttribute('id', 'frmGuestLoginOtp');
$frm->setFormTagAttribute('onsubmit', 'return validateOtp(this);');

$btnFld = $frm->getField('btn_submit');
$btnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');

echo $frm->getFormTag(); ?>
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
        <div class="col-md-12">
            <p class="note">
                <?php echo Labels::getLabel('LBL_ENTER_THE_OTP_YOU_RECEIVED_ON_YOUR_PHONE_NUMBER', $siteLangId); ?>
            </p>
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
    <div class="row">
        <div class="col">
            <?php echo $frm->getFieldHtml('btn_submit'); ?>
        </div>
    </div>
    <?php echo $frm->getFieldHtml('user_id'); ?>
</form>
<?php echo $frm->getExternalJs(); ?>