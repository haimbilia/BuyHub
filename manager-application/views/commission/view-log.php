<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMISSION_HISTORY', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <!--Begin::Timeline 4 -->
        <div class="timeline-v4">
            <?php
            $totalRecords = count($arrListing);
            if (0 < $totalRecords) {
                $theDay = '';
                $count = 0;

                foreach ($arrListing as $sn => $row) {
                    $headTitle = HtmlHelper::getTheDay($row['csh_added_on'], $adminLangId);
                    if ($theDay != $headTitle) {
                        $theDay = $headTitle;
                        if ($count != 0) {
                            echo '</ul>';
                        } ?>
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
                                        <b><?php echo Labels::getLabel('LBL_Category', $adminLangId); ?>:</b> <?php echo  CommonHelper::displayText($row['prodcat_name']); ?>
                                    </span>
                                <?php } ?>
                                <?php if (!empty($row['product_name'])) { ?>
                                    <span class="timeline-v4__item-text">
                                        <b><?php echo Labels::getLabel('LBL_Product', $adminLangId); ?>:</b> <?php echo CommonHelper::displayText($row['product_name']); ?>
                                    </span>
                                <?php } ?>
                                <?php if (!empty($row['vendor'])) { ?>
                                    <span class="timeline-v4__item-user-name">
                                        <a href="#" class="link link--dark timeline-v4__item-link">
                                            <?php echo Labels::getLabel('LBL_BY', $adminLangId); ?> <?php echo CommonHelper::displayText($row['vendor']); ?>
                                        </a>
                                    </span>
                                <?php } ?>
                            </div>
                        </li>
                <?php if ($totalRecords == $count) {
                        echo '</ul>';
                    }
                    $count++;
                }
            } ?>

        </div>
        <!--End::Timeline 3 -->
    </div>
</div>