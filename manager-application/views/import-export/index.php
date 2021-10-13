<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$controller = str_replace('Controller', '', FatApp::getController()); ?>

<main class="main mainJs">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card sticky-sidebar">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <?php echo Labels::getLabel('LBL_IMPORT_EXPORT', $adminLangId); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="settings-inner">
                            <?php
                            $this->includeTemplate('import-export/_partial/top-navigation.php', ['adminLangId' => $adminLangId, 'action' => $action], false); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" id="tabData"></div>
            </div>
        </div>
    </div>
</main>
<script>
    var controllerName = '<?php echo $controller; ?>';
    getHelpCenterContent(controllerName);
</script>