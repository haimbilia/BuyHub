<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SHIPPING_DETAIL', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="js-scrollable table-wrap table-responsive">
            <table class="table table-justified">
                <thead>
                    <tr>
                        <th>#</td>
                        <th><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></th>
                        <th><?php echo Labels::getLabel('LBL_Shipping_Detail', $siteLangId); ?></th>
                        <th><?php echo Labels::getLabel('LBL_Shipping', $siteLangId); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $k = 1;
                    $totalShipping = 0;
                    foreach ($opsShippingDetail as $op) {
                        $shippingCost = CommonHelper::orderProductAmount($op, 'SHIPPING');
                        $totalShipping += $shippingCost;
                        $opId = FatUtility::int($op['op_id']);
                        $prodOrBatchUrl = 'javascript:void(0)';
                        if ($op['op_is_batch']) {
                            $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'batch', array($op['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                            $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($op['op_selprod_id'], $siteLangId, ImageDimension::VIEW_SMALL), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                        } else {
                            if (Product::verifyProductIsValid($op['op_selprod_id']) == true) {
                                $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'view', array($op['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                            }
                            $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($op['selprod_product_id'], ImageDimension::VIEW_SMALL, $op['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                        }
                        $orderProd = $op;
                        $orderProd['order_id'] = $op['op_order_id'];
                        $orderProd['order_number'] = $op['op_invoice_number'];
                        unset($orderProd['totOrders']);
                    ?>
                        <tr>
                            <td><?php echo $k; ?></td>
                            <td>
                                <?php $this->includeTemplate('_partial/product/product-info-html.php', $this->variables + ['order' => $orderProd], false); ?>
                            </td>
                            <td>
                                <strong>
                                    <?php echo Labels::getLabel('LBL_Shipping_Class', $siteLangId); ?>:
                                </strong>
                                <?php echo CommonHelper::displayNotApplicable($siteLangId, $op["opshipping_label"]); ?>
                                <br>
                                <?php if (!empty($op["opshipping_service_code"])) { ?>
                                    <strong>
                                        <?php echo Labels::getLabel('LBL_SHIPPING_SERVICES:', $siteLangId); ?>
                                    </strong>
                                <?php echo CommonHelper::displayNotApplicable($siteLangId, $op["opshipping_service_code"]);
                                } ?>
                            </td>
                            <td>
                                <?php echo CommonHelper::displayMoneyFormat($shippingCost, true, true); ?>
                            </td>
                        </tr>
                    <?php $k++;
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo Labels::getLabel('LBL_TOTAL_SHIPPING', $siteLangId); ?></td>
                        <td><?php echo CommonHelper::displayMoneyFormat($totalShipping, true, true); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>