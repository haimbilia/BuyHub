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
            <?php include CONF_VIEW_DIR_PATH . '_partial/order/timeline.php';  ?>
        </div>
    <?php } ?>
</div>