<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); 
$firstKey = key($payouts); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_PAYOUT_DETAIL', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-tabs">
                    <div class="card-head">
                        <nav class="nav nav-tabs">
                            <?php foreach ($payouts as $type => $name) { 
                                $active = ($type == $firstKey ? 'active' : ''); ?>
                                <a class="nav-link <?php echo $active; ?>" id="tab-<?php echo $type; ?>" href="javascript:void(0);" onClick="pluginForm('<?php echo $type; ?>')">
                                    <?php echo $name; ?>
                                </a>
                            <?php } ?>
                        </nav>
                    </div>
                    <div class="card-body">
                        <div id="payoutsSection">
                            <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        pluginForm('<?php echo $firstKey; ?>');
    });
</script>