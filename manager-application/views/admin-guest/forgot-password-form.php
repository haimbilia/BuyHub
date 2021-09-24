<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form-login');
$frm->setRequiredStarPosition('none');
$frm->setValidatorJsObjectName('forgotValidator');
$frm->setFormTagAttribute('onsubmit', 'forgotPassword(this, forgotValidator); return false;');

$fld = $frm->getField('admin_email');
$fld->addFieldTagAttribute('title', $fld->getCaption());
$fld->addFieldTagAttribute('autocomplete', 'off');
$fld->setRequiredStarWith('none');

$fld = $frm->getField('btn_forgot');
$fld->addFieldTagAttribute('class', 'btn btn-brand btn-lg btn-block not-allowed');
$captchaFld = $frm->getField('g-recaptcha-response');
HtmlHelper::formatFormFields($frm);

if (null != $captchaFld) {
    ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<?php } ?>
<div id="particles-js"></div>
<div class="login-page login-1">
    <div class="container">
        <div class="row align-item-center justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-head">
                        <div class="logo">
                            <a href="<?php echo UrlHelper::generateUrl(); ?>">
                                <?php
                                $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADMIN_LOGO, 0, 0, $adminLangId, false);
                                $aspectRatioArr = AttachedFile::getRatioTypeArray($adminLangId);
                                $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                                ?>
                                <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> title="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $adminLangId); ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'siteAdminLogo', array($adminLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $adminLangId); ?>">
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="title">
                            <h2><?php echo Labels::getLabel('LBL_Forgot_Your_Password?', CommonHelper::getLangId()); ?></h2>
                            <p><?php echo Labels::getLabel('LBL_Enter_The_E-mail_Address_Associated_With_Your_Account', $adminLangId) ?></p>
                        </div>                        
                        <?php echo $frm->getFormHtml(); ?>                       
                    </div>
                    <div class="card-foot">
                        <ul class="other-links">
                            <li>
                                <a href="<?php echo UrlHelper::generateUrl('adminGuest', 'loginForm'); ?>" class="link"><?php echo Labels::getLabel('LBL_Back_to_Login', $adminLangId); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="version"><?php $this->includeTemplate('_partial/footer/copyright-text.php', $this->variables, false); ?></p>
            </div>
        </div>
    </div>
    <?php
    if (null != $captchaFld) {
        $siteKey = FatApp::getConfig('CONF_RECAPTCHA_SITEKEY', FatUtility::VAR_STRING, '');
        ?>
        <script>
            langLbl.captchaSiteKey = "<?php echo FatApp::getConfig('CONF_RECAPTCHA_SITEKEY', FatUtility::VAR_STRING, ''); ?>";
        </script>
        <script src='https://www.google.com/recaptcha/api.js?onload=googleCaptcha&render=<?php echo $siteKey; ?>'></script>
    <?php } ?>