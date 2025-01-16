<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$btn = $sellerFrm->getField('btn_submit');
$btn->setFieldTagAttribute('class', "btn btn-brand btn-wide");
$btn->developerTags['noCaptionTag'] = true;

$bgImageUrl = '';
$pageContent = '';
if (!empty($slogan)) {
    $haveBgImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE, $slogan['epage_id'], 0, $siteLangId);
    $bgImageUrl = ($haveBgImage) ? "background:url(" . UrlHelper::generateFileUrl('Image', 'cblockBackgroundImage', array($slogan['epage_id'], $siteLangId, ImageDimension::VIEW_DEFAULT, AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE)) . ");" : "background:url(" . CONF_WEBROOT_URL . "images/seller-bg.png);";
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
                <div class="seller-register-form">
                    <h2><?php echo Labels::getLabel('L_Register_Today', $siteLangId); ?></h2>
                    <?php $sellerFrm->developerTags['colClassPrefix'] = 'col-lg-12';
                    $sellerFrm->developerTags['fld_default_col'] = 12;
                    echo $sellerFrm->getFormHtml(); ?>

                    <div class="cms">
                        <?php echo isset($formText['epage_content']) ? FatUtility::decodeHtmlEntities($formText['epage_content']) : ''; ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php if (!empty($block1)) { ?>
        <section class="section" data-section="section">
            <div class="container"><?php echo FatUtility::decodeHtmlEntities($block1['epage_content']); ?></div>
        </section>
    <?php }
    if (!empty($block2)) { ?>
        <section class="section bg-gray" data-section="section">
            <div class="container"> <?php echo FatUtility::decodeHtmlEntities($block2['epage_content']); ?> </div>
        </section>
    <?php }
    if (!empty($block3)) { ?>
        <section class="section" data-section="section">
            <div class="container"> <?php echo FatUtility::decodeHtmlEntities($block3['epage_content']); ?> </div>
        </section>
    <?php } ?>
    <?php if ($faqCount > 0) { ?>
        <div class="divider"></div>
        <section class="section" data-section="section">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-8">
                        <header class="section-head section-head-center">
                            <div class="section-heading">
                                <h2><?php echo Labels::getLabel('LBL_Frequently_Asked_Questions', $siteLangId); ?></h2>
                            </div>
                        </header>
                        <div class="section-body">
                            <div class="faqsearch">
                                <form name="frmSearchFaqs" method="post" onsubmit="searchFaqsListing(this); return(false);"
                                    class="form" action="javascript:void(0);">
                                    <input placeholder="<?php echo Labels::getLabel('FRM_SEARCH', $siteLangId); ?>"
                                        class="faq-input no-focus" id="faqQuestionJs" type="search" name="question" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section pt-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 faqSectionJs position-relative">
                        <?php if ($faqCount > 0) { ?>
                            <div class="faq-filters mb-4" id="categoryPanel"></div>
                        <?php } ?>
                        <ul class="faqlist" id="listing"></ul>
                    </div>
                </div>
            </div>
        </section>
        <div class="divider"></div>
    <?php } ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="align-center">
                <header class="section-head section-head-center">
                    <div class="section-heading">
                        <h2><?php echo Labels::getLabel('LBL_Still_need_help?', $siteLangId) ?> </h2>
                    </div>
                </header>
                <a href="<?php echo UrlHelper::generateUrl('custom', 'contact-us'); ?>"
                    class="btn btn-secondary"><?php echo Labels::getLabel('LBL_Contact_Customer_Care', $siteLangId) ?>
                </a>
            </div>
        </div>
    </section>
</div>
<script>
    var faqsSearchStringLength = '<?php echo Faq::FAQS_SEARCH_STRING_LENGTH; ?>';
</script>
<!-- End Document
================================================== -->