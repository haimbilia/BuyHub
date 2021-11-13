<?php
$searchFrmTemplate = $searchFrmTemplate ?? '_partial/listing/listing-search-form.php';
$searchListing = $searchListing ?? FatUtility::camel2dashed(LibHelper::getControllerName()) . '/search.php';
?>
<main class="main mainJs">
    <div class="container">
        <?php $data = [
            'siteLangId' => $siteLangId,
            'newRecordBtn' => $newRecordBtn ?? false,
            'canEdit' => $canEdit ?? false
        ];
        $this->includeTemplate('_partial/header/header-breadcrumb.php', $data, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . $searchFrmTemplate); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            $tableId = "orderStatuses";
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . $searchListing);

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'performBulkAction' => $performBulkAction ?? false, /* Used in case of performing bulk action. */
                                'formAction' => $formAction ?? 'toggleBulkStatuses',
                                'formFields' => $formFields ?? ''
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