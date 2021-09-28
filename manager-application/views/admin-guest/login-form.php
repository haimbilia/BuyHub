<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'login(this, loginValidator); return(false);');
$frm->setFormTagAttribute('id', 'adminLoginForm');
$frm->setFormTagAttribute('class', 'form');
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

$submitBtn = $frm->getField('btn_submit');
$submitBtn->addFieldTagAttribute('class', 'btn btn-brand btn-lg btn-block');
?>
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
                            <h2><?php echo Labels::getlabel('LBL_SIGN_IN', $adminLangId); ?></h2>
                        </div>
                        <?php echo $frm->getFormTag(); ?>
                        <div class="form-group">
                            <label class="label"><?php echo $userNameFld->getCaption() ?></label>
                            <?php echo $userNameFld->getHTML('username'); ?>
                        </div>
                        <div class="form-group">
                            <label class="label"><?php echo $passwordFld->getCaption() ?></label>
                            <?php echo $passwordFld->getHTML('password'); ?>
                        </div>
                        <div class="row py-3">
                            <div class="col-12">
                                <label class="switch switch--sm remember-me">
                                    <?php
                                    $remeberfld = $frm->getFieldHTML('rememberme');
                                    $remeberfld = str_replace("<label>", "", $remeberfld);
                                    $remeberfld = str_replace("</label>", "", $remeberfld);
                                    echo $remeberfld;
                                    ?>
                                    <span></span><?php echo Labels::getlabel('LBL_Remember_me', $adminLangId); ?> 
                                </label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $frm->getFieldHTML('btn_submit'); ?>
                            </div>
                        </div>
                        <?php echo $frm->getExternalJS(); ?>
                        </form>
                    </div>
                    <div class="card-foot">
                        <ul class="other-links">
                            <li><a href="<?php echo UrlHelper::generateUrl('adminGuest', 'forgotPasswordForm'); ?>" class="link"><?php echo Labels::getLabel('LBL_Forgot_Password?', $adminLangId); ?></a></li>

                        </ul>
                    </div>
                </div>
                <p class="version"><?php $this->includeTemplate('_partial/footer/copyright-text.php', $this->variables, false); ?></p>
            </div>
        </div>
    </div>