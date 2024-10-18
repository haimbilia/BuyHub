<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$bgImageUrl = '';
$pageContent = '';
if (!empty($slogan)) {
    $haveBgImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE, $slogan['epage_id'], 0, $siteLangId);
    $bgImageUrl = ($haveBgImage) ? "background:url(" . UrlHelper::generateFileUrl('Image', 'cblockBackgroundImage', array($slogan['epage_id'], $siteLangId, ImageDimension::VIEW_DEFAULT, AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE)) . ");" : "background:url(" . CONF_WEBROOT_URL . "images/seller-bg.png);";
    $imageRepeatType = $slogan['epage_extra_info'] && array_key_exists(Extrapage::TYPE_BKGROUND_IMAGE_REPEAT, $slogan['epage_extra_info']) ? $slogan['epage_extra_info'][Extrapage::TYPE_BKGROUND_IMAGE_REPEAT] : 'repeat';
    $bgImageUrl .= "background-repeat: $imageRepeatType;";
    $imageSizeType = $slogan['epage_extra_info'] && array_key_exists(Extrapage::TYPE_BKGROUND_IMAGE_SIZE, $slogan['epage_extra_info']) ? $slogan['epage_extra_info'][Extrapage::TYPE_BKGROUND_IMAGE_SIZE] : 'auto';
    $bgImageUrl .= "background-size: $imageSizeType;";

    if ((isset($slogan['epage_content']) && !empty($slogan['epage_content']))) {
        $pageContent = FatUtility::decodeHtmlEntities(nl2br($slogan['epage_content']));
    }
}
?>
<div id="body" class="body">
    <div class="hero-banner" style="<?php echo $bgImageUrl; ?>">
        <div class="container">
            <div class="hero-banner-inner">
                <div class="seller-slogan">
                    <div class="seller-slogan-txt">
                        <?php if (isset($slogan['epage_label'])) { ?>
                            <h3><?php echo $slogan['epage_label']; ?></h3>
                        <?php } ?>
                        <p><?php echo $pageContent; ?></p>
                    </div>
                </div>
                <div class="seller-register-form affiliate-register-form" id="regFrmBlock">
                    <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script type="text/javascript" src="js/seller-functions.js"></script>  -->