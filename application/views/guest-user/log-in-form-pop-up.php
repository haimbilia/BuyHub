<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true;
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';

$loginFrm->setFormTagAttribute('class', 'form form-login form-otp loginpopup--js');
$loginFrm->setFormTagAttribute('id', 'formLoginPage');
$loginFrm->setValidatorJsObjectName('loginFormObj');

$loginFrm->setFormTagAttribute('action', UrlHelper::generateUrl('GuestUser', 'login'));
$loginFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, loginFormObj); return(false);');

$loginFrm->developerTags['fld_default_col'] = 12;
$loginFrm->developerTags['colClassPrefix'] = 'col-md-';

$remembermeField = $loginFrm->getField('remember_me');
$remembermeField->setWrapperAttribute("class", "rememberme-text");
$remembermeField->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
$remembermeField->developerTags['col'] = 6;
$remembermeField->developerTags['cbHtmlAfterCheckbox'] = '';

$fldforgot = $loginFrm->getField('forgot');
$fldforgot->value = '<a href="' . UrlHelper::generateUrl('GuestUser', 'forgotPasswordForm') . '"
    class="">' . Labels::getLabel('LBL_Forgot_Password?', $siteLangId) . '</a>';
$fldforgot->developerTags['col'] = 6;

$pwdFld = $loginFrm->getField('password');
$pwdFld->addFieldTagAttribute('id', 'password');

if (isset($smsPluginStatus) && true === $smsPluginStatus) {
    $loginWithOtp = $loginFrm->getField('loginWithOtp');
    $loginWithOtp->addFieldTagAttribute('class', 'loginWithOtp--js');
}
?>

<div class="modal-header border-0">

</div>
<div class="modal-body">
    <div class="login-popup loginpopup--js">
        <h2 class="title"><?php echo Labels::getLabel('LBL_Sign_In', $siteLangId); ?></h2>
        <?php
        $fldSubmit = $loginFrm->getField('btn_submit');
        $fldSubmit->addFieldTagAttribute('class', 'btn btn-secondary  btn-block');

        echo $loginFrm->getFormTag(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $loginFrm->getFieldHtml('username'); ?>
                </div>
            </div>
        </div>
        <div class="row pwdField--js">
            <div class="col-md-12">
                <div class="form-group form-group-relative">
                    <?php echo $loginFrm->getFieldHtml('password'); ?>
                    <span class="input-group-text field-password" id="showPass"></span>
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
        <div class="row align-items-center">
            <?php if ($loginFrm->getField('remember_me')) { ?>
                <div class="col remember--js">
                    <div class="form-group">
                        <label class="checkbox">
                            <?php
                            $fld = $loginFrm->getFieldHTML('remember_me');
                            $fld = str_replace("<label >", "", $fld);
                            $fld = str_replace("</label>", "", $fld);
                            echo $fld;
                            ?>
                        </label>
                    </div>
                </div>
            <?php } ?>
            <?php if (isset($smsPluginStatus) && true === $smsPluginStatus) { ?>
                <div class="col-auto">
                    <a class="link" href="javaScript:void(0)" data-form="frmLogin" onClick="signInWithPhone(this, true)">
                        <?php echo Labels::getLabel('LBL_USE_PHONE_NUMBER_INSTEAD_?', $siteLangId); ?>
                    </a>
                </div>

                <div class="col-auto d-none">
                    <a class="link resendOtp-js disabled" href="javascript:void(0);" onclick="getLoginOtp(this);"><?php echo Labels::getLabel('LBL_RESEND_OTP?', $siteLangId); ?></a>
                </div>
            <?php } ?>
        </div>
        <?php if (isset($smsPluginStatus) && true === $smsPluginStatus) { ?>
            <div class="row">
                <div class="col-md-12 d-none getOtpBtnBlock--js">
                    <div class="form-group">
                        <a href="javaScript:void(0)" onclick="getLoginOtp(this);" class="btn btn-brand btn-wide btn-block">
                            <?php echo Labels::getLabel('LBL_GET_OTP', $siteLangId); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
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
            </div>
        <?php } ?>
        <div class="row submitBtn--js">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $loginFrm->getFieldHtml('btn_submit'); ?>
                    <?php echo $loginFrm->getFieldHtml('fatpostsectkn'); ?>
                </div>
            </div>
        </div>
        </form>
        <?php echo $loginFrm->getExternalJS(); ?>

        <div class="row">
            <?php if (!empty($socialLoginApis) && 0 < count($socialLoginApis)) { ?>
                <div class="col-md-12">
                    <div class="or">
                        <span>
                            <?php echo Labels::getLabel('LBL_OR_CONTINUE_WITH', $siteLangId); ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="buttons-list">
                        <ul>
                            <?php foreach ($socialLoginApis as $plugin) { ?>
                                <li>
                                    <a href="<?php echo UrlHelper::generateUrl($plugin['plugin_code']); ?>" class="btn btn-social btn-<?php echo $plugin['plugin_code']; ?>">

                                        <img class="svg" width="20" height="20" alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/social-icons/<?php echo $plugin['plugin_code']; ?>.svg">

                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-12">
                <div class="more-links">
                    <?php echo $loginFrm->getFieldHtml('forgot'); ?>
                    <a class="link-underline" href="<?php echo UrlHelper::generateUrl('GuestUser', 'registrationForm'); ?>">
                        <?php echo sprintf(Labels::getLabel('LBL_REGISTER_NOW', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId)); ?>
                    </a>

                    <?php if (isset($includeGuestLogin) && 'true' == $includeGuestLogin) { ?>
                        <a class="link-underline" href="javascript:void(0)" onclick="guestUserFrm()">
                            <?php echo sprintf(Labels::getLabel('LBL_GUEST_CHECKOUT?', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId)); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>