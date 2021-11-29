<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <a class="back" href="">
                                    <svg class="svg" width="24" height="24">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                                        </use>
                                    </svg>
                                </a>
                                <?php
                                $str = Labels::getLabel('LBL_ORDER_#{ORDER-NUMBER}', $siteLangId);
                                echo CommonHelper::replaceStringData($str, ['{ORDER-NUMBER}' => $order['order_number']])
                                ?>
                            </h3>
                        </div>
                        <?php if (1 < count($sellers)) { ?>
                            <div class="card-toolbar">
                                <select class="form-select" onchange="getOrderParticulars(<?php echo $order['order_id'] ?>, this)">
                                    <option value=""><?php echo Labels::getLabel('LBL_ALL_SELLERS', $siteLangId); ?></option>
                                    <?php foreach ($sellers as $sellerId => $shopName) { ?>
                                        <option value="<?php echo $sellerId; ?>" <?php echo ($opSellerId == $sellerId ? 'selected="selected"' : ''); ?>><?php echo $shopName; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <?php require_once(CONF_THEME_PATH . 'orders/item-summary.php'); ?>
                </div>
                <?php if (!$order['order_deleted']) { ?>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_ORDER_PAYMENTS', $siteLangId); ?></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!$order["order_payment_status"] && $canEdit && 'CashOnDelivery' != $order['plugin_code']) {
                                require_once(CONF_THEME_PATH . 'orders/payment-form.php'); ?>
                                <div class="separator separator-dashed my-5"></div>
                            <?php } ?>

                            <?php require_once(CONF_THEME_PATH . 'orders/payment-history.php'); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-3">
                <?php require_once(CONF_THEME_PATH . 'orders/order-summary.php'); ?>
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><i class="fas fa-address-card"></i>
                                <?php echo Labels::getLabel('LBL_CONTACT_INFORMATION', $siteLangId); ?>
                            </h3>
                        </div>

                    </div>
                    <div class="card-body">
                        <ul class="list-text">
                            <?php if (isset($order['buyer_user_name'])) { ?>
                                <li>
                                    <span class="lable"><?php echo Labels::getLabel('LBL_Customer_Name', $siteLangId); ?>:</span>
                                    <span class="value"><?php echo $order['buyer_user_name']; ?></span>
                                </li>
                            <?php } ?>
                            <li>
                                <span class="lable"><?php echo Labels::getLabel('LBL_EMAIL', $siteLangId); ?>:</span>
                                <span class="value"><?php echo $order['buyer_email']; ?></span>
                            </li>
                        </ul>

                    </div>
                </div>
                <?php 
                $address = $order['shippingAddress'];
                if (!empty($address)) { ?>
                    <div class="card">
                        <div class="card-head dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block1" aria-expanded="false" aria-controls="order-block1">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><i class="fas fa-address-card"></i>
                                    <?php echo Labels::getLabel('LBL_SHIPPING_ADDRESS', $siteLangId); ?>
                                </h3>
                            </div>
                            <i class="dropdown-toggle-custom-arrow"></i>
                        </div>
                        <div class="card-body collapse" id="order-block1">
                            <?php include(CONF_THEME_PATH . 'orders/address.php'); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-head dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block2" aria-expanded="false" aria-controls="order-block2">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><i class="fas fa-address-card"></i>
                                <?php echo Labels::getLabel('LBL_BILLING_ADDRESS', $siteLangId); ?>
                            </h3>
                        </div>
                        <i class="dropdown-toggle-custom-arrow"></i>
                    </div>
                    <div class="card-body collapse" id="order-block2">
                        <?php
                        $address = $order['billingAddress'];
                        include(CONF_THEME_PATH . 'orders/address.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    var canShipByPlugin = <?php echo (!empty($shippingApiObj) ? 1 : 0); ?>;
    var orderShippedStatus = <?php echo $shippedOrderStatus; ?>;
</script>