<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('LBL_SEARCH_URL', $adminLangId);

/* No sorting functionality required if no record found. */
if (1 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'select_all' => [
        'width' => '5%'
    ],
    'listSerial' => [
        'width' => '15%'
    ],
    'urlrewrite_original' => [
        'width' => '30%'
    ],
    'language_code' => [
        'width' => '10%'
    ],
    'urlrewrite_custom' => [
        'width' => '30%'
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
                        'adminLangId' => $adminLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_URL_LIST', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_URL', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true,
                        'deleteButton' => true,
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'url-rewriting/search.php');

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
    getHelpCenterContent(controllerName);
</script>