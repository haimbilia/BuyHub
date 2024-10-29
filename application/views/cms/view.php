<?php defined('SYSTEM_INIT') or die('Invalid Usage');
?>
<div id="body" class="body">
    <?php if ($cPage['cpage_layout'] == Contentpage::CONTENT_PAGE_LAYOUT1_TYPE) { ?>
        <div class="page-banner"
            style="background-repeat: no-repeat;background-position:<?php echo (CommonHelper::getLayoutDirection() == 'rtl' ? 'right' : 'left') ?>;background-image:url(<?php echo UrlHelper::generateFileUrl('image', 'cpageBackgroundImage', array($cPage['cpage_id'], $siteLangId, '', 0, false), CONF_WEBROOT_URL); ?>);">
            <div class="container">
                <div class="page-banner-txt">
                    <h1><?php echo $cPage['cpage_image_title']; ?></h1>
                    <p><?php echo (isset($cPage['cpage_image_content']) && !empty($cPage['cpage_image_content'])) ? nl2br($cPage['cpage_image_content']) : ''; ?>
                    </p>
                </div>
            </div>
        </div>
        <?php if ($blockData) { ?>
            <div class="about-us">
                <?php if (isset($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_1]['cpblocklang_text']) && !empty(trim($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_1]['cpblocklang_text']))) { ?>
                    <section class="section" data-section="section">
                        <div class="container">
                            <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_1]['cpblocklang_text']); ?>
                        </div>
                    </section>
                    <?php
                }
                if (isset($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_2]['cpblocklang_text']) && !empty(trim($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_2]['cpblocklang_text']))) {
                    ?>
                    <section class="section" data-section="section">
                        <div class="container">
                            <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_2]['cpblocklang_text']); ?>
                        </div>
                    </section>
                    <?php
                }
                if (isset($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_3]['cpblocklang_text']) && !empty(trim($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_3]['cpblocklang_text']))) {
                    ?>
                    <section class="section" data-section="section">
                        <div class="container">
                            <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_3]['cpblocklang_text']); ?>
                        </div>
                    </section>
                    <?php
                }
                if (isset($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_4]['cpblocklang_text']) && !empty(trim($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_4]['cpblocklang_text']))) {
                    ?>
                    <section class="section  bg-gray">
                        <div class="container">
                            <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_4]['cpblocklang_text']); ?>
                        </div>
                    </section>
                    <?php
                }
                if (isset($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_5]['cpblocklang_text']) && !empty(trim($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_5]['cpblocklang_text']))) {
                    ?>
                    <section class="section" data-section="section">
                        <div class="container">
                            <?php echo FatUtility::decodeHtmlEntities($blockData[Contentpage::CONTENT_PAGE_LAYOUT1_BLOCK_5]['cpblocklang_text']); ?>
                        </div>
                    </section>
                <?php } ?>
            </div>
            <?php
        }

        ?>
    <?php } else { ?>
        <div class="bg-brand-light py-4">
            <div class="container">
                <header class="section-head section-head-center mb-0">
                    <div class="section-heading">
                        <h2><?php echo $cPage['cpage_title']; ?></h2>
                        <?php if (!$isAppUser) { ?>
                            <div class="breadcrumb  breadcrumb-center">
                                <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </header>
            </div>
        </div>
        <section class="section bg-white">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="cms">
                            <?php echo FatUtility::decodeHtmlEntities($cPage['cpage_content']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
</div>