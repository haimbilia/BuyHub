<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit layoutsJs">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats list-stats-double">
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_REASON', $siteLangId); ?>:</span>
                <span class="value"><?php echo $row['orreason_title']; ?></span>
            </li>
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_COMMENT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $row['orrmsg_msg']; ?></span>
            </li>
        </ul>
    </div>
</div>