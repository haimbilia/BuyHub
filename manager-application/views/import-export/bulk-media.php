<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
// $keywordPlaceholder = Labels::getLabel('LBL_SEARCH_EMPTY_CART_ITEMS', $siteLangId);

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'listSerial' => [
        'width' => '5%'
    ],
    'user' => [
        'width' => '20%'
    ],
    'afile_physical_path' => [
        'width' => '55%'
    ],
    'files'    => [
        'width' => '10%'
    ],
    'action' => [
        'width' => '10%'
    ],
];

$controller = str_replace('Controller', '', FatApp::getController());
?>
<div class="card-body">
    <?php echo HtmlHelper::getDropZoneHtml(); ?>

    <?php echo $frmSearch->getFormHtml(); ?>
    <div class="table-responsive listingTableJs">
        <?php
        require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
        require_once(CONF_THEME_PATH . 'import-export/search.php');

        $data = [
            'tbl' => $tbl, /* Received from listing-column-head.php file. */
        ];
        $this->includeTemplate('_partial/listing/print-listing-table.php', $data, false); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-foot.php'); ?>
</div>

<script>
    var controllerName = '<?php echo $controller; ?>';
    getHelpCenterContent(controllerName);
</script>