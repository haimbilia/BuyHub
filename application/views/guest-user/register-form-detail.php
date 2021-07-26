<div class="form-side-inner">
    <?php
     $logoUrl = UrlHelper::generateUrl();
    $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
    $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
    $siteLogo = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    ?>
    <a class="form-item_logo" href="<?php echo $logoUrl; ?>">
        <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?>
            data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?>
            src="<?php echo $siteLogo; ?>"
            alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>"
            title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_' . $siteLangId, FatUtility::VAR_STRING, '') ?>">
    </a>
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
            <p class="more-links">
                <?php if (isset($registerdata['signUpWithPhone']) && true === $smsPluginStatus) {
                if (0 == $registerdata['signUpWithPhone']) { ?>
                <a class="otp-link" href="javaScript:void(0)"
                    onClick="signUpWithPhone()"><?php echo Labels::getLabel('LBL_USE_PHONE_NUMBER_INSTEAD_?', $siteLangId); ?></a>
                <?php } else { ?>
                <a class="otp-link" href="javaScript:void(0)"
                    onClick="signUpWithEmail()"><?php echo Labels::getLabel('LBL_USE_EMAIL_INSTEAD_?', $siteLangId); ?></a>
                <?php } ?>
                <?php } ?>

                <a class="loginRegBtn--js" href="javaScript:void(0)">
                    <?php echo Labels::getLabel('LBL_SIGN_IN_NOW', $siteLangId); ?>
                </a>
            </p>
        </div>
    </div>
</div>