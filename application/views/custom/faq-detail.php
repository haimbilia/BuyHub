<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <?php $this->includeTemplate('_partial/page-head-section.php', ['headLabel' => Labels::getLabel('LBL_FAQ'), 'includeBreadcrumb' => true]); ?>
    <section class="section bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div id="listing"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h3><?php echo Labels::getLabel('LBL_FEW_MORE_QUESTIONS', $siteLangId) ?></h3>
                    <div id="categoryPanel"></div>
                </div>
            </div>
            <div class="gap"></div>
            <div class="divider"></div>
            <div class="text-center  pt-5">
                <h3><?php echo Labels::getLabel('LBL_Still_need_help', $siteLangId) ?> ?</h3>
                <a href="<?php echo UrlHelper::generateUrl('custom', 'contact-us'); ?>" class="btn btn-secondary"><?php echo Labels::getLabel('LBL_Contact_Customer_Care', $siteLangId) ?>
                </a>
            </div>

        </div>
    </section>
</div>
<script>
    var faqcatId = '<?php echo $faqCatId ?>';
    var faqId = '<?php echo $faqId ?>';
</script>