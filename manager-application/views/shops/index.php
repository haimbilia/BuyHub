<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_NAME', $siteLangId);

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
    'user_name' => [
        'width' => '10%'
    ],
    'shop_name' => [
        'width' => '16%'
    ],
    'numOfProducts' => [
        'width' => '10%'
    ],
    'numOfReports' => [
        'width' => '8%'
    ],
    'numOfReviews' => [
        'width' => '8%'
    ],
    'shop_featured' => [
        'width' => '8%'
    ],
    'shop_created_on' => [
        'width' => '10%'
    ],
    'shop_supplier_display_status' => [
        'width' => '10%'
    ],
    'shop_active' => [
        'width' => '5%'
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
                <?php require_once(CONF_THEME_PATH . 'shops/search-form.php'); ?>
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'siteLangId' => $siteLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_SHOPS', $siteLangId),
                        'newRecordBtn' => false,
                        'statusButtons' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'shops/search.php');

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
</script>