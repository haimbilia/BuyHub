<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$primaryOrder = isset($primaryOrder) ? $primaryOrder : true;
?>
<div class="col-md-8">
    <div class="table-wrap">
        <?php
        $cartTotal = 0;
        $shippingCharges = 0;
        $totalTax = 0;
        $total = 0;
        if (true == $primaryOrder) {
            $arr[] = $childOrderDetail;
        } else {
            $arr = $childOrderDetail;
        }
        $taxOptionsTotal = array();
        foreach ($arr as $childOrder) {
            $shippingCharges = $shippingCharges + CommonHelper::orderProductAmount($childOrder, 'shipping');
            if (empty($childOrder['taxOptions'])) {
                $totalTax = $totalTax + CommonHelper::orderProductAmount($childOrder, 'TAX');
            } else {
                foreach ($childOrder['taxOptions'] as $key => $val) {
                    $totalTax = $totalTax + $val['value'];
                }
            }
        }
        ?>

        <table class="table table-justified table-orders">
            <thead>
                <tr>
                    <th><?php echo Labels::getLabel('LBL_ITEMS_SUMMARY', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_Price', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($arr as $childOrder) {
                    $cartTotal = $cartTotal + CommonHelper::orderProductAmount($childOrder, 'cart_total');

                    $prodOrBatchUrl = 'javascript:void(0)';
                    if ($childOrder['op_is_batch']) {
                        $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'batch', array($childOrder['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                        $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($childOrder['op_selprod_id'], $siteLangId, "SMALL"), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                    } else {
                        if (Product::verifyProductIsValid($childOrder['op_selprod_id']) == true) {
                            $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'view', array($childOrder['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                        }
                        $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($childOrder['selprod_product_id'], "SMALL", $childOrder['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                    } ?>
                    <tr>
                        <td>
                            <div class="item">
                                <figure class="item__pic">
                                    <a href="<?php echo $prodOrBatchUrl; ?>">
                                        <img src="<?php echo $prodOrBatchImgUrl; ?>" title="<?php echo $childOrder['op_product_name']; ?>" alt="<?php echo $childOrder['op_product_name']; ?>">
                                    </a>
                                </figure>
                                <div class="item__description">
                                    <?php if ($childOrder['op_selprod_title'] != '') { ?>
                                        <div class="item__title">
                                            <a title="<?php echo $childOrder['op_selprod_title']; ?>" href="<?php echo $prodOrBatchUrl; ?>">
                                                <?php echo $childOrder['op_selprod_title'] . '<br>'; ?>
                                            </a>
                                        </div>
                                        <div class="item__category">
                                            <?php echo $childOrder['op_product_name']; ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="item__category">
                                            <a title="<?php echo $childOrder['op_product_name']; ?>" href="<?php echo UrlHelper::generateUrl('Products', 'view', array($childOrder['op_selprod_id']), CONF_WEBROOT_FRONTEND); ?>">
                                                <?php echo $childOrder['op_product_name']; ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="item__brand">
                                        <?php echo Labels::getLabel('Lbl_Brand', $siteLangId) ?>:
                                        <?php echo CommonHelper::displayNotApplicable($siteLangId, $childOrder['op_brand_name']); ?>
                                    </div>
                                    <div class="item__options">
                                        <?php echo sprintf(Labels::getLabel('LBL_QTY:_%S', $siteLangId), $childOrder['op_qty']); ?>
                                        <?php if ($childOrder['op_selprod_options'] != '') { ?>
                                            <?php echo ' | ' . $childOrder['op_selprod_options']; ?>
                                        <?php } ?>
                                    </div>
                                    <div class="item__sold_by">
                                        <?php echo Labels::getLabel('LBL_Sold_By', $siteLangId) . ': ' . $childOrder['op_shop_name']; ?>
                                    </div>
                                    <?php if ($childOrder['op_shipping_duration_name'] != '') { ?>
                                        <div class="item__shipping">
                                            <?php echo Labels::getLabel('LBL_Shipping_Method', $siteLangId); ?>:
                                            <?php echo $childOrder['op_shipping_durations'] . '-' . $childOrder['op_shipping_duration_name']; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                        <td><?php echo CommonHelper::displayMoneyFormat($childOrder['op_unit_price'], true, false, true, false, true); ?></td>
                        <td><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder), true, false, true, false, true); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
    if (true == $primaryOrder) { ?>
        <div class="timelines-wrap">
            <h5 class="card-title"><?php echo Labels::getLabel('MSG_ORDER_TIMELINE', $siteLangId); ?></h5>
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
        </div>
    <?php } ?>
</div>