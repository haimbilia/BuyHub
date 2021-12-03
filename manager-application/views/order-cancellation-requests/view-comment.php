<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $title; ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <div class="row">
            <div class="col-md-4">
                <?php echo Labels::getLabel('LBL_REASON', $siteLangId);?> :
            </div>
            <div class="col-md-8">
                <?php echo nl2br($cancelMessage['ocreason_title']); ?>
            </div>
        </div>
        <?php if (!empty($cancelMessage['ocreason_description'])) { ?>
            <div class="row">
                <div class="col-md-4">
                    <?php echo Labels::getLabel('LBL_DESCRIPTION', $siteLangId);?> :
                </div>
                <div class="col-md-8">
                    <?php echo nl2br($cancelMessage['ocreason_description']); ?>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-4">
                <?php echo Labels::getLabel('LBL_MESSAGE', $siteLangId);?> :
            </div>
            <div class="col-md-8">
                <?php echo nl2br($cancelMessage['ocrequest_message']); ?>
            </div>
        </div>
        <?php if (!empty($cancelMessage['ocrequest_admin_comment'])) { ?>
            <div class="row">
                <div class="col-md-4">
                    <?php echo Labels::getLabel('LBL_ADMIN/SELLER_MESSAGE', $siteLangId);?> :
                </div>
                <div class="col-md-8">
                    <?php echo nl2br($cancelMessage['ocrequest_admin_comment']); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>