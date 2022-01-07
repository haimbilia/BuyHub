<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body enter-page">
    <div class="banner-side" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signin.png);">
        <div class="banner-side-cta">
            <h2>
                <?php echo Labels::getLabel('LBL_Do_You_Have_An_Account?', $siteLangId); ?></h2>
            <a href="<?php echo UrlHelper::generateUrl('GuestUser', 'loginForm'); ?>" class="btn btn-outline-white"><?php echo Labels::getLabel('LBL_Sign_In_Now', $siteLangId); ?>
            </a>
        </div>
    </div>
    <div id="sign-up" class="form-sign">
        <?php $smsPluginStatus = $smsPluginStatus; ?>
        <?php require_once CONF_VIEW_DIR_PATH . 'guest-user/register-form-detail.php'; ?>
    </div>

</div>