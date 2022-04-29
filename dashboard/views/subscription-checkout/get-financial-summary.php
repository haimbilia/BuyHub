<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
$cartAdjustableAmount = isset($cartSummary['cartAdjustableAmount']) ? $cartSummary['cartAdjustableAmount'] : 0;
$discountTotal = isset($cartSummary['cartDiscounts']) && isset($cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0;
$amount = CommonHelper::displayMoneyFormat($cartTotal - $cartAdjustableAmount - $discountTotal, true, false, true, false, true);

$cartSubscription = current($subscriptions);
$spackage_type = $cartSubscription['spackage_type'];
?>

<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_ORDER_SUMMARY', $siteLangId); ?>
    </h3>
</div>
<div class="cart-total-body">
    <ul class="list-cart list-cart-page list-shippings">
        <?php foreach ($subscriptions as $subscription) { ?>
            <li>
                <div class="row">
                    <div class="col">
                        <?php
                        $spackageName = isset($subscription['spackage_name']) ? $subscription['spackage_name'] : '';
                        $spackagePrice = isset($subscription[SellerPackagePlans::DB_TBL_PREFIX . 'price']) ? $subscription[SellerPackagePlans::DB_TBL_PREFIX . 'price'] : '';
                        $interval = isset($subscription[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval']) ? $subscription[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval'] : 0;
                        echo  $spackageName . ' / ' . SellerPackagePlans::getPlanPeriod($subscription, $spackagePrice); ?>
                    </div>                    
                </div>
            </li>
        <?php } ?>
    </ul>
    <div class="divider"></div>
    <?php
    if ($spackage_type != SellerPackages::FREE_TYPE) {
        require(CONF_INSTALLATION_PATH . 'application/views/cart/_partial/coupons-section.php');
    } ?>

    <ul class="cart-summary">
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartTotal, true, false, true, false, true); ?></span>
        </li>
        <?php if ($cartAdjustableAmount > 0) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Adjusted_Amount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartAdjustableAmount, true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <?php if ($discountTotal > 0) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value">
                    <?php echo CommonHelper::displayMoneyFormat($discountTotal, true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <li class="cart-summary-item highlighted">
            <span class="label"><?php echo Labels::getLabel('LBL_You_Pay', $siteLangId); ?></span>
            <span class="value">
                <?php echo $amount; ?></span>
        </li>
    </ul>

    <?php if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0 && $canUseWalletForPayment) { ?>
        <div class="divider"></div>
        <div class="cart-total-foot">
            <div class="cart-action">
                <?php if ($spackage_type == SellerPackages::PAID_TYPE) { ?>
                    <p class="note">
                        <?php echo Labels::getLabel('LBL_NOTE_PLEASE_MAINTAIN_WALLET_BALANCE_FOR_FURTHER_AUTO_RENEWAL_PAYMENTS', $siteLangId); ?>
                    </p>
                <?php } ?>
                <label class="checkbox wallet-credits">
                    <input onchange="walletSelection(this)" type="checkbox" <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?> name="pay_from_wallet" id="pay_from_wallet" value="1">
                    <?php echo Labels::getLabel('LBL_WALLET_CREDITS:', $siteLangId); ?>&nbsp;
                    <strong><?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, false, true, false, true); ?></strong>
                </label>

                <?php if ($cartSummary["cartWalletSelected"] && $userWalletBalance >= $cartSummary['orderNetAmount']) {
                    $btnSubmitFld = $walletPaymentForm->getField('btn_submit');
                    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-block');
                    $btnSubmitFld->value = Labels::getLabel('LBL_PAY', $siteLangId) . ' ' . CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, false);
                    $walletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                    $walletPaymentForm->developerTags['fld_default_col'] = 12;
                    echo $walletPaymentForm->getFormTag();
                    echo $walletPaymentForm->getFieldHTML('order_id');
                    echo $walletPaymentForm->getFieldHTML('btn_submit');
                    echo $walletPaymentForm->getExternalJS();
                ?>
                    </form>

                    <script type="text/javascript">
                        function confirmOrder(frm) {
                            var data = fcom.frmData(frm);
                            var action = $(frm).attr('action');
                            fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout', 'confirmOrder'), data, function(ans) {
                                $(location).attr("href", action);
                            });
                        }
                    </script>
                <?php } else { ?>
                    <p class="txt-sm">
                        <?php echo Labels::getLabel('LBL_USE_MY_WALLET_BALANCE_TO_PAY_FOR_MY_ORDER', $siteLangId); ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>