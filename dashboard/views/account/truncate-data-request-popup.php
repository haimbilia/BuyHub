<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Truncate_Request', $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <?php echo Labels::getLabel('LBL_Truncate_request_approval_will_delete_all_your_data._Truncate_anyway?', $siteLangId); ?>
</div>
<div class="modal-footer">
    <form class="form form--horizontal">
        <div class="field-wraper">
            <div class="field_cover">
                <input class="btn btn-brand" type="button" name="btn_submit" onclick="sendTruncateRequest()" value="<?php echo Labels::getLabel('LBL_Yes', $siteLangId); ?>">
                <input class="btn btn-outline-brand" onclick="cancelTruncateRequest()" type="button" name="btn_cancel" value="<?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?>">
            </div>
        </div>
    </form>
</div>