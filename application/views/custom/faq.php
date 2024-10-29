<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <section class="section bg-faqs"
        style="background-image:url(<?php echo CONF_WEBROOT_URL; ?>images/bg/bg-faqs-4.jpg);">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <header class="section-head section-head-center mb-2">
                        <div class="section-heading">
                            <h1><?php echo Labels::getLabel('LBL_Frequently_Asked_Questions', $siteLangId); ?></h1>
                        </div>
                    </header>
                    <div class="section-body">
                        <form name="frmSearchFaqs" method="post" onsubmit="searchFaqsListing(this); return(false);"
                            class="form form-faqs">
                            <input placeholder="<?php echo Labels::getLabel('FRM_SEARCH', $siteLangId); ?>"
                                class="form-faqs-input no-focus" id="faqQuestionJs" type="search" name="question" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 faqSectionJs position-relative ">
                    <?php if ($recordCount > 0) { ?>
                        <div class="faq-filters mb-4" id="categoryPanel"></div>
                        <ul class="faq-list" id="listing"></ul>
                    <?php } else {
                        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false);
                    } ?>
                </div>
            </div>
        </div>
    </section>
    <script>
        var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
        var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
        var faqsSearchStringLength = '<?php echo Faq::FAQS_SEARCH_STRING_LENGTH; ?>';
    </script>
</div>