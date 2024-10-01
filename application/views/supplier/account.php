<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
    <?php
    $bgImageUrl = '';
    if ($slogan) {
        $bgImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE, $slogan['epage_id'], 0, $siteLangId);
        $bgImageUrl = ($bgImage && 0 < $bgImage['afile_id']) ? "background:url(" . UrlHelper::generateFileUrl('Image', 'cblockBackgroundImage', array($slogan['epage_id'], $siteLangId, ImageDimension::VIEW_DEFAULT, AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE)) . ")" : "background:url(" . CONF_WEBROOT_URL . "images/seller-bg.png);";
    }
    ?>
    <div class="hero-banner" style="background-repeat: no-repeat;<?php echo $bgImageUrl; ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="seller-register-form" id="regFrmBlock"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($postedData)) {
    echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmSellerAccount'));
}
