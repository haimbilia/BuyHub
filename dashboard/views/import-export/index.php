<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <?php 
            $data = [
                'headingLabel' => Labels::getLabel('LBL_Import_Export', $siteLangId),
                'siteLangId' => $siteLangId,
            ];
            $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
        <div class="content-body">
            <div id="importExportBlock">
                <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
            </div>
        </div>
    </div>
</main>
<script>
    var inventoryUpdate = '<?php echo Importexport::TYPE_INVENTORY_UPDATE?>';
</script>
