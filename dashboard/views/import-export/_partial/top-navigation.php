<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<nav class="nav nav-tabs">
    <a class="nav-link <?php echo !empty($action) && $action == 'generalInstructions' ? 'active' : ''; ?>" href="javascript:void(0)" onclick="loadForm('general_instructions')">
        <?php echo Labels::getLabel('LBL_Instructions', $siteLangId); ?>
    </a>
    <a class="nav-link <?php echo !empty($action) && $action == 'export' ? 'active' : ''; ?>" href="javascript:void(0)" onclick="loadForm('export')">
        <?php echo Labels::getLabel('LBL_Export', $siteLangId); ?>
    </a>

    <?php if ($canEditImportExport) { ?>
        <a class="nav-link <?php echo !empty($action) && $action == 'import' ? 'active' : ''; ?>" href="javascript:void(0)" onclick="loadForm('import')">
            <?php echo Labels::getLabel('LBL_Import', $siteLangId); ?>
        </a>
        <a class="nav-link <?php echo !empty($action) && $action == 'settings' ? 'active' : ''; ?>" href="javascript:void(0)" onclick="loadForm('settings')">
            <?php echo Labels::getLabel('LBL_Settings', $siteLangId); ?>
        </a>
        <a class="nav-link <?php echo !empty($action) && $action == 'inventoryUpdate' ? 'active' : ''; ?>" href="javascript:void(0)" onclick="loadForm('inventoryUpdate')">
            <?php echo Labels::getLabel('LBL_Inventory_Update', $siteLangId); ?>
        </a>
    <?php }

    $canRequest = FatApp::getConfig('CONF_SELLER_CAN_REQUEST_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0);
    $canRequestCustomProd = FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0);
    if (0 < $canRequest && 0 < $canRequestCustomProd && $canUploadBulkImages) { ?>
        <a class="nav-link <?php echo !empty($action) && $action == 'bulkMedia' ? 'active' : ''; ?>" href="javascript:void(0)" onclick="loadForm('bulk_media')">
            <?php echo Labels::getLabel('LBL_Upload_Bulk_Media', $siteLangId); ?>
        </a>
    <?php } ?>
</nav>