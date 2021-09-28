<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$activeGentab = !empty($activeGentab) ? 'active' : '';
$activeLangtab = !empty($activeLangtab) ? 'active' : '';
$disabled = !empty($disabled) ? ' disabled' : '';
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_STATE_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit"> <!-- Closing tag must be added inside the files who include this file. -->
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link <?php echo $activeGentab; ?>" href="javascript:void(0)" onclick="editRecord(<?php echo $recordId ?>);">
                <?php echo Labels::getLabel('LBL_GENERAL', $adminLangId); ?>
            </a>
            <a class="nav-link <?php echo $activeLangtab . $disabled; ?>" href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='editLangData(" . $recordId . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $adminLangId); ?>
            </a>
        </nav>
    </div>