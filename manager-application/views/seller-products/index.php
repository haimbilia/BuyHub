<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php

$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_NAME', $siteLangId);
$actionItemsData = $actionItemsData + [
    'canEdit' => $canEdit ?? false
];
?>

<main class="main mainJs">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', $actionItemsData, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . 'seller-products/search-form.php'); ?>
                    <?php $this->includeTemplate('_partial/listing/listing-head.php', $actionItemsData, false); ?>
                    <div class="card-table">
                        <div class="table-responsive table-scrollable js-scrollable listingTableJs">
                            <?php
                            $tableId = "listingTableJs";
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'seller-products/search.php');

                            $actionItemsData = $actionItemsData + [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'performBulkAction' => true /* Used in case of performing bulk action. */
                            ];
                            $this->includeTemplate('_partial/listing/print-listing-table.php', $actionItemsData, false); ?>
                        </div>
                    </div>
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>