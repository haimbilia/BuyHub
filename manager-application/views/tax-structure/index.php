<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$keywordPlaceholder = Labels::getLabel('LBL_SEARCH_TAX_STRUCTURE', $siteLangId);

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'listSerial' => [
        'width' => '5%'
    ],
    'taxstr_identifier' => [
        'width' => '45%'
    ],
    'taxstr_is_combined' => [
        'width' => '35%'
    ],
    'action' => [
        'width' => '15%'
    ],
];

$controller = str_replace('Controller', '', FatApp::getController());
?>
<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'siteLangId' => $siteLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_TAX_STRUCTURE', $siteLangId),
                        'newRecordBtn' => true,
                        'editButton' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'tax-structure/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
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

<script>
    var controllerName = '<?php echo $controller; ?>';
    getHelpCenterContent(controllerName);
</script>