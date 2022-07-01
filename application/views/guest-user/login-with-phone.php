<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$loginWithOtp = $loginFrm->getField('loginWithOtp');
$loginWithOtp->addFieldTagAttribute('class', 'loginWithOtp--js');

$fld = $loginFrm->getField('username');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_PHONE_NUMBER', $siteLangId));

echo $loginFrm->getFormTag(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $loginFrm->getFieldHtml('username'); ?>
        </div>
    </div>
</div>
<div class="otp-row otpFieldBlock--js" style="display: none;">
    <?php for ($i = 0; $i < User::OTP_LENGTH; $i++) { ?>
        <div class="otp-col otpCol-js">
            <?php
            $fld = $loginFrm->getField('upv_otp[' . $i . ']');
            $fld->setFieldTagAttribute('class', 'otpVal-js');
            echo $loginFrm->getFieldHtml('upv_otp[' . $i . ']'); ?>
            <?php if ($i < (User::OTP_LENGTH - 1)) { ?>
                <span class="dash">-</span>
            <?php } ?>
        </div>
    <?php } ?>
    <?php echo $loginFrm->getFieldHtml('loginWithOtp'); ?>
</div>
<div class="row m-2">
    <div class="col-auto" style="display: none;">
        <button type="button" class="link-underline resendOtp-js disabled" href="javascript:void(0);" onclick="getLoginOtp(this);"><?php echo Labels::getLabel('LBL_RESEND_OTP?', $siteLangId); ?></button>
    </div>
    <div class="col text-right" style="display: none;">
        <p class="form-text text-muted otp-seconds countdownFld--js">
            <?php
            $msg = Labels::getLabel('LBL_PLEASE_WAIT_{SECONDS}_SECONDS_TO_RESEND', $siteLangId);
            $replace = [
                '{SECONDS}' => '<span class="intervaltime intervalTimer-js">' . User::OTP_INTERVAL . '</span>',
            ];
            echo CommonHelper::replaceStringData($msg, $replace);
            ?>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12 submitBtn--js" style="display: none;">
        <div class="form-group">
            <?php echo $loginFrm->getFieldHtml('btn_submit'); ?>
            <?php echo $loginFrm->getFieldHtml('fatpostsectkn'); ?>
        </div>
    </div>
    <div class="col-md-12 getOtpBtnBlock--js">
        <div class="form-group">
            <button type="button" onclick="getLoginOtp(this);" class="btn btn-secondary btn-block">
                <?php echo Labels::getLabel('LBL_GET_OTP', $siteLangId); ?>
            </button>
        </div>
    </div>
</div>
</form>