<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$fld  = $frmSearch->getField('keyword');
$fld->developerTags['noCaptionTag'] = true;
$fld->developerTags['col'] = 8;
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_ZONES', $adminLangId));

/* No sorting functionality required if no record found. */
if (1 > count($arrListing)) {
    $allowedKeysForSorting = [];
}

$tableHeadAttrArr = [
    'select_all' => [
        'width' => '5%',
    ],
    'action' => [
        'width' => '10%',
    ],
    'listSerial' => [
        'width' => '14%',
    ],
    'zone_identifier' => [
        'width' => '29%',
    ],
    'zone_name' => [
        'width' => '29%',
    ],
    'zone_active' => [
        'width' => '14%',
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
                        'cardHeadTitle' => Labels::getLabel('LBL_ZONES', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_ZONES', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true,
                        'statusButtons' => true
                    ];
                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php
                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'zones/search.php');

                            $data = [
                                'tbl' => $tbl,
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
</script>