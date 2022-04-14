<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Meta_Tags', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card card-full-height">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <span id="listing">
                        <div class="container m-2"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-full-height">
                    <div id="dvForm"></div>
                    <div class="alert-aligned" id="dvAlert">
                        <div class="card-body">
                            <div class="cards-message">
                                <div class="cards-message-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="cards-message-text"><?php echo Labels::getLabel('LBL_Select_a_product_to_add_/_edit_meta_tags_data', $siteLangId); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>