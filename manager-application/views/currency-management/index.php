<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('LBL_SEARCH_CURRENCY', $adminLangId);

/* No sorting functionality required if no record found. */
if (1 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'dragdrop' => [
        'width' => '5%',
    ],
    'select_all' => [
        'width' => '5%',
    ],
    'listSerial' => [
        'width' => '10%',
    ],
    'currency_code' => [
        'width' => '20%',
    ],
    'currency_symbol_left' => [
        'width' => '15%',
    ],
    'currency_symbol_right' => [
        'width' => '15%',
    ],
    'currency_active' => [
        'width' => '15%',
    ],
    'action' => [
        'width' => '15%',
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
                        'cardHeadTitle' => Labels::getLabel('LBL_CURRENCY', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_CURRENCIES', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true,
                        'statusButtons' => true
                    ];

                    $currencyPlugins = Plugin::getNamesByType(Plugin::TYPE_CURRENCY_CONVERTER, $adminLangId);
                    $obj = new Currency();
                    $currencyConverter = $obj->getCurrencyConverterApi();
                    if (!empty($currencyPlugins) && 0 < count($currencyPlugins) && false !== $currencyConverter) {
                        $data['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => "updateCurrencyRates('" . $currencyConverter . "')",
                                'title' => Labels::getLabel('LBL_UPDATE_CURRENCY', $adminLangId)
                            ],
                            'label' => '<i class="fas fa-file-download"></i>'
                        ];
                    }

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            $tableId = "currencyIds";
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'currency-management/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'controller' => $controller /* Used in case of toggle bulk status. */
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
        $('#currencyIds').tableDnD({
            onDrop: function(table, row) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());
                var order = $.tableDnD.serialize('id');
                fcom.ajax(fcom.makeUrl('CurrencyManagement', 'updateOrder'), order, function(res) {
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