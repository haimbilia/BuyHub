<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <!-- Closing tag must be added inside the files who include this file. -->
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link active" href="javascript:void(0)" onclick="getInstructions('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_INSTRUCTIONS', $adminLangId); ?>">
                <?php echo Labels::getLabel('LBL_INSTRUCTIONS', $adminLangId); ?>
            </a>

            <a class="nav-link " href="javascript:void(0)" onclick="importForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_Content', $adminLangId); ?>">
                <?php echo Labels::getLabel('LBL_Content', $adminLangId); ?>
            </a>
            <?php if ($displayMediaTab) { ?>
                <a class="nav-link" href="javascript:void(0)" onclick="importMediaForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_Media', $adminLangId); ?>">
                    <?php echo Labels::getLabel('LBL_Media', $adminLangId); ?>
                </a>

            <?php } ?>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <?php
        if (!empty($pageData['epage_content'])) {
        ?>
            <h2><?php echo $pageData['epage_label']; ?></h2>

        <?php
            echo FatUtility::decodeHtmlEntities($pageData['epage_content']);
        } else {
            echo 'Sorry!! No Instructions.';
        }
        ?>
    </div>

</div>