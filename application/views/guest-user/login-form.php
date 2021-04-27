<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
    <section class="enter-page sign-in">
        <div class="container-info">
            <div class="info-item" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signup.png);">
                <div class="info-item__inner">
                    <div class="icon-wrapper">
                        <i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signup" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signup"></use>
                            </svg></i><?php echo Labels::getLabel('LBL_Sign_up', $siteLangId); ?>
                    </div>
                    <h2><?php echo Labels::getLabel('LBL_Dont_have_an_account_yet?', $siteLangId); ?></h2>
                    <a href="javaScript:void(0)" class="btn btn-outline-white js--register-btn"><?php echo Labels::getLabel('LBL_Register_Now', $siteLangId); ?></a>
                </div>
            </div>
            <div class="info-item" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signin.png);">
                <div class="info-item__inner">
                    <div class="icon-wrapper">
                        <i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signin" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signin"></use>
                            </svg>
                        </i>
                        <?php echo Labels::getLabel('LBL_Sign_up', $siteLangId); ?>
                    </div>
                    <h2><?php echo Labels::getLabel('LBL_Do_You_Have_An_Account?', $siteLangId); ?></h2>
                    <a href="javaScript:void(0)" class="btn btn-outline-white  js--login-btn"><?php echo Labels::getLabel('LBL_Sign_In_Now', $siteLangId); ?></a>
                </div>
            </div>
        </div>
        <div class="container-form <?php echo ($isRegisterForm == 1) ? 'sign-up' : ''; ?>">
            <div id="sign-in" class="form-item sign-in">
                <div class="form-side-inner">
                    <a class="form-item_logo" href=""> <img src="http://localhost/yokart/image/site-logo/1?t=1608690809" alt=""> </a>

                    <div class="card-sign">
                        <div class="card-sign_head">
                            <h2 class="title">
                                <?php echo Labels::getLabel('LBL_Sign_In', $siteLangId); ?>
                            </h2>

                        </div>
                        <div class="card-sign_body">

                            <?php
                            $loginData['smsPluginStatus'] = $smsPluginStatus;
                            $this->includeTemplate('guest-user/loginPageTemplate.php', $loginData, false);
                            ?>

                        </div>
                        <div class="card-sign_foot">
                            <p class="more-links">
                                <?php echo $loginData['loginFrm']->getFieldHtml('forgot'); ?>
                                |
                                <a class="js--register-btn" href="javaScript:void(0)">
                                    <?php echo Labels::getLabel('LBL_REGISTER_NOW', $siteLangId); ?>
                                </a>
                            </p>
                        </div>
                    </div>



                </div>
            </div>
            <div id="sign-up" class="form-item sign-up <?php echo ($isRegisterForm == 1) ? 'is-opened' : ''; ?>">
                <?php $smsPluginStatus = $smsPluginStatus; ?>
                <?php require_once CONF_VIEW_DIR_PATH . 'guest-user/register-form-detail.php'; ?>
            </div>
        </div>
    </section>
</div>
<script>
    $('.info-item a.btn').click(function() {
        $('.container-form').toggleClass("sign-up");
        $('#sign-up').toggleClass("is-opened");
    });
</script>