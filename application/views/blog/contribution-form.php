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
?>
<div id="body" class="body">
    <?php $this->includeTemplate('_partial/page-head-section.php', ['headLabel' => Labels::getLabel('LBL_BLOG_CONTRIBUTION'), 'subHeadLabel' => Labels::getLabel('LBL_BLOG_CONTRIBUTION_FORM_DESCRIPTION')]); ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 bg-gray rounded p-5">
                    <?php echo $frm->getFormHtml(); ?>
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