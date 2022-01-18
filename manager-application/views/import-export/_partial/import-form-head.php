<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$activeInstTab = !empty($activeInstTab) ? 'active' : '';
$activeContentTab = !empty($activeContentTab) ? 'active' : '';
$activeMediaTab = !empty($activeMediaTab) ? 'active' : '';
$formSubTitle = !empty($formSubTitle) ? $formSubTitle : '';
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
        <?php if (!empty($formSubTitle)) { ?>
            <span class="text-muted"><?php echo $formSubTitle; ?></span>
        <?php } ?>
    </h5>
</div>
<div class="modal-body form-edit"> <!-- Closing tag must be added inside the files who include this file. -->
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link <?php echo $activeInstTab; ?>" href="javascript:void(0);" onclick="getImportInstructions('<?php echo $actionType; ?>'); return false;" title="<?php echo Labels::getLabel('LBL_INSTRUCTIONS', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_INSTRUCTIONS', $siteLangId); ?>
            </a>

            <a class="nav-link <?php echo $activeContentTab; ?>" href="javascript:void(0);" onclick="importForm('<?php echo $actionType; ?>'); return false;" title="<?php echo Labels::getLabel('LBL_Content', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_Content', $siteLangId); ?>
            </a>
            <?php if ($displayMediaTab) { ?>
                <a class="nav-link <?php echo $activeMediaTab; ?>" href="javascript:void(0);" onclick="importMediaForm('<?php echo $actionType; ?>'); return false;" title="<?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>">
                    <?php echo Labels::getLabel('LBL_Media', $siteLangId); ?>
                </a>

            <?php } ?>
        </nav>
    </div>