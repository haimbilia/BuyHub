<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$showSignUpLink = isset($showSignUpLink) ? $showSignUpLink : true;
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';

$signinpopup = $signinpopup ?? 0;
$formClass = 0 < $signinpopup ? 'loginpopup--js' : '';

$loginFrm->setFormTagAttribute('class', 'form form-login form-otp ' . $formClass);
$loginFrm->setFormTagAttribute('id', 'formLoginPage');
$loginFrm->setValidatorJsObjectName('loginFormObj');

$loginFrm->setFormTagAttribute('action', UrlHelper::generateUrl('GuestUser', 'login', [], CONF_WEBROOT_FRONTEND));
$loginFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, loginFormObj); return(false);');

$loginFrm->developerTags['fld_default_col'] = 12;
$loginFrm->developerTags['colClassPrefix'] = 'col-md-';

$fldSubmit = $loginFrm->getField('btn_submit');
$fldSubmit->addFieldTagAttribute('class', 'btn btn-secondary btn-block');

$signInWithPhone = $signInWithPhone ?? 0;
?>
<div class="card-sign">
    <?php /*<div class="card-sign_head">
        <h2 class="title">
            <?php echo Labels::getLabel('LBL_SIGN_IN_TO_YOUR_YOKART_ACCOUNT', $siteLangId); ?>
        </h2>
    </div> <?php */ ?>
    <div class="card-sign_body">
        <?php
        if (!empty($socialLoginApis) && 0 < count($socialLoginApis)) { ?>
            <ul class="buttons-list">
                <?php foreach ($socialLoginApis as $plugin) { ?>
                    <li class="buttons-list-item">
                        <a class="buttons-list-link" href="<?php echo UrlHelper::generateUrl($plugin['plugin_code']); ?>">
                            <span class="buttons-list-icon btn-<?php echo $plugin['plugin_code']; ?>"> <img class="svg" width="20" height="20" alt="" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/social-icons/<?php echo $plugin['plugin_code']; ?>.svg">
                            </span>
                            <?php echo $plugin['plugin_name']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <div class="or">
                <span>
                    <?php echo Labels::getLabel('LBL_SIGN_IN_WITH_YOUR_YOKART_ACCOUNT', $siteLangId); ?>
                </span>
            </div>
        <?php }
        if (0 < $signInWithPhone) {
            include('login-with-phone.php');
        } else {
            include('login-with-email.php');
        }

        echo $loginFrm->getExternalJS();
        ?>
    </div>
    <div class="card-sign_foot">
        <h6><?php echo Labels::getLabel('DON’T_HAVE_AN_ACCOUNT?', $siteLangId); ?></h6>
        <div class="more-links">
            <?php
            if (1 > $signInWithPhone) {
                echo $loginFrm->getFieldHtml('forgot');
            } ?>
            <?php if (0 < $signinpopup) { ?>
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