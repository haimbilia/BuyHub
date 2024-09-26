<?php
$actionItemsData = $actionItemsData + [
    'canEdit' => $canEdit ?? false,
    'keywordPlaceholder' => $keywordPlaceholder ?? Labels::getLabel('FRM_SEARCH', $siteLangId)
];
?>
<main class="main mainJs" <?php echo CommonHelper::getLayoutDirection() != $formLayout ? 'dir="' . $formLayout . '"' : ''; ?>>
    <div class="container">
        <?php
        $this->includeTemplate('_partial/header/header-breadcrumb.php', $actionItemsData, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . $actionItemsData['searchFrmTemplate']); ?>
                    <div class="card-table">
                        <div class="table-responsive table-scrollable js-scrollable listingTableJs" data-auto-column-width="<?php echo $autoTableColumWidth; ?>">
                            <?php
                            $tableId = "listingTableJs";
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . $actionItemsData['searchListingPage']);
                            $actionItemsData = $actionItemsData + ['tbl' => $tbl /* Received from listing-column-head.php file. */];
                            $this->includeTemplate('_partial/listing/print-listing-table.php', $actionItemsData, false); ?>
                        </div>
                    </div>
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var canEdit = <?php echo $canEdit ? 1 : 0; ?>;    
</script>