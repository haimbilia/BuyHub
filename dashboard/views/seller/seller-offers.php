<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php
        $data = [
            'headingLabel' => Labels::getLabel('LBL_My_Offers', $siteLangId),
            'siteLangId' => $siteLangId,
        ];

        $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
        <div class="content-body">
            <div class="card">
                <div class="card-body mt-4">
                    <div id="listing" class="row"> <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>