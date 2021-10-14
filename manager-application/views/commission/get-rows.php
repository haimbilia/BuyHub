<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$theDay = '';
$count = 1;
$lastDate = isset($postedData['reference']) ? date('Y-m-d', strtotime($postedData['reference'])) : '';
foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['csh_added_on'], $siteLangId);
    $canAddHead = (empty($lastDate) || (!empty($lastDate) && $lastDate != date('Y-m-d', strtotime($row['csh_added_on']))));
    if ($theDay != $headTitle && $canAddHead) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        } ?>
        <div class="rowJs" data-reference="<?php echo $row['csh_added_on']; ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items">
    <?php } ?>

                <li class="timeline-v4__item">
                    <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['csh_added_on'])); ?></span>
                    <div class="timeline-v4__item-desc">
                        <span class="timeline-v4__item-text">
                            <span class="tag"><?php echo CommonHelper::numberFormat($row['csh_commsetting_fees']); ?>%</span>
                        </span>
                        <?php if (!empty($row['prodcat_name'])) { ?>
                            <span class="timeline-v4__item-text">
                                <b><?php echo Labels::getLabel('LBL_Category', $siteLangId); ?>:</b> <?php echo  CommonHelper::displayText($row['prodcat_name']); ?>
                            </span>
                        <?php } ?>
                        <?php if (!empty($row['product_name'])) { ?>
                            <span class="timeline-v4__item-text">
                                <b><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?>:</b> <?php echo CommonHelper::displayText($row['product_name']); ?>
                            </span>
                        <?php } ?>
                        <?php if (!empty($row['vendor'])) { ?>
                            <span class="timeline-v4__item-user-name">
                                <a href="#" class="link link--dark timeline-v4__item-link">
                                    <?php echo Labels::getLabel('LBL_BY', $siteLangId); ?> <?php echo CommonHelper::displayText($row['vendor']); ?>
                                </a>
                            </span>
                        <?php } ?>
                    </div>
                </li>

    <?php if (count($arrListing) == $count && $canAddHead) {
        echo '</ul></div>';
    }
    $count++;
}
