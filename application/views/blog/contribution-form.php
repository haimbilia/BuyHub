<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl('Blog', 'setupContribution'));
$frm->developerTags['colClassPrefix'] = 'col-lg-';
$frm->developerTags['fld_default_col'] = 6;
$fileFld = $frm->getField('file');
$fileFld->htmlBeforeField = '<div class="filefield"><span class="filename"></span>';
$preferredDimensionsStr = '</div><span class="form-text text-muted">' . Labels::getLabel('MSG_Allowed_Extensions', $siteLangId) . '</span>';
$fileFld->htmlAfterField = $preferredDimensionsStr;
$fileFld->developerTags['col'] = 12;

$btnSubmitFld = $frm->getField('btn_submit');
$btnSubmitFld->developerTags['noCaptionTag'] = true;
$btnSubmitFld->setFieldTagAttribute('class', 'btn btn-brand btn-wide');
/* $isUserLogged = UserAuthentication::isUserLogged();
if ($isUserLogged) {
    $nameFld = $frm->getField(BlogContribution::DB_TBL_PREFIX . 'author_first_name');
    $nameFld->setFieldTagAttribute('readonly', 'readonly');
} */
?>
<div id="body" class="body">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-head section-head-center">
                        <div class="section-heading">
                            <h1>
                                <?php echo Labels::getLabel('LBL_BLOG_CONTRIBUTION', $siteLangId); ?>
                            </h1>
                            <p><?php echo Labels::getLabel('LBL_BLOG_CONTRIBUTION_FORM_DESCRIPTION', $siteLangId); ?></p>
                        </div>
                    </div>
                    <div class="bg-gray rounded p-5">
                        <?php echo $frm->getFormHtml(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
$siteKey = FatApp::getConfig('CONF_RECAPTCHA_SITEKEY', FatUtility::VAR_STRING, '');
$secretKey = FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY', FatUtility::VAR_STRING, '');
if (!empty($siteKey) && !empty($secretKey)) { ?>
    <script src='https://www.google.com/recaptcha/api.js?onload=googleCaptcha&render=<?php echo $siteKey; ?>'></script>
<?php } ?>