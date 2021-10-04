<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('LBL_SEARCH_ORDER_STATUS', $adminLangId);

/* No sorting functionality required if no record found. */
if (1 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'dragdrop' => [
        'width' => '5%'
    ],
    'select_all' => [
        'width' => '5%'
    ],
    'listSerial' => [
        'width' => '10%'
    ],
    'orderstatus_name' => [
        'width' => '40%'
    ],
    'orderstatus_is_active' => [
        'width' => '20%'
    ],
    'action' => [
        'width' => '20%'
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
                        'cardHeadTitle' => Labels::getLabel('LBL_ORDER_STATUS', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_STAUESES', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true,
                        'statusButtons' => true
                    ];
                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            $tableId = "orderStatuses";
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'order-status/search.php');

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

    $(document).ready(function() {
        $('#orderStatuses').tableDnD({
            onDrop: function(table, row) {
                fcom.displayProcessing();
                var order = $.tableDnD.serialize('id');
                fcom.ajax(fcom.makeUrl('OrderStatus', 'setOrderStatusesOrder'), order, function(res) {
                    fcom.removeLoader();
                    $.ykmsg.close();
                    var ans = $.parseJSON(res);
                    if (ans.status == 1) {
                        $.ykmsg.success(ans.msg);
                        return;
                    }
                    $.ykmsg.error(ans.msg);
                });
            },
            dragHandle: ".dragHandle",
        });
    });
</script>