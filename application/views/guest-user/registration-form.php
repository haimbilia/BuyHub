<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body enter-page">
    <div id="sign-up" class="form-sign">
        <?php $smsPluginStatus = $smsPluginStatus; ?>
        <?php require_once CONF_VIEW_DIR_PATH . 'guest-user/register-form-detail.php'; ?>
    </div>
</div>
<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>