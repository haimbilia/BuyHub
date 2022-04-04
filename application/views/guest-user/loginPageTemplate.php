<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true;
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';

$popup = isset($popup) ? $popup : false;
$formClass = true === $popup ? 'loginpopup--js' : '';

$loginFrm->setFormTagAttribute('class', 'form form-login form-otp ' . $formClass);
$loginFrm->setFormTagAttribute('id', 'formLoginPage');
$loginFrm->setValidatorJsObjectName('loginFormObj');

$loginFrm->setFormTagAttribute('action', UrlHelper::generateUrl('GuestUser', 'login'));
$loginFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, loginFormObj); return(false);');

$loginFrm->developerTags['fld_default_col'] = 12;
$loginFrm->developerTags['colClassPrefix'] = 'col-md-';

$fldSubmit = $loginFrm->getField('btn_submit');
$fldSubmit->addFieldTagAttribute('class', 'btn btn-secondary btn-block');

$signInWithPhone = $signInWithPhone ?? false;
?>
<div id="<?php echo true === $popup ? 'sign-in' : ''; ?>" class="<?php echo true === $popup ? 'p-5' : ''; ?>">
    <div class="card-sign">
        <div class="card-sign_head">
            <h2 class="title">
                <?php echo Labels::getLabel('LBL_Sign_in_to_your_Yokart_account', $siteLangId); ?>
            </h2>
        </div>
        <div class="card-sign_body">
            <?php if (true === $signInWithPhone) {
                include('login-with-phone.php');
            } else {
                include('login-with-email.php');
            }

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
                                <a href="<?php echo UrlHelper::generateUrl($plugin['plugin_code']); ?>" class="btn btn-social btn-<?php echo $plugin['plugin_code']; ?>">
                                    <img class="svg" width="20" height="20" alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/social-icons/<?php echo $plugin['plugin_code']; ?>.svg">

                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div class="card-sign_foot">
            <h6><?php echo Labels::getLabel('DON’T_HAVE_AN_ACCOUNT?', $siteLangId); ?></h6>
            <div class="more-links">
                <?php
                if (false === $signInWithPhone) {
                    echo $loginFrm->getFieldHtml('forgot');
                } ?>
                <?php if (true === $popup) { ?>
                    <a class="link-underline" href="<?php echo UrlHelper::generateUrl('GuestUser', 'RegistrationForm'); ?>">
                        <?php echo sprintf(Labels::getLabel('LBL_REGISTER_NOW', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId)); ?>
                    </a>
                <?php } else { ?>
                    <a class="link-underline loginRegBtn--js" href="<?php echo UrlHelper::generateUrl('GuestUser', 'RegistrationForm'); ?>">
                        <?php echo Labels::getLabel('LBL_REGISTER_NOW', $siteLangId); ?>
                    </a>
                <?php } ?>
                <?php if (isset($includeGuestLogin) && 'true' == $includeGuestLogin) { ?>
                    <a class="link-underline" href="javascript:void(0)" onclick="guestUserFrm()">
                        <?php echo sprintf(Labels::getLabel('LBL_GUEST_CHECKOUT?', $siteLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId)); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>