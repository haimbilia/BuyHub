<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_PROMOTION_NAME', $siteLangId);

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
    'promotion_name' => [
        'width' => '10%'
    ],
    'user_name' => [
        'width' => '15%'
    ],
    'shop_name' => [
        'width' => '20%'
    ],
    'promotion_type' => [
        'width' => '5%'
    ],
    'blocation_promotion_cost' => [
        'width' => '5%'
    ],
    'promotion_budget' => [
        'width' => '10%'
    ],
    'impressions' => [
        'width' => '5%'
    ],
    'clicks' => [
        'width' => '5%'
    ],
    'promotion_approved' => [
        'width' => '5%'
    ],
    'action' => [
        'width' => '10%'
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
                        'cardHeadTitle' => Labels::getLabel('LBL_PROMOTIONS', $siteLangId),
                        'deleteButton' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'promotions/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'controller' => $controller, /* Used in case of performing bulk action. */
                                'formAction' => 'deleteSelected'
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

    var PROMOTION_TYPE_BANNER = <?php echo Promotion::TYPE_BANNER; ?>;
    var PROMOTION_TYPE_SHOP = <?php echo Promotion::TYPE_SHOP; ?>;
    var PROMOTION_TYPE_PRODUCT = <?php echo Promotion::TYPE_PRODUCT; ?>;
    var PROMOTION_TYPE_SLIDES = <?php echo Promotion::TYPE_SLIDES; ?>;
</script>