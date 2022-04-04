<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body enter-page loginFormJs">
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
            $loginData['signInWithPhone'] = $signInWithPhone;
            $this->includeTemplate('guest-user/loginPageTemplate.php', $loginData, false);
            ?>
        </div>
    </div>
</div>