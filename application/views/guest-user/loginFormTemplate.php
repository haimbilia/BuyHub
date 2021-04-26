<?php
    $showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true;
    $onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';
    $formClass = isset($formClass) ? $formClass : '';

    $loginFrm->setFormTagAttribute('class', 'form form-otp ' . $formClass);
    $loginFrm->setFormTagAttribute('name', 'formLoginPage');
    $loginFrm->setFormTagAttribute('id', 'formLoginPage');
    $loginFrm->setValidatorJsObjectName('loginFormObj');

    $loginFrm->setFormTagAttribute('onsubmit', 'return ' . $onSubmitFunctionName . '(this, loginFormObj);');
    $loginFrm->developerTags['fld_default_col'] = 12;
    $loginFrm->developerTags['colClassPrefix'] = 'col-md-';
    $remembermeField = $loginFrm->getField('remember_me');
    $remembermeField->setWrapperAttribute("class", "rememberme-text");
    $remembermeField->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
    $remembermeField->developerTags['col'] = 6;
    $remembermeField->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
    $fldforgot = $loginFrm->getField('forgot');
    $fldforgot->value = '<a href="' . UrlHelper::generateUrl('GuestUser', 'forgotPasswordForm') . '"
    class="link">' . Labels::getLabel('LBL_Forgot_Password?', $siteLangId) . '</a>';
    $fldforgot->developerTags['col'] = 6;
    $fldSubmit = $loginFrm->getField('btn_submit');

    if (isset($smsPluginStatus) && true === $smsPluginStatus) {
        $pwdFld = $loginFrm->getField('password');
        $loginWithOtp = $loginFrm->getField('loginWithOtp');
        $loginWithOtp->addFieldTagAttribute('class', 'loginWithOtp--js');
    }
?>
<div id="sign-in">
    <div class="login-wrapper">
        <div class="form-side">
            <div class="section-head  section--head--center">
                <div class="section__heading otp-heading">
                    <h2>
                        <?php echo Labels::getLabel('LBL_Login', $siteLangId);?>
                    </h2>
                    <?php if (isset($smsPluginStatus) && true === $smsPluginStatus) { ?>
                        <a class="otp-link" href="javaScript:void(0)" data-form="formLoginPage" onClick="signInWithPhone(this, true)">
                            <?php echo Labels::getLabel('LBL_USE_PHONE_NUMBER_INSTEAD', $siteLangId); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <?php echo $loginFrm->getFormTag(); ?>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="field-set">
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $loginFrm->getFieldHtml('password'); ?>
                            </div>
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
            <div class="row align-items-center">
                <div class="col-md-6 col-6 remember--js">
                    <div class="field-set">
                        <div class="field-wraper">
                            <div class="field_cover">
                                <?php echo $loginFrm->getFieldHtml('remember_me'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6 col-6 forgetPwd--js">
                    <div class="field-set">
                        <div class="forgot"><?php //echo $loginFrm->getFieldHtml('forgot'); ?></div>
                    </div>
                </div> -->
                
                <?php if (isset($smsPluginStatus) && true === $smsPluginStatus) { ?>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 withPwdLbl--js d-none">
                                <small class="countdownFld--js d-none">
                                    <?php
                                        $msg = Labels::getLabel('LBL_PLEASE_WAIT_{SECONDS}_SECONDS_TO_RESEND', $siteLangId);
                                        $replace = [
                                            '{SECONDS}' => '<b><span class="intervalTimer-js">' . User::OTP_INTERVAL . '</span></b>',
                                        ];
                                        echo CommonHelper::replaceStringData($msg, $replace);
                                    ?>
                                </small>
                            </div>
                            <div class="col-md-6 field-set">
                                <a class="link" href="javaScript:void(0)" data-form="frmLogin" onClick="signInWithPhone(this, true)">
                                    <?php echo Labels::getLabel('LBL_USE_PHONE_NUMBER_INSTEAD', $siteLangId); ?>
                                </a>
                            </div>
                            <div class="row d-none getOtpBtnBlock--js">
                                <div class="col-md-12">
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
                            </div>
                        </div>
                <?php } ?>
            </div>
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
            <?php echo $loginFrm->getExternalJS();?>

            <?php if ($showSignUpLink) { ?>
                <div class="row justify-content-center">
                    <div class="col-auto text-center">
                        <a class="link" href="<?php echo UrlHelper::generateUrl('GuestUser', 'loginForm', array(applicationConstants::YES)); ?>">
                            <?php echo sprintf(Labels::getLabel('LBL_Not_Registered_Yet?', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId));?>
                        </a>
                    </div>
                    <?php if (isset($includeGuestLogin) && 'true' == $includeGuestLogin) {?>
                    <div class="col-auto text-center">
                        <a class="link" href="javascript:void(0)" onclick="guestUserFrm()"><?php echo sprintf(Labels::getLabel('LBL_Guest_Checkout?', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId));?></a>
                    </div>
                    <?php }?>
                </div>
            <?php } ?>
            <?php if (!empty($socialLoginApis) && 0 < count($socialLoginApis)) { ?>
                <div class="other-option">
                    <div class="section-head section--head--center">
                        <div class="section__heading">
                            <h6 class="mb-0"><?php echo Labels::getLabel('LBL_Or_Login_With', $siteLangId); ?></h6>
                        </div>
                    </div>
                    <div class="buttons-list">
                        <ul>
                            <?php foreach ($socialLoginApis as $plugin) { ?>
                                <li>
                                    <a href="<?php echo UrlHelper::generateUrl($plugin['plugin_code']); ?>" class="btn btn--social btn--<?php echo $plugin['plugin_code'];?>">
                                        <i class="icn">
                                            <img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/social-icons/<?php echo $plugin['plugin_code']; ?>.svg">
                                        </i>
                                    </a>
                                </li>
                            <?php } ?>  
                        </ul>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>