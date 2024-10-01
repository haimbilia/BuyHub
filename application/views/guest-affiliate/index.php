<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$bgImageUrl = '';
$pageContent = '';
if (!empty($bannerSlogan)) {
    $haveBgImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE, $bannerSlogan['epage_id'], 0, $siteLangId);
    $bgImageUrl = ($haveBgImage) ? "background:url(" . UrlHelper::generateFileUrl('Image', 'cblockBackgroundImage', array($bannerSlogan['epage_id'], $siteLangId, 'DEFAULT', AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE)) . ");" : "background:url(" . CONF_WEBROOT_URL . "images/seller-bg.png);";
    $imageRepeatType = $bannerSlogan['epage_extra_info'] && array_key_exists(Extrapage::TYPE_BKGROUND_IMAGE_REPEAT, $bannerSlogan['epage_extra_info']) ? $bannerSlogan['epage_extra_info'][Extrapage::TYPE_BKGROUND_IMAGE_REPEAT] : 'repeat';
    $bgImageUrl .= "background-repeat: $imageRepeatType;";
    $imageSizeType = $bannerSlogan['epage_extra_info'] && array_key_exists(Extrapage::TYPE_BKGROUND_IMAGE_SIZE, $bannerSlogan['epage_extra_info']) ? $bannerSlogan['epage_extra_info'][Extrapage::TYPE_BKGROUND_IMAGE_SIZE] : 'auto';
    $bgImageUrl .= "background-size: $imageSizeType;";

    if ((isset($bannerSlogan['epage_content']) && !empty($bannerSlogan['epage_content']))) {
        $pageContent = FatUtility::decodeHtmlEntities(nl2br($bannerSlogan['epage_content']));
    }
}

?>

<div id="body" class="body">
    <div class="hero-banner" style="<?php echo $bgImageUrl; ?>">
        <div class="container">
            <div class="hero-banner-inner">
                <div class="seller-slogan">
                    <div class="seller-slogan-txt">
                        <?php if (isset($bannerSlogan['epage_label'])) { ?>
                            <h3><?php echo $bannerSlogan['epage_label']; ?></h3>
                        <?php } ?>
                        <p><?php echo $pageContent; ?></p>
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