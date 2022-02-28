<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
        $data = [
            'headingLabel' => Labels::getLabel('LBL_IMPORT_EXPORT', $siteLangId),
            'siteLangId' => $siteLangId,
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="card card-tabs" id="importExportBlock">
            <div class="card-head">
                <?php $variables = array('siteLangId' => $siteLangId, 'action' => $action, 'canEditImportExport' => $canEditImportExport, 'canUploadBulkImages' => $canUploadBulkImages);
                $this->includeTemplate('import-export/_partial/top-navigation.php', $variables, false); ?>
            </div>
            <div class="card-body">
                <?php echo Labels::getLabel('LBL_LOADING..', $siteLangId); ?>
            </div>
        </div>
    </div>
</div>
<script>
    var inventoryUpdate = <?php echo Importexport::TYPE_INVENTORY_UPDATE; ?>;
</script>