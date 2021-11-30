<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$theDay = '';
$count = 1;
$lastDate = isset($postedData['reference']) ? date('Y-m-d', strtotime($postedData['reference'])) : '';
foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['oshistory_date_added'], $siteLangId);
    $canAddHead = (empty($lastDate) || (!empty($lastDate) && $lastDate != date('Y-m-d', strtotime($row['oshistory_date_added']))));
    if ($theDay != $headTitle && $canAddHead) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        } ?>
        <div class="rowJs" data-reference="<?php echo $row['oshistory_date_added']; ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items">
            <?php } ?>

                <li class="timeline-v4__item">
                    <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['oshistory_date_added'])); ?></span>
                    <div class="timeline-v4__item-desc">
                        <span class="timeline-v4__item-text">
                            <span class="tag"><?php echo $row['orderstatus_name']; ?></span>
                        </span>
                        <?php if (!empty($row['oshistory_tracking_number'])) { ?>
                            <span class="timeline-v4__item-text">
                                <b><?php echo Labels::getLabel('LBL_TRACKING_NUMBER', $siteLangId); ?>:</b> 
                                <a href="javascript:void(0);" onclick="copyText(this);" class="link link--dark timeline-v4__item-link" data-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_CLICK_TO_COPY', $siteLangId); ?>">
                                    <?php echo  CommonHelper::displayText($row['oshistory_tracking_number']); ?>
                                </a>
                            </span>
                        <?php } ?>
                        <?php if (!empty($row['oshistory_courier'])) { ?>
                            <span class="timeline-v4__item-text">
                                <b><?php echo Labels::getLabel('LBL_COURIER', $siteLangId); ?>:</b> <?php echo  CommonHelper::displayText($row['oshistory_courier']); ?>
                            </span>
                        <?php } ?>
                        <?php if (!empty($row['oshistory_tracking_url'])) { ?>
                            <span class="timeline-v4__item-user-name">
                                <a href="<?php echo $row['oshistory_tracking_url'];?>" target="_blank" class="link link--dark timeline-v4__item-link">
                                    <?php echo Labels::getLabel('LBL_CLICK_HERE_TO_TRACK', $siteLangId); ?>
                                </a>
                            </span>
                        <?php } ?>
                        <?php if (!empty($row['oshistory_comments'])) { ?>
                            <span class="timeline-v4__item-text">
                                <b><?php echo Labels::getLabel('LBL_COMMENTS', $siteLangId); ?>:</b> <?php echo  CommonHelper::displayText($row['oshistory_comments']); ?>
                            </span>
                        <?php } ?>
                    </div>
                </li>

    <?php if (count($arrListing) == $count && $canAddHead) {
        echo '</ul></div>';
    }
    $count++;
}
