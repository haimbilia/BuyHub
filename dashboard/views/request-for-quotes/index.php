<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$keywordPlaceholder = Labels::getLabel('LBL_SEARCH_BY_TITLE_OR_RFQ_NUMBER', $siteLangId);

$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_REQUEST_FOR_QUOTES', $siteLangId),
        'siteLangId' => $siteLangId,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card">
            <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
            <div id="listing">
                <?php require_once(CONF_THEME_PATH . '_partial/listing/tbl-skeleton.php'); ?>
            </div>
        </div>
    </div>
</div>