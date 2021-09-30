<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$controller = str_replace('Controller', '', FatApp::getController());
?>
<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <?php $data = [
                        'canEdit' => $canEdit,
                        'adminLangId' => $adminLangId,
                        'cardHeadTitle' => Labels::getLabel('LBL_CATEGORIES', $adminLangId),
                        'recordsTitle' => CommonHelper::replaceStringData(Labels::getLabel('LBL_OVER_{COUNT}_CATEGORIES', $adminLangId), ['{COUNT}' => $recordCount]),
                        'newRecordBtn' => true
                    ];

                    $this->includeTemplate('_partial/listing/listing-head.php', $data, false); ?>
                    <div class="card-body" id="listing"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-head">
                        <h3 class="card-head-label">
                            <span class="card-head-title">
                                <?php 
                                    $title = Labels::getLabel('LBL_Total_{CAT-COUNT}_CATEGORIES', $adminLangId);
                                    echo CommonHelper::replaceStringData($title, ['{CAT-COUNT}' => $recordCount]);
                                ?>
                            </span>
                        </h3>
                    </div>
                    <div class="card-body" id="total-block"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var controllerName = '<?php echo $controller; ?>';
    getHelpCenterContent(controllerName);
</script>