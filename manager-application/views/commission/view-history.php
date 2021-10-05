<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMISSION_HISTORY', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit scroll scroll-y ">
    <div class="form-edit-body">
        <?php 
        if (count($arrListing) == 0) {
            $this->includeTemplate('_partial/no-record-found.php', array('adminLangId' => $adminLangId));
        } else {
            $dayPrint = '';
            foreach ($arrListing as $sn => $row) {
                $current = strtotime(date("Y-m-d"));
                $date    = strtotime($row['csh_added_on']);
                $time    = date('H:i', $date);

                $datediff = $date - $current;
                $difference = floor($datediff / (60 * 60 * 24));

                $day = date('d-m-Y', $date);
                if ($difference == 0) {
                    $day = Labels::getLabel('LBL_TODAY', $adminLangId);
                } else if ($difference == -1) {
                    $day = Labels::getLabel('LBL_YESTERDAY', $adminLangId);
                }

                if ($dayPrint != $day) { 
                    if ('' != $dayPrint) { ?>
                            </ul>
                        </div> <!-- Close Div On Every Day Change -->
                    <?php }
                    $dayPrint = $day; ?>
                    
                    <div class="timeline-v4">
                        <div class="timeline-v4__item-date">
                            <span class="tag">
                                <?php echo $day; ?>
                            </span>
                        </div>
                        <ul class="timeline-v4__items">
                <?php } ?>
                            <li class="timeline-v4__item">
                                <span class="timeline-v4__item-time"><?php echo $time; ?></span>
                                <div class="timeline-v4__item-desc">
                                    <span class="timeline-v4__item-text" title="<?php echo Labels::getLabel('LBL_Fees', $adminLangId); ?>">
                                        <span class="tag">
                                            <?php echo CommonHelper::numberFormat($row['csh_commsetting_fees']) . '%'; ?>
                                        </span>
                                    </span>
                                    <span class="timeline-v4__item-text" title="<?php echo Labels::getLabel('LBL_CATEGORY', $adminLangId); ?>">
                                        <b><?php echo Labels::getLabel('LBL_CATEGORY', $adminLangId); ?>:</b> <?php echo CommonHelper::displayText($row['prodcat_name']); ?>
                                    </span>
                                    <span class="timeline-v4__item-text" title="<?php echo Labels::getLabel('LBL_PRODUCT', $adminLangId); ?>">
                                        <b><?php echo Labels::getLabel('LBL_PRODUCT', $adminLangId); ?>:</b> <?php echo CommonHelper::displayText($row['product_name']); ?>
                                    </span>
                                    <span class="timeline-v4__item-user-name" title="<?php echo Labels::getLabel('LBL_Seller', $adminLangId); ?>">
                                        <a href="#" class="link link--dark timeline-v4__item-link">
                                            <?php
                                                $by = Labels::getLabel('LBL_BY_{NAME}', $adminLangId);
                                                echo CommonHelper::replaceStringData($by, ['{NAME}' => CommonHelper::displayText($row['vendor'])])
                                            ?>
                                        </a>
                                    </span>
                                </div>
                            </li>
            <?php } ?>
                        </ul>
                    </div> <!-- Close Div After Last Entry. -->      
        <?php } ?>
    </div>
</div>