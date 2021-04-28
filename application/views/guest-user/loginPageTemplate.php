<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true;
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';

$loginFrm->setFormTagAttribute('class', 'form form-otp');
$loginFrm->setValidatorJsObjectName('loginValObj');
$loginFrm->setFormTagAttribute('action', UrlHelper::generateUrl('GuestUser', 'login'));
$loginFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, loginValObj); return(false);');
$loginFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$loginFrm->developerTags['fld_default_col'] = 12;
$fldforgot = $loginFrm->getField('forgot');
$fldforgot->value = '<a href="' . UrlHelper::generateUrl('GuestUser', 'forgotPasswordForm') . '"
    class="link">' . Labels::getLabel('LBL_Forgot_Password?', $siteLangId) . '</a>';
$fldSubmit = $loginFrm->getField('btn_submit');
$fldSubmit->addFieldTagAttribute('class', 'btn btn-brand btn-wide btn-block');

if (isset($smsPluginStatus) && true === $smsPluginStatus) {
    $pwdFld = $loginFrm->getField('password');
    $loginWithOtp = $loginFrm->getField('loginWithOtp');
    $loginWithOtp->addFieldTagAttribute('class', 'loginWithOtp--js');
}

echo $loginFrm->getFormTag(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="field-set">
                <div class="field-wraper">
                    <div class="field_cover"><?php echo $loginFrm->getFieldHtml('username'); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pwdField--js">
        <div class="col-md-12">
            <div class="field-set">
                <div class="field-wraper">
                    <div class="field_cover"><?php echo $loginFrm->getFieldHtml('password'); ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($smsPluginStatus) && true === $smsPluginStatus) { ?>
        <div class="otp-row otpFieldBlock--js d-none">
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
    <?php } ?>
    <div class="row align-items-center"> <!-- Row 1st -->
        <div class="col-md-6 col-6 remember--js">
            <div class="mb-2">
                <div class="field-wraper">
                    <div class="field_cover ">
                        <label class="checkbox">
                            <?php
                            $fld = $loginFrm->getFieldHTML('remember_me');
                            $fld = str_replace("<label >", "", $fld);
                            $fld = str_replace("</label>", "", $fld);
                            echo $fld;
                            ?> <i class="input-helper"></i>
                        </label> <?php if ($loginFrm->getField('remember_me')); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php if (isset($smsPluginStatus) && true === $smsPluginStatus) { ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <a class="link" href="javaScript:void(0)" data-form="frmLogin" onClick="signInWithPhone(this, true)">
                            <?php echo Labels::getLabel('LBL_USE_PHONE_NUMBER_INSTEAD_?', $siteLangId); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>  <!-- End Row 1st -->
        <div class="row">
            <div class="col-md-12 d-none getOtpBtnBlock--js">
                <div class="field-set">
                    <div class="field-wraper">
                        <div class="field_cover">
                            <a href="javaScript:void(0)" onclick="getLoginOtp(this);" class="btn btn-brand btn-wide btn-block resendOtp-js">
                                <?php echo Labels::getLabel('LBL_GET_OTP', $siteLangId); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-none">
                <small class="countdownFld--js">
                    <?php
                    $msg = Labels::getLabel('LBL_PLEASE_WAIT_{SECONDS}_SECONDS_TO_RESEND', $siteLangId);
                    $replace = [
                        '{SECONDS}' => '<b><span class="intervalTimer-js">' . User::OTP_INTERVAL . '</span></b>',
                    ];
                    echo CommonHelper::replaceStringData($msg, $replace);
                    ?>
                </small>
            </div>
        </div>
    <?php } else { ?>
        </div>   <!-- End Row 1st -->
    <?php } ?>
    <div class="row submitBtn--js">
        <div class="col-md-12">
            <div class="field-set">
                <div class="field-wraper">
                    <div class="field_cover"><?php echo $loginFrm->getFieldHtml('btn_submit'); ?></div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
echo $loginFrm->getExternalJS();

if (!empty($socialLoginApis) && 0 < count($socialLoginApis)) { ?>
    <div class="or">
        <span>
            <?php echo Labels::getLabel('LBL_OR_CONTINUE_WITH', $siteLangId); ?>
        </span>
    </div>
    <div class="buttons-list">
        <ul>
            <?php foreach ($socialLoginApis as $plugin) { ?>
                <li>
                    <a href="<?php echo UrlHelper::generateUrl($plugin['plugin_code']); ?>" class="btn btn--social btn--<?php echo $plugin['plugin_code']; ?>">
                        <i class="icn">
                            <img alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/social-icons/<?php echo $plugin['plugin_code']; ?>.svg">
                        </i>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>