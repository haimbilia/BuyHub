<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <section class="section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="section-head section-head-center mb-0">
                        <div class="section-heading">
                            <h1><?php echo Labels::getLabel('LBL_Frequently_Asked_Questions', $siteLangId); ?></h1>
                        </div>
                    </div>
                    <div class="faqsearch">
                        <form name="frmSearchFaqs" class="form" action="javascript:void(0);">
                            <input placeholder="Search" class="faq-input no-focus" data-field-caption="Enter your question" type="search" name="question" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="divider"></div>
    <section class="section bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php if ($recordCount > 0) { ?>
                        <div class="faq-filters mb-4" id="categoryPanel"></div>
                    <?php } ?>
                    <ul class="faq-list" id="listing"></ul>
                </div>
            </div>
        </div>
    </section>
    <script>
        var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
        var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
    </script>    
</div>