<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="tbl-heading"><?php echo Labels::getLabel('LBL_Shopping_Cart', $siteLangId); ?> </div>
<div class="js-scrollable table-wrap table-responsive">
    <table class="table cart--full item-yk">
        <thead>
            <tr>
                <th><?php echo Labels::getLabel('LBL_Order_Particulars', $siteLangId); ?></th>
                <th><?php echo Labels::getLabel('LBL_Price', $siteLangId); ?></th>
                <th><?php echo Labels::getLabel('LBL_SubTotal', $siteLangId); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($subscriptionArr)) {
                foreach ($subscriptionArr as $subscription) { ?>
                    <tr>
                        <td>
                            <div class="item__head">
                                <div class="product-profile__title"><a href="javascript:void(0)"><?php echo $subscription['spackage_name'] ?></a></div>
                            </div>

                            <a href="<?php echo UrlHelper::generateUrl('seller', 'packages'); ?>" class="btn btn-sm btn--gray ripplelink"><?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?></a> <a href="javascript:void(0)" onclick="subscription.remove('<?php echo md5($subscription['key']); ?>')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>" class="btn btn-sm btn--gray ripplelink"><?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?></a>
                        </td>
                        <td>
                            <div class="product_price product--price"><?php echo SellerPackagePlans::getPlanPriceWithPeriod($subscription, $subscription[SellerPackagePlans::DB_TBL_PREFIX . 'price']); ?>
                                <?php if ($subscription[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval'] > 0) { ?>
                                    <span><?php echo SellerPackagePlans::getPlanTrialPeriod($subscription); ?></span>
                                <?php } ?>
                            </div>
                        </td>
                        <td><span class="hide--desktop mobile-thead"><?php echo Labels::getLabel('LBL_SubTotal', $siteLangId); ?></span>
                            <div class="product_price"><?php echo CommonHelper::displayMoneyFormat($subscription[SellerPackagePlans::DB_TBL_PREFIX . 'price'], true, false, true, false, true); ?></div>
                        </td>
                    </tr>
            <?php }
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>
<div class="cart-footer">
    <div class="cartdetail__footer">
        <table class="table--justify">
            <tbody>
                <tr>
                    <td><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?></td>
                    <td><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal'], true, false, true, false, true); ?></td>
                </tr>
                <tr>
                    <td class="hightlighted"><?php echo Labels::getLabel('LBL_You_Pay', $siteLangId); ?></td>
                    <td class="hightlighted"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal'], true, false, true, false, true); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><a href="<?php echo UrlHelper::generateUrl('SubscriptionCheckout'); ?>" class="btn btn-outline-gray ripplelink"><?php echo Labels::getLabel('LBL_Proceed_to_Pay', $siteLangId); ?> </a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>