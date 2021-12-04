<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<main class="main">
    <div class="container">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php', [], false); ?>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title">
                                <a class="back" href="<?php echo UrlHelper::generateUrl('SubscriptionOrders'); ?>">
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
                    </div>
                    <?php require_once(CONF_THEME_PATH . 'subscription-orders/item-summary.php'); ?>
                </div>
                <?php 
                $paymentFormCond = (!$order["order_payment_status"] && $canEdit && 'CashOnDelivery' != $order['plugin_code']);
                $paymentHistory = (!empty($order['payments']));
                if (!$order['order_deleted'] && ($paymentFormCond || $paymentHistory)) { ?>
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-label">
                                <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_ORDER_PAYMENTS', $siteLangId); ?></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($paymentFormCond) {
                                require_once(CONF_THEME_PATH . 'subscription-orders/payment-form.php'); ?>
                                <div class="separator separator-dashed my-5"></div>
                            <?php } ?>

                            <?php require_once(CONF_THEME_PATH . 'subscription-orders/payment-history.php'); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-3">
                <?php require_once(CONF_THEME_PATH . 'subscription-orders/order-summary.php'); ?>

                <?php if (!empty($order['buyer_user_name']) || !empty($order['buyer_email'])) { ?>
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
                                <?php if (!empty($order['buyer_user_name'])) { ?>
                                    <li>
                                        <span class="lable"><?php echo Labels::getLabel('LBL_Customer_Name', $siteLangId); ?>:</span>
                                        <span class="value"><?php echo $order['buyer_user_name']; ?></span>
                                    </li>
                                <?php } ?>
                                <?php if (!empty($order['buyer_email'])) { ?>
                                    <li>
                                        <span class="lable"><?php echo Labels::getLabel('LBL_EMAIL', $siteLangId); ?>:</span>
                                        <span class="value"><?php echo $order['buyer_email']; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>

                        </div>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-label">
                            <h3 class="card-head-title"><i class="fas fa-credit-card"></i>
                                <?php echo Labels::getLabel('LBL_PAYMENT_INFORMATION', $siteLangId); ?>
                            </h3>
                        </div>

                    </div>
                    <div class="card-body">
                        <ul class="list-text">
                            <li>
                                <span class="lable"><?php echo Labels::getLabel('LBL_PAYMENT_MODE', $siteLangId); ?>:</span>
                                <span class="value"><?php echo $paymentMethodName; ?></span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>