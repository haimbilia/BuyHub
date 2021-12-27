<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
    <section class="enter-page">
        <div class="banner-side" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signup.png);">
            <div class="banner-side-cta">
                <h2>
                    <?php echo Labels::getLabel('LBL_Dont_have_an_account_yet?', $siteLangId); ?></h2>
                <a href="javaScript:void(0)" class="btn btn-outline-white">
                    <?php echo Labels::getLabel('LBL_Register_Now', $siteLangId); ?>
                </a>
            </div>

        </div>

        <div class="form-sign">
            <?php
            $logoUrl = UrlHelper::generateUrl();
            $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
            $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
            $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
            $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            ?>
            <a class="form-sign-logo" href="<?php echo $logoUrl; ?>">
                <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
            </a>
            <div class="form-sign-body">

                <?php
                $loginData['smsPluginStatus'] = $smsPluginStatus;
                $this->includeTemplate('guest-user/loginPageTemplate.php', $loginData, false);
                ?>
            </div>

        </div>
    </section>
    <section class="enter-page">
        <div class="banner-side" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signin.png);">
            <div class="banner-side-cta">
                <h2>
                    <?php echo Labels::getLabel('LBL_Do_You_Have_An_Account?', $siteLangId); ?></h2>
                <a href="javaScript:void(0)" class="btn btn-outline-white"><?php echo Labels::getLabel('LBL_Sign_In_Now', $siteLangId); ?>
                </a>
            </div>

        </div>
        <div id="sign-up" class="form-sign">
            <?php $smsPluginStatus = $smsPluginStatus; ?>
            <?php require_once CONF_VIEW_DIR_PATH . 'guest-user/register-form-detail.php'; ?>
        </div>

    </section>
</div>