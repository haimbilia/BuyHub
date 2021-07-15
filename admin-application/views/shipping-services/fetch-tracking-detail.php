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
            <?php echo Labels::getLabel('MSG_NO_DETAIL_FOUND', $adminLangId); ?>
        </li>
    <?php } ?>
</ul>