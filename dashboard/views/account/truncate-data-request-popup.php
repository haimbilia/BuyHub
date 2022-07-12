<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Truncate_Request', $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <div class="cms loaderContainerJs">
        <p>
            <?php echo Labels::getLabel('LBL_Truncate_request_approval_will_delete_all_your_data._Truncate_anyway?', $siteLangId); ?>
        </p>
    </div>
</div>
<div class="modal-footer">
    <input class="btn btn-outline-gray btn-wide" onclick="cancelTruncateRequest()" type="button" name="btn_cancel" value="<?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?>">
    <input class="btn btn-brand  btn-wide" type="button" name="btn_submit" onclick="sendTruncateRequest()" value="<?php echo Labels::getLabel('LBL_Yes', $siteLangId); ?>">
</div>