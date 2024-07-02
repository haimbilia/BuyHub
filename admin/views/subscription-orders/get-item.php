<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$op = current($order['items']); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo OrderSubscription::getSubscriptionTitle($op, $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opDetailsJs<?php echo $op['ossubs_id']; ?>">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats list-stats-double">
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_INVOICE_NUMBER', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['ossubs_invoice_number'] ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_ADDED_ON', $siteLangId); ?>:</span>
                <span class="value"><?php echo FatDate::format($order['order_date_added'], true); ?></span>
            </li>

            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_SUBSCRIPTION_PERIOD', $siteLangId); ?>:</span>
                <span class="value">
                    <?php
                    if (SellerPackagePlans::SUBSCRIPTION_PERIOD_UNLIMITED == $op['ossubs_frequency']) {
                        echo $subcriptionPeriodArr[$op['ossubs_frequency']];
                    } else {
                        if ($op['ossubs_from_date'] == 0 || $op['ossubs_till_date'] == 0) {
                            echo Labels::getLabel("LBL_N/A", $siteLangId);
                        } else {
                            echo FatDate::format($op['ossubs_from_date']) . " - " . FatDate::format($op['ossubs_till_date']);
                        }
                    } ?>
                </span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_SUBSCRIPTION_AMOUNT', $siteLangId); ?>:</span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($op['ossubs_price']); ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_PRODUCT_UPLOAD_LIMIT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['ossubs_products_allowed']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_INVENTORY_UPLOAD_LIMIT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['ossubs_inventory_allowed']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_IMAGES_LIMIT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['ossubs_images_allowed']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_RFQ_OFFERS_LIMIT', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['ossubs_rfq_offers_allowed']; ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_Commision_rate', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['ossubs_commission'] . "%"; ?></span>
            </li>

            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_TOTAL', $siteLangId); ?>:</span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($order['order_net_amount'], true, true, true, false, true); ?></span>
            </li>
        </ul>
    </div>
</div>