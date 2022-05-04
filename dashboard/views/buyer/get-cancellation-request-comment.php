<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit layoutsJs">
    <div class="form-edit-body loaderContainerJs">
        <div class="cms">
            <?php echo $comments; ?>
        </div>
    </div>
</div>