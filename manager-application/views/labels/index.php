<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_SYSTEM_CODE_AND_CAPTION', $siteLangId);

/* No sorting functionality required if no record found. */
if (2 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'listSerial' => [
        'width' => '5%'
    ],
    'label_key' => [
        'width' => '35%'
    ],
    'label_caption' => [
        'width' => '35%'
    ],
    'label_type' => [
        'width' => '15%'
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
                <?php require_once(CONF_THEME_PATH . 'labels/search-form.php'); ?>
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'siteLangId' => $siteLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_LABELS', $siteLangId),
                        'otherButtons' => [
                            [
                                'attr' => [
                                    'href' => 'javascript:void(0)',
                                    'onclick' => 'updateFile()',
                                    'title' => Labels::getLabel('LBL_UPDATE_WEB_LABEL_FILE', $siteLangId)
                                ],
                                'label' => '<i class="fas fa-laptop-code"></i>'
                            ],
                            [
                                'attr' => [
                                    'href' => 'javascript:void(0)',
                                    'onclick' => "updateFile(" . Labels::TYPE_APP . ")",
                                    'title' => Labels::getLabel('LBL_UPDATE_APP_LABEL_FILE', $siteLangId)
                                ],
                                'label' => '<i class="fas fa-mobile-alt"></i>'
                            ],
                        ]
                    ];
                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'labels/search.php');

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