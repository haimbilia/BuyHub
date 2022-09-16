<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => $plugins[$type],
        'siteLangId' => $siteLangId
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-table">
                        <div id="Listing"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var type = <?php echo $type; ?>;
    searchPlugin(type);
</script>