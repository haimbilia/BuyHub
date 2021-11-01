<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [];

$controller = str_replace('Controller', '', FatApp::getController());
?>
<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once(CONF_THEME_PATH . 'products-report/search-form.php'); ?>
                <div class="card">
                    <?php $data = [
                        'siteLangId' => $siteLangId,
                        'canEdit' => true,
                        'columnButtons' => true,
                        'fields' => $fields,
                        'defaultColumns' => $defaultColumns,
                        'formColumns' => $formColumns,
                        'otherButtons' => [[
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'class' => 'btn btn-icon btn-link',
                                'onclick' => 'exportRecords()',
                                'title' => Labels::getLabel('LBL_Export', $siteLangId)
                            ],
                            'label' => '<svg class="svg" width="18" height="18">
                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#export">
                            </use>
                        </svg>' . Labels::getLabel('LBL_Export', $siteLangId)
                        ]],
                        'cardHeadTitle' => Labels::getLabel('LBL_Sales_Report', $siteLangId)
                    ];
                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'products-report/search.php');

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