<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="timeline">
    <?php
    $orderCancelled = (FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS") == $childOrderDetail['orderstatus_id']);
    $selectUpto = array_search($currentStatus, array_keys($orderProductStatusArr));
    if (isset($childOrderDetail['plugin_code']) && strtolower($childOrderDetail['plugin_code']) == 'cashondelivery') {
        $selectUpto = array_search($childOrderDetail['orderstatus_id'], array_keys($orderProductStatusArr));
    }
    $index = 0;

    foreach ($orderProductStatusArr as $statusId => $statusLabel) {
        $current = $currentStatus == $statusId || $orderCancelled ? 'currently ' : '';
        $highlight = ($index <= $selectUpto || in_array($statusId, $highlightEnabled) || $orderCancelled ? 'enable ' : 'disabled ');
        $orderTimeLineRecords = !empty($orderTimeLine) && isset($orderTimeLine[$statusId]) ? $orderTimeLine[$statusId] : [];

    ?>
        <li class="<?php echo $highlight . $current; ?>">
            <?php if (!empty($orderTimeLineRecords)) {
                foreach (array_reverse($orderTimeLineRecords) as $i => $row) {
                    /* Same Status with no Comment.*/
                    if (1 < count($orderTimeLineRecords) && 0 < $i && empty(trim($row['oshistory_comments']))) {
                        continue;
                    } ?>

                    <div class="timeline_data">
                        <div class="timeline_data_head">
                            <time class="timeline_date"><?php echo FatDate::format($row['oshistory_date_added']); ?></time>
                            <?php if (0 == $i) { ?>
                                <span class="order-status <?php echo $orderColorClasses[$statusId]; ?>"> <em class="dot"></em>
                                    <?php echo $statusLabel; ?>
                                <?php } ?>
                                </span>
                        </div>
                        <div class="timeline_data_body">
                            <?php
                            if (isset($row['oshistory_orderstatus_id']) && $row['oshistory_orderstatus_id'] ==  FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS")) {

                                $trackingNumbers = explode(",", $childOrderDetail['opship_tracking_number']);

                                $carrier = $row['oshistory_courier']; ?>
                                <h6><?php echo Labels::getLabel('MSG_TRACKING_NUMBER', $siteLangId); ?></h6>

                                <?php foreach ($trackingNumbers as $trackingNumber) {
                                    $trackingNumber = trim($trackingNumber);
                                   /*  if (is_numeric($trackingNumber)) {
                                        $trackingNumber = number_format($trackingNumber, 0, null, '');
                                    } */
                                ?>
                                    <div class="clipboard mb-4">
                                        <input class="copy-input trackingNumberJs" type="text" readonly value="<?php echo $trackingNumber; ?>" />

                                        <button class="copy-btn" type="button" onclick="copyContent(this)" data-bs-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_COPY_TO_CLIPBOARD', $siteLangId); ?>">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                <?php  } ?>
                                <p>
                                    <?php
                                    if (empty($row['oshistory_courier'])) {
                                        $str = '';
                                        if (!empty($shippingApiObj) && true === $shippingApiObj->canFetchTrackingDetail()) {
                                            foreach ($trackingNumbers as $trackingNumber) {
                                                $trackingNumber = trim($trackingNumber);
                                                /*if (is_numeric($trackingNumber)) {
                                                    $trackingNumber = number_format($trackingNumber, 0, null, '');
                                                }*/
                                                $str .=  '<div><a class="link" href="javascript:void(0)" onclick="fetchTrackingDetail(' . "'" . $trackingNumber . "'" . ',' . "'" . $childOrderDetail['op_id'] . "'" . ')" title="' . Labels::getLabel("MSG_TRACK", $siteLangId) . '">' . Labels::getLabel("MSG_TRACK", $siteLangId) . '</a></div>';
                                                if (empty($childOrderDetail['opship_tracking_url']) && !empty($trackingNumber)) {
                                                    $str .=  Labels::getLabel("LBL_VIA", $siteLangId) . "<em>" . CommonHelper::displayNotApplicable($siteLangId, $childOrderDetail["opshipping_label"]) . "</em>";
                                                }
                                            }
                                        }
                                        if (!empty($childOrderDetail['opship_tracking_url']) && empty($row['oshistory_tracking_url'])) {
                                            $trackingUrls = (array) explode(', ', $childOrderDetail['opship_tracking_url']);
                                            $str .= '<br>';
                                            foreach ($trackingUrls as $url) {
                                                $str .=  " <a class='link-underline' href='" . $url . "' target='_blank'>" . Labels::getLabel("MSG_TRACK", $siteLangId) . "</a>";
                                            }
                                        }
                                        echo $str;
                                    } else {
                                        foreach ($trackingNumbers as $trackingNumber) {
                                            $trackingNumber = trim($trackingNumber);
                                            /* if (is_numeric($trackingNumber)) {
                                                $trackingNumber = number_format($trackingNumber, 0, null, '');
                                            } */
                                    ?>
                                            <a class="link" href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_TRACK', $siteLangId); ?>" onclick="trackOrder('<?php echo trim($trackingNumber); ?>', '<?php echo trim($carrier); ?>', '<?php echo $childOrderDetail['op_invoice_number']; ?>')">
                                                <?php echo $trackingNumber; ?>
                                            </a>
                                        <?php } ?>
                                        <?php echo Labels::getLabel('LBL_VIA', $siteLangId); ?>
                                        <em>
                                            <?php echo CommonHelper::displayNotApplicable($siteLangId, $childOrderDetail["opshipping_label"]); ?>
                                        </em>
                                    <?php } ?>
                                </p>
                            <?php } ?>
                            <?php if (!empty($row['oshistory_tracking_url'])) { ?>
                                <a href="<?php echo $row['oshistory_tracking_url']; ?>" target="_blank" class="link-underline">
                                    <?php echo Labels::getLabel('LBL_CLICK_HERE_TO_TRACK', $siteLangId); ?>
                                </a>
                            <?php } ?>
                            <p>
                                <?php if (isset($row['oshistory_comments']) && !empty(trim(($row['oshistory_comments'])))) { ?>
                                    <?php echo nl2br($row['oshistory_comments']); ?>
                                <?php } else {
                                    echo OrderStatus::getDefaultOrderStatusMsg($statusId, $siteLangId);
                                } ?>
                            </p>
                        </div>
                    </div>
                <?php }
            } else {
                if ($orderCancelled) {
                    $statusLabel = isset($childOrderDetail['orderstatus_name']) ? $childOrderDetail['orderstatus_name'] : $childOrderDetail['orderstatus_identifier'];
                }
                ?>
                <div class="timeline_data">
                    <div class="timeline_data_head">
                        <?php if (Orders::ORDER_PAYMENT_PENDING == $statusId) { ?>
                            <time class="timeline_date"><?php echo FatDate::format($orderDetail['order_date_added']); ?></time>
                        <?php } else if ($orderCancelled) { ?>
                            <time class="timeline_date"><?php echo FatDate::format($cancelledDate); ?></time>
                        <?php } ?>
                        <span class="order-status <?php echo $orderColorClasses[$statusId] ?? ''; ?>"> <em class="dot"></em>
                            <?php echo $statusLabel; ?>
                        </span>
                    </div>

                    <?php if ($orderCancelled) { ?>
                        <p><?php echo Labels::getLabel('LBL_THE_ORDER_HAS_BEEN_CANCELLED_DUE_TO_CERTAIN_REASON.', $siteLangId); ?></p>
                        <?php if (isset($cancellationComment) && !empty($cancellationComment)) { ?>
                            <p><strong><?php echo CommonHelper::replaceStringData(Labels::getLabel('LBL_COMMENT:_{COMMENT}'), ['{COMMENT}' => $cancellationComment]); ?></strong></p>
                        <?php } ?>
                    <?php } else if ($index <= $selectUpto) { ?>
                        <div class="timeline_data_body">
                            <p> <?php echo OrderStatus::getDefaultOrderStatusMsg($statusId, $siteLangId); ?></p>
                        </div>
                    <?php } ?>
                </div>
            <?php
                if ($orderCancelled) {
                    break;
                }
            } ?>
        </li>
    <?php
        $index++;
    } ?>
</ul>