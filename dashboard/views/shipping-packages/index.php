<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Shipping_Packages', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-table" id="listing">
                        <div > <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>