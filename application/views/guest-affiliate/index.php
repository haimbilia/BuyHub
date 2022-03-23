<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
    <?php $haveBgImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE, $bannerSlogan['epage_id'], 0, $siteLangId);
    $bgImageUrl = ($haveBgImage) ? "background-image:url(" . UrlHelper::generateFileUrl('Image', 'cblockBackgroundImage', array($bannerSlogan['epage_id'], $siteLangId, 'DEFAULT', AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE)) . ")" : "background-image:url(" . CONF_WEBROOT_URL . "images/seller-bg.png);"; ?>
    <div class="hero-banner" style="<?php echo $bgImageUrl; ?>">
        <div class="container">
            <div class="hero-banner-inner">
                <div class="seller-slogan">
                    <div class="seller-slogan-txt">
                        <?php echo FatUtility::decodeHtmlEntities(nl2br($bannerSlogan['epage_content'])); ?>
                    </div>
                </div>
                <div class="seller-register-form">
                    <h2><?php echo Labels::getLabel('LBL_Affiliate_Registration', $siteLangId); ?></h2>
                    <div id="register-form-div"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("document").ready(function() {
        callAffilitiateRegisterStep(<?php echo $affiliate_register_step_number; ?>);
    });
</script>