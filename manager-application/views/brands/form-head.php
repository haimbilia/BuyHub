<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$activeGentab = !empty($activeGentab) ? 'active' : '';
$activeLangtab = !empty($activeLangtab) ? 'active' : '';
$activeMediatab = !empty($activeMediatab) ? 'active' : '';
$disabled = !empty($disabled) ? ' disabled' : '';
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_BRAND_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit"> <!-- Closing tag must be added inside the files who include this file. -->
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link <?php echo $activeGentab; ?>" href="javascript:void(0)" onclick="editRecord(<?php echo $recordId ?>);">
                <?php echo Labels::getLabel('LBL_General', $adminLangId);?>
            </a><i class="zmdi zmdi-account-box-phone"></i>
            <?php if( 0 < count($languages)) { ?>
                <a class="nav-link <?php echo $activeLangtab .  $disabled; ?>" href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='editLangData(" . $recordId . "," . array_key_first($languages) . ");'" : ""; ?>>
                    <?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
                </a>
            <?php } ?>
            <a class="nav-link <?php echo $activeMediatab .  $disabled; ?>" href="javascript:void(0);" <?php if (0 < $recordId) { ?> onclick="mediaForm(<?php echo $recordId ?>);" <?php } ?>>
                <?php echo Labels::getLabel('LBL_Media', $adminLangId);?>
            </a>
        </nav>
    </div>