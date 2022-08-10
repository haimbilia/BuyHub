<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

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
            <div class="card-body">
                <div id="listing">
                    <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?> </div>
            </div>
        </div>
    </div>
</div>

<script>
    var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE', $siteLangId); ?>';
    var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS', $siteLangId); ?>';
</script>