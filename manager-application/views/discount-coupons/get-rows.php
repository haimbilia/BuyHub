<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$theDay = '';
$count = 1;
$lastDate = isset($postedData['reference']) ? date('Y-m-d', strtotime($postedData['reference'])) : '';
foreach ($arrListing as $sn => $row) {
    $headTitle = HtmlHelper::getTheDay($row['couponhistory_added_on'], $siteLangId);
    $canAddHead = (empty($lastDate) || (!empty($lastDate) && $lastDate != date('Y-m-d', strtotime($row['couponhistory_added_on']))));
    if ($theDay != $headTitle && $canAddHead) {
        $theDay = $headTitle;
        if ($count != 1) {
            echo '</ul></div>';
        } ?>
        <div class="rowJs" data-reference="<?php echo $row['couponhistory_added_on']; ?>">
            <div class="timeline-v4__item-date">
                <span class="tag">
                    <?php echo $headTitle; ?>
                </span>
            </div>
            <ul class="timeline-v4__items">
            <?php } ?>

            <li class="timeline-v4__item">
                <span class="timeline-v4__item-time"><?php echo date('H:i', strtotime($row['couponhistory_added_on'])); ?></span>
                <div class="timeline-v4__item-desc">
                    <span class="timeline-v4__item-text">
                        <span class="tag"><?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_#{ORDER-NO}', $siteLangId), ['{ORDER-NO}' => $row['couponhistory_order_no']]); ?></span>
                    </span>
                    <span class="timeline-v4__item-text">
                        <b><?php echo Labels::getLabel('LBL_AMOUNT', $siteLangId); ?>:</b> <?php echo CommonHelper::displayMoneyFormat($row['couponhistory_amount'], true, true, true, false, true); ?>
                    </span>
                    <span class="timeline-v4__item-user-name" data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('LBL_BUYER', $siteLangId); ?>">
                        <a href="javascript:void(0);" onclick="redirectUser(<?php echo $row['user_id']; ?>)" class="link link--dark timeline-v4__item-link">
                            <?php echo Labels::getLabel('LBL_BY', $siteLangId); ?> <?php echo CommonHelper::displayText($row['user_name']); ?>
                        </a>
                    </span>
                </div>
            </li>

        <?php if (count($arrListing) == $count && $canAddHead) {
            echo '</ul></div>';
        }
        $count++;
    }
