<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_ABUSIVE_KEYWORD', $siteLangId);
$deleteButton = true;

$langLayout = [];
foreach ($languages as $langId => $langName) {
    $layOutDir = Language::getLayoutDirection($langId);
    $langLayout[$langId] = $layOutDir;
} ?>
<main class="main mainJs">
    <div class="container">
        <?php $data = [
            'canEdit' => $canEdit,
            'siteLangId' => $siteLangId,
            'newRecordBtn' => true
        ];
        $this->includeTemplate('_partial/header/header-breadcrumb.php', $data, false); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . 'abusive-words/search-form.php'); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'abusive-words/search.php');

                            $data = [
                                'tbl' => $tbl, /* Received from listing-column-head.php file. */
                                'performBulkAction' => true, /* Used in case of performing bulk action. */
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
    var langLayOuts = <?php echo json_encode($langLayout); ?>;
    (function() {
        changeFormLayOut = function(el) {
            var langId = $(el).val();
            var className = 'layout--' + langLayOuts[langId];
            $("#frmAbusiveWord").removeClass(function(index, className) {
                return (className.match(/(^|\s)layout--\S+/g) || []).join(' ');
            });
            $("#frmAbusiveWord").addClass(className);
        };
    })();
</script>