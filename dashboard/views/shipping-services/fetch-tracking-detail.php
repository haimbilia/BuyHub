<?php defined('SYSTEM_INIT') or die('Invalid Usage . '); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Shipping_Services_tracking_detail', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <ul class="timeline" id="timeline">
            <?php if (!empty($trackingData) && array_key_exists('trackingUrl', $trackingData)) { ?>
                <li class="event" data-date="">
                    <a href="<?php echo $trackingData['trackingUrl']; ?>" target="_blank" class="link"><?php echo Labels::getLabel('LBL_CLICK_HERE_TO_TRACK_EXTERNALLY', $siteLangId); ?></a>
                    <hr>
                </li>
            <?php } ?>
            <?php if (!empty($trackingData) && array_key_exists('detail', $trackingData) && !empty(array_filter($trackingData['detail']))) { ?>
                <?php foreach ($trackingData['detail'] as $data) { ?>
                    <li class="event" data-date="<?php echo FatDate::format($data['dateTime'], true); ?>">
                        <div>
                            <p><strong><?php echo $data['description']; ?></strong></p>
                            <p><?php echo $data['location']; ?></p>
                            <small><?php echo $data['comments']; ?></small>
                        </div>
                    </li>
                <?php } ?>
            <?php } else {
                echo Labels::getLabel('MSG_NO_DETAIL_FOUND', $siteLangId);
            } ?>
        </ul>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>