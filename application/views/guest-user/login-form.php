<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
    <section class="enter-page sign-in">
        <div class="container-info">
            <div class="info-item" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signup.png);">
                <div class="info-item__inner">
                    <!-- <div class="icon-wrapper">
                        <i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signup" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signup"></use>
                            </svg></i><?php //echo Labels::getLabel('LBL_Sign_up', $siteLangId); ?>
                    </div> -->
                    <h2><?php echo Labels::getLabel('LBL_Dont_have_an_account_yet?', $siteLangId); ?></h2>
                    <a href="javaScript:void(0)" class="btn btn-outline-white loginRegBtn--js"><?php echo Labels::getLabel('LBL_Register_Now', $siteLangId); ?></a>
                </div>
            </div>
            <div class="info-item" style="background-image: url(<?php echo CONF_WEBROOT_URL; ?>images/bg-signin.png);">
                <div class="info-item__inner">
                    <!-- <div class="icon-wrapper">
                        <i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signin" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#icn-signin"></use>
                            </svg>
                        </i>
                        <?php //echo Labels::getLabel('LBL_Sign_up', $siteLangId); ?>
                    </div> -->
                    <h2><?php echo Labels::getLabel('LBL_Do_You_Have_An_Account?', $siteLangId); ?></h2>
                    <a href="javaScript:void(0)" class="btn btn-outline-white loginRegBtn--js"><?php echo Labels::getLabel('LBL_Sign_In_Now', $siteLangId); ?></a>
                </div>
            </div>
        </div>
        <div class="container-form <?php echo ($isRegisterForm == 1) ? 'sign-up' : ''; ?>">
            <div id="sign-in" class="form-item sign-in">
                <div class="form-side-inner">
                    <?php
                     $logoUrl = UrlHelper::generateUrl();
                    $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                    $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                    $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    ?>
                    <a class="form-item_logo" href="<?php echo $logoUrl; ?>">
                        <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> src="<?php echo $siteLogo; ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
                    </a>

                    <?php
                    $loginData['smsPluginStatus'] = $smsPluginStatus;
                    $this->includeTemplate('guest-user/loginPageTemplate.php', $loginData, false);
                    ?>
                </div>
            </div>
            <div id="sign-up" class="form-item sign-up <?php echo ($isRegisterForm == 1) ? 'is-opened' : ''; ?>">
                <?php $smsPluginStatus = $smsPluginStatus; ?>
                <?php require_once CONF_VIEW_DIR_PATH . 'guest-user/register-form-detail.php'; ?>
            </div>
        </div>
    </section>
</div>