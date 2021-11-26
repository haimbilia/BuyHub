<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'login(this, loginValidator); return(false);');
$frm->setFormTagAttribute('id', 'adminLoginForm');
$frm->setFormTagAttribute('class', 'form form-login');
$frm->setRequiredStarPosition('none');
$frm->setRequiredStarWith('none');
$frm->setJsErrorDisplay(FORM::FORM_ERROR_TYPE_AFTER_FIELD);
$frm->setValidatorJsObjectName('loginValidator');

$userNameFld = $frm->getField('username');
$userNameFld->addFieldTagAttribute('title', $userNameFld->getCaption());
$userNameFld->addFieldTagAttribute('autocomplete', 'off');

$passwordFld = $frm->getField('password');
$passwordFld->addFieldTagAttribute('title', $passwordFld->getCaption());
$passwordFld->addFieldTagAttribute('autocomplete', 'off');

$fld = $frm->getField('rememberme');
$fld->addFieldTagAttribute('class', 'rememberFldJs');
?>
<div id="particles-js"></div>
<div class="login-page login-1">
    <div class="container">
        <div class="login-block">
            <div class="logo">
                <a href="<?php echo UrlHelper::generateUrl(); ?>">
                    <?php
                    $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, $siteLangId, false);
                    $aspectRatioArr = AttachedFile::getRatioTypeArray($siteLangId);
                    $uploadedTime = AttachedFile::setTimeParam($fileData['afile_updated_at']);
                    ?>
                    <img <?php if ($fileData['afile_aspect_ratio'] > 0) { ?> data-ratio="<?php echo $aspectRatioArr[$fileData['afile_aspect_ratio']]; ?>" <?php } ?> title="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId); ?>" src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'siteLogo', array($siteLangId), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo FatApp::getConfig("CONF_WEBSITE_NAME_" . $siteLangId); ?>">
                </a>
            </div>
            <div class="card">
                <div class="card-head">
                    <div class="title">
                        <h2><?php echo Labels::getlabel('LBL_SIGN_IN', $siteLangId); ?></h2>
                        <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo $frm->getFormTag(); ?>
                    <div class="form-group">
                        <label class="label"><?php echo $userNameFld->getCaption() ?></label>
                        <?php echo $userNameFld->getHTML('username'); ?>
                    </div>
                    <div class="form-group">
                        <label class="label"><?php echo $passwordFld->getCaption() ?></label>
                        <div class="input-group">
                        <?php echo $passwordFld->getHTML('password'); ?>
                        <div class="input-group-append"><span class="input-group-text">Show</span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="switch switch-sm remember-me">
                            <?php echo $frm->getFieldHTML('rememberme'); ?>
                            <span class="input-helper"></span><?php echo Labels::getlabel('LBL_Remember_me', $siteLangId); ?>
                        </label>

                    </div>
                    <div class="form-group">
                        <?php echo $frm->getFieldHTML('btn_submit'); ?>
                    </div>

                    <?php echo $frm->getExternalJS(); ?>
                    </form>
                </div>
                <div class="card-foot">
                    <ul class="other-links">
                        <li><a href="<?php echo UrlHelper::generateUrl('adminGuest', 'forgotPasswordForm'); ?>" class="link"><?php echo Labels::getLabel('LBL_Forgot_Password?', $siteLangId); ?></a></li>
                    </ul>
                </div>
            </div>
            <p class="version"><?php $this->includeTemplate('_partial/footer/copyright-text.php', $this->variables, false); ?></p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if ($(".rememberFldJs").parent().is("label")) {
                $(".rememberFldJs").unwrap();
            }
        });
    </script>