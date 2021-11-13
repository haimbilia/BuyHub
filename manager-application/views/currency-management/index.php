<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$statusButtons = true;
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_CURRENCY', $siteLangId);

if (!empty($currencyPlugins) && 0 < count($currencyPlugins) && false !== $currencyConverter) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => "updateCurrencyRates('" . $currencyConverter . "')",
            'title' => Labels::getLabel('LBL_UPDATE_CURRENCY', $siteLangId)
        ],
        'label' => '<i class="fas fa-file-download"></i>'
    ];
}
?>

<main class="main mainJs">
    <div class="container">
        <?php $data = [
            'siteLangId' => $siteLangId,
            'newRecordBtn' => true,
            'canEdit' => $canEdit
        ];
        $this->includeTemplate('_partial/header/header-breadcrumb.php', $data, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            $tableId = "currencyIds";
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'currency-management/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'performBulkAction' => true /* Used in case of performing bulk action. */
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
    $(document).ready(function() {
        bindSortable();
    });
    $(document).ajaxComplete(function() {
        bindSortable();
    });

    function bindSortable() {
        if (1 > $('[data-field="dragdrop"]').length) {
            return;
        }

        $("#currencyIds > tbody").sortable({
            update: function(event, ui) {
                fcom.displayProcessing();
                $('.listingTableJs').prepend(fcom.getLoader());

                var order = $(this).sortable('toArray');
                var data = '';
                const bindData = new Promise((resolve, reject) => {
                    for (let i = 0; i < order.length; i++) {
                        data += 'currencyIds[]=' + order[i];
                        if (i + 1 < order.length) {
                            data += '&';
                        }
                    }
                    resolve(data);
                });
                bindData.then(
                    function(value) {
                        fcom.ajax(fcom.makeUrl('CurrencyManagement', 'updateOrder'), value, function(res) {
                            $.ykmsg.close();
                            fcom.removeLoader();
                            var ans = JSON.parse(res);
                            if (ans.status == 1) {
                                $.ykmsg.success(ans.msg);
                                return;
                            }
                            $.ykmsg.error(ans.msg);
                        });
                    },
                    function(error) {
                        fcom.removeLoader();
                        $.ykmsg.close();
                    }
                );
            },
        });
        $("#currencyIds > tbody").disableSelection();
    }
</script>