<?php defined('SYSTEM_INIT') or die('Invalid Usage . '); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Order_tracking_info', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php if ($trackingInfo['meta']['code'] != 200) { ?>
            <h4>
                <?php echo $trackingInfo['meta']['code'] . ' : ' . $trackingInfo['meta']['message']; ?>
            </h4>
        <?php } else if (!empty($trackingInfo['data']['tracking']['checkpoints'])) { ?>
            <ul class="timeline" id="timeline">
                <?php foreach ($trackingInfo['data']['tracking']['checkpoints'] as $data) { ?>
                    <li class="event" data-date="<?php echo FatDate::format($data['checkpoint_time'], true); ?>">
                        <div>
                            <p><strong><?php echo $data['tag']; ?></strong></p>
                            <p><?php echo $data['message']; ?></p>
                            <p><?php echo $data['location']; ?></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } else {  ?>
            <ul class="timeline" id="timeline">
                <li class="event" data-date="<?php echo FatDate::format($trackingInfo['data']['tracking']['created_at'], true); ?>">
                    <div>
                        <p><strong><?php echo $trackingInfo['data']['tracking']['tag']; ?></strong></p>
                    </div>
                </li>
            </ul>
        <?php } ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>