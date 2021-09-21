<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this, false); return(false);');
$frmSearch->setFormTagAttribute('id', 'frmSearch');
$frmSearch->setFormTagAttribute('class', 'form');

$sortByFld = $frmSearch->getField('sortBy');
$sortByFld->setFieldTagAttribute('id', 'sortBy');

$sortOrderFld = $frmSearch->getField('sortOrder');
$sortOrderFld->setFieldTagAttribute('id', 'sortOrder');

$keyword  = $frmSearch->getField('keyword');
$keyword->addFieldtagAttribute('class', 'form-control');
$keyword->setFieldtagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_COUNTRIES', $adminLangId));

$submit  = $frmSearch->getField('btn_submit');
$submit->addFieldtagAttribute('class', 'btn btn-brand btn-block');

$btn_clear = $frmSearch->getField('btn_clear');
$btn_clear->addFieldtagAttribute('class', 'btn btn-link');
$btn_clear->addFieldtagAttribute('onclick', 'clearSearch();');

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
    'country_code' => [
        'width' => '14%',
    ],
    'country_code_alpha3' => [
        'width' => '14%',
    ],
    'country_active' => [
        'width' => '14%',
    ],
    'country_name' => [
        'width' => '29%',
    ],
];

$controller = str_replace('Controller', '', FatApp::getController());
?>
<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo $frmSearch->getFormTag(); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $frmSearch->getFieldHTML('keyword'); ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $frmSearch->getFieldHTML('btn_submit'); ?>
                            </div>
                            <div class="col-md-2">
                                <?php echo $frmSearch->getFieldHTML('btn_clear'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo $frmSearch->getFieldHTML('sortBy');
                echo $frmSearch->getFieldHTML('sortOrder');
                echo $frmSearch->getFieldHTML('reportColumns');
                echo $frmSearch->getFieldHTML('pageSize');
                echo $frmSearch->getExternalJS(); ?>
                </form>
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'adminLangId' => $adminLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_COUNTRIES', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_COUNTRIES', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true,
                        'statusButtons' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body">
                        <div class="table-responsive listingTableJs">
                            <?php

                            require_once(CONF_THEME_PATH . '_partial/listing/listing-column-head.php');
                            require_once(CONF_THEME_PATH . 'countries/search.php');
                            
                            $data = [
                                'tbl' => $tbl,
                                'controller' => $controller
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