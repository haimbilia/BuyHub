<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_TAX_DETAIL', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-table loaderContainerJs">
        <div class="js-scrollable table-wrap table-responsive">
            <table class="table table-justified">
                <thead>
                    <tr>
                        <th>#</td>
                        <th><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></th>
                        <th><?php echo Labels::getLabel('LBL_TAX_AMOUNT', $siteLangId); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $k = 1;
                    $totalTax = 0;
                    foreach ($opsShippingDetail as $op) {
                        $taxCost = CommonHelper::orderProductAmount($op, 'TAX');
                        $totalTax += $taxCost;
                        $opId = FatUtility::int($op['op_id']);
                        $prodOrBatchUrl = 'javascript:void(0)';
                        if (Product::verifyProductIsValid($op['op_selprod_id']) == true) {
                            $prodOrBatchUrl = UrlHelper::generateUrl('Products', 'view', array($op['op_selprod_id']), CONF_WEBROOT_FRONTEND);
                        }
                        $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($op['selprod_product_id'], ImageDimension::VIEW_SMALL, $op['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');

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
                                <?php
                                if (1 < count($op['taxOptions'])) {
                                    echo '<div class="taxes">';
                                    echo '<span class="taxes-options">' . Labels::getLabel('LBL_PRODUCT_TOTAL_TAX', $siteLangId) . '</span><span class="taxes-value">' . CommonHelper::displayMoneyFormat($taxCost, true, true) . '</span>';
                                    echo "</div>";
                                }

                                $strCount = 1;
                                foreach ($op['taxOptions'] as $taxStr) {
                                    echo '<div class="taxes">';
                                    echo '<span class="taxes-options">' . $taxStr['name'] . '</span><span class="taxes-value">' . CommonHelper::displayMoneyFormat($taxStr['value'], true, true) . '</span>';
                                    echo '</div>';
                                    $strCount++;
                                } ?>
                            </td>
                        </tr>
                        <?php $k++;
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td class='text-right'>
                            <strong><?php echo Labels::getLabel('LBL_TOTAL_TAX', $siteLangId); ?></strong>
                        </td>
                        <td class='text-right'>
                            <strong><?php echo CommonHelper::displayMoneyFormat($totalTax, true, true); ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>