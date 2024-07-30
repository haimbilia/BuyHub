<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
    <?php $this->includeTemplate('_partial/page-head-section.php', ['headLabel' => Labels::getLabel('LBL_TESTIMONIALS'), 'includeBreadcrumb' => true]); ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="cms">
                <div class="list__all" id='listing'></div>
                <div id="loadMoreBtnDiv"></div>
                <?php echo FatUtility::createHiddenFormFromData(array('page' => 1), array('name' => 'frmSearchTestimonialsPaging')); ?>
            </div>
        </div>
    </section>
</div>