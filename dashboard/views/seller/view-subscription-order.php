<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_View_Subscription_Order', $siteLangId),
        'siteLangId' => $siteLangId,
        'headingBackButton' => [
            'href' => UrlHelper::generateUrl('Seller', 'subscriptions'),
            'onclick' => ''
        ]
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <ul class="list-stats list-stats-double">
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_Subscription_Name', $siteLangId); ?>: </span>
                        <span class="value"><?php echo OrderSubscription::getSubscriptionTitle($orderDetail, $siteLangId); ?></span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_Subscription_Period', $siteLangId); ?>: </span>
                        <span class="value">
                            <?php if(SellerPackagePlans::SUBSCRIPTION_PERIOD_UNLIMITED == $orderDetail['ossubs_frequency']) {
                                echo $subcriptionPeriodArr[$orderDetail['ossubs_frequency']];
                            } else {
                                if ($orderDetail['ossubs_from_date'] == 0 || $orderDetail['ossubs_till_date'] == 0) {
                                    echo Labels::getLabel("LBL_N/A", $siteLangId);
                                } else {
                                    echo FatDate::format($orderDetail['ossubs_from_date']) . " - " . FatDate::format($orderDetail['ossubs_till_date']);
                                }
                            } ?>
                        </span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_Status', $siteLangId); ?>:</span>
                        <span class="value">
                            <?php if ($orderDetail['ossubs_status_id'] == FatApp::getConfig('CONF_DEFAULT_SUBSCRIPTION_PAID_ORDER_STATUS') && $orderDetail['ossubs_till_date'] < date("Y-m-d")) {
                                echo Labels::getLabel('LBL_Expired', $siteLangId);
                            } else {
                                echo $orderStatuses[$orderDetail['ossubs_status_id']];
                            } ?>
                        </span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_Date', $siteLangId); ?>: </span>
                        <span class="value"><?php echo FatDate::format($orderDetail['order_date_added'], true); ?></span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label">
                            <?php echo Labels::getLabel('LBL_Product_Upload_Limit', $siteLangId); ?>:</span>
                        <span class="value"><?php echo $orderDetail['ossubs_products_allowed']; ?></span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label">
                            <?php echo Labels::getLabel('LBL_Inventory_Upload_Limit', $siteLangId); ?>:</span>
                        <span class="value"><?php echo $orderDetail['ossubs_inventory_allowed']; ?></span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label">
                            <?php echo Labels::getLabel('LBL_RFQ_OFFERS_LIMIT', $siteLangId); ?>:</span>
                        <span class="value"><?php echo $orderDetail['ossubs_rfq_offers_allowed']; ?></span>
                    </li>
                    <li class="list-stats-item">
                        <span class="label">
                            <?php echo Labels::getLabel('LBL_Images_Limit', $siteLangId); ?>:</span>
                        <span class="value"><?php echo $orderDetail['ossubs_images_allowed']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="card-table">
                <?php
                $adjustedAmount = CommonHelper::orderSubscriptionAmount($orderDetail, 'ADJUSTEDAMOUNT');
                $discountVal = CommonHelper::orderSubscriptionAmount($orderDetail, 'DISCOUNT');
                $discount = CommonHelper::displayMoneyFormat($discountVal);
                ?>
                <div class="js-scrollable table-wrap">
                    <table class="table">
                        <thead>
                            <tr class="">
                                <th><?php echo Labels::getLabel('LBL_Invoice', $siteLangId); ?></th>
                                <th><?php echo Labels::getLabel('LBL_Subscription_Amount', $siteLangId); ?></th>
                                <?php if ($adjustedAmount != 0) { ?>
                                    <th><?php echo Labels::getLabel('LBL_ADJUSTED_AMOUNT', $siteLangId); ?></th>
                                <?php } ?>
                                <?php if (0 < abs($discountVal)) { ?>
                                    <th><?php echo Labels::getLabel('LBL_DISCOUNT', $siteLangId); ?></th>
                                <?php } ?>
                                <th><?php echo Labels::getLabel('LBL_PAID_AMOUNT', $siteLangId); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#<?php echo $orderDetail['order_number']; ?></td>
                                <td><?php echo CommonHelper::displayMoneyFormat($orderDetail['ossubs_price']); ?></td>
                                <?php if ($adjustedAmount != 0) { ?>
                                    <td><?php echo CommonHelper::displayMoneyFormat($adjustedAmount); ?></td>
                                <?php } ?>
                                <?php if (0 < abs($discountVal)) { ?>
                                    <td><?php echo $discount; ?></td>
                                <?php } ?>
                                <td><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderSubscriptionAmount($orderDetail, 'NETAMOUNT')); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>