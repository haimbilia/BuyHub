<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $siteLangId);

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'select_all' => [
        'width' => '5%'
    ],
    'listSerial' => [
        'width' => '5%'
    ],
    'product_name' => [
        'width' => '25%'
    ],
    'selprod_price' => [
        'width' => '10%'
    ],
    'credential_username' => [
        'width' => '15%'
    ],
    'splprice_start_date' => [
        'width' => '10%'
    ],
    'splprice_end_date' => [
        'width' => '10%'
    ],
    'splprice_price' => [
        'width' => '15%'
    ],
    'action' => [
        'width' => '5%'
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
                        'cardHeadTitle' => Labels::getLabel('LBL_SPECIAL_PRICE_LIST', $siteLangId),
                        'newRecordBtn' => true,
                        'deleteButton' => true,
                    ];
                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            $tableId = 'splPriceListJs';
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'special-price/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'controller' => $controller /* Used in case of performing bulk action. */
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