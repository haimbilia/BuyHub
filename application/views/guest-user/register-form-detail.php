<div class="form-side-inner">
    <a class="form-item_logo" href=""> <img src="http://localhost/yokart/image/site-logo/1?t=1608690809" alt=""> </a>
    <div class="card-sign">
        <div class="card-sign_head">
            <h2 class="title">
                <?php echo Labels::getLabel('LBL_Sign_Up', $siteLangId); ?>
            </h2>
        </div>
        <div class="card-sign_body">
            <?php $this->includeTemplate('guest-user/registerationFormTemplate.php', $registerdata, false); ?>
        </div>
        <div class="card-sign_foot">
            <?php if (isset($registerdata['signUpWithPhone']) && true === $smsPluginStatus) {
                if (0 == $registerdata['signUpWithPhone']) { ?>
                    <a class="otp-link" href="javaScript:void(0)" onClick="signUpWithPhone()"><?php echo Labels::getLabel('LBL_USE_PHONE_NUMBER_INSTEAD', $siteLangId); ?></a>
                <?php } else { ?>
                    <a class="otp-link" href="javaScript:void(0)" onClick="signUpWithEmail()"><?php echo Labels::getLabel('LBL_USE_EMAIL_INSTEAD', $siteLangId); ?></a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

</div>