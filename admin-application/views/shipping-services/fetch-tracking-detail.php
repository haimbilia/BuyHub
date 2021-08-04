<?php defined('SYSTEM_INIT') or die('Invalid Usage . '); ?>

<ul class="timeline" id="timeline">
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
    <?php } else { ?>
        <li class="event">
            <?php if (!empty($trackingData) && array_key_exists('trackingUrl', $trackingData)) {?>
                <a href="<?php echo $trackingData['trackingUrl']; ?>" target="_blank"><?php echo Labels::getLabel('LBL_CLICK_HERE_TO_TRACK_EXTERNALLY', $siteLangId); ?></a>
            <?php } else {
                echo Labels::getLabel('MSG_NO_DETAIL_FOUND', $adminLangId);
            } ?>
        </li>
    <?php } ?>
</ul>