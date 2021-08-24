<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<ul class="timeline">
    <?php
    $selectUpto = array_search($currentStatus, array_keys($orderProductStatusArr));
    $index = 0;
    foreach ($orderProductStatusArr as $statusId => $statusLabel) {
        $current = $currentStatus == $statusId ? 'currently' : '';
        $highlight = ($index <= $selectUpto || in_array($statusId, $highlightEnabled) ? 'enable' : 'disabled');
        $orderTimeLineRecords = !empty($orderTimeLine) && isset($orderTimeLine[$statusId]) ? $orderTimeLine[$statusId] : [];
    ?>
        <li class="<?php echo $highlight . ' ' . $current . ' ' . OrderStatus::getOpStatusClass($statusId); ?>">
            <?php if (Orders::ORDER_PAYMENT_PENDING != $orderDetail['order_payment_status'] && !empty($orderTimeLineRecords)) {
                foreach (array_reverse($orderTimeLineRecords) as $i => $row) { ?>
                    <div class="timeline_data">
                        <div class="timeline_data_head">
                            <time class="timeline_date"><?php echo FatDate::format($row['oshistory_date_added']); ?></time>
                            <?php if (0 == $i) { ?>
                                <span class="order-status"> <em class="dot"></em>
                                    <?php echo $statusLabel; ?>
                                <?php } ?>
                                </span>
                        </div>
                        <div class="timeline_data_body">
                            <?php
                            if (isset($row['oshistory_orderstatus_id']) && $row['oshistory_orderstatus_id'] ==  OrderStatus::ORDER_SHIPPED) {
                                $trackingNumber = $row['oshistory_tracking_number'];
                                $carrier = $row['oshistory_courier']; ?>
                                <h6><?php echo Labels::getLabel('MSG_TRACKING_NUMBER', $siteLangId); ?></h6>
                                <div class="clipboard mb-4">
                                    <p class="clipboard_url" id="trackingNumberJs"><?php echo $trackingNumber; ?></p>
                                    <a class="clipboard_btn" onclick="copyContent(this)" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_COPY_TO_CLIPBOARD', $siteLangId); ?>">
                                        <i class="far fa-copy"></i>
                                    </a>
                                </div>
                                <p>
                                    <?php if (empty($row['oshistory_courier'])) {
                                        $str = '';
                                        if (!empty($shippingApiObj) && true === $shippingApiObj->canFetchTrackingDetail()) {
                                            $str .=  '<a class="link" href="javascript:void(0)" onclick="fetchTrackingDetail(' . "'" . $trackingNumber . "'" . ',' . "'" . $childOrderDetail['op_id'] . "'" . ')" title="' . Labels::getLabel("MSG_TRACK", $siteLangId) . '">' . Labels::getLabel("MSG_TRACK", $siteLangId) . '</a>';
                                        }

                                        if (empty($childOrderDetail['opship_tracking_url']) && !empty($trackingNumber)) {
                                            $str .=  " VIA <em>" . CommonHelper::displayNotApplicable($siteLangId, $childOrderDetail["opshipping_label"]) . "</em>";
                                        } elseif (!empty($childOrderDetail['opship_tracking_url'])) {
                                            $trackingUrls = (array) explode(', ', $childOrderDetail['opship_tracking_url']);
                                            $str .= '<br>';
                                            foreach ($trackingUrls as $url) {
                                                $str .=  " <a class='link' href='" . $url . "' target='_blank'>" . Labels::getLabel("MSG_TRACK", $siteLangId) . "</a>";
                                            }
                                        }
                                        echo $str;
                                    } else { ?>
                                        <a class="link" href="javascript:void(0)" title="<?php echo Labels::getLabel('LBL_TRACK', $siteLangId); ?>" onClick="trackOrder('<?php echo trim($trackingNumber); ?>', '<?php echo trim($carrier); ?>', '<?php echo $childOrderDetail['op_invoice_number']; ?>')">
                                            <?php echo $trackingNumber; ?>
                                        </a>
                                        <?php echo Labels::getLabel('LBL_VIA', $siteLangId); ?>
                                        <em>
                                            <?php echo CommonHelper::displayNotApplicable($siteLangId, $childOrderDetail["opshipping_label"]); ?>
                                        </em>
                                    <?php } ?>
                                </p>
                            <?php } ?>

                            <?php if (isset($row['oshistory_comments']) && !empty(trim(($row['oshistory_comments'])))) { ?>
                                <p><?php echo nl2br($row['oshistory_comments']); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="timeline_data">
                    <div class="timeline_data_head">
                        <?php if (Orders::ORDER_PAYMENT_PENDING == $statusId) { ?>
                            <time class="timeline_date"><?php echo FatDate::format($orderDetail['order_date_added']); ?></time>
                        <?php } ?>
                        <span class="order-status"> <em class="dot"></em>
                            <?php echo $statusLabel; ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
        </li>
    <?php
        $index++;
    } ?>
</ul>