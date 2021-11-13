<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$statusButtons = true;
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_LANGUAGE_CODE_AND_NAME', $siteLangId); ?>

<main class="main mainJs">
    <div class="container">
        <?php $data = [
            'siteLangId' => $siteLangId,
            'newRecordBtn' => true,
            'canEdit' => $canEdit
        ];
        $this->includeTemplate('_partial/header/header-breadcrumb.php', $data, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'languages/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'performBulkAction' => true /* Used in case of performing bulk action. */
                            ];
                            $this->includeTemplate('_partial/listing/print-listing-table.php', $data, false); ?>
                        </div>
                    </div>
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>