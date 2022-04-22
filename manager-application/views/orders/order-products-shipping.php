<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SHIPPING_DETAIL', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opShippingChargesJs">
    <div class="table-responsive table-scrollable js-scrollable" style="max-height: 400px;">
        <table class="table table-orders">
            <thead>
                <tr>
                    <th><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_SHIPPING_SERVICES', $siteLangId); ?></th>
                    <th class='text-right'><?php echo Labels::getLabel('LBL_Shipping', $siteLangId); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalShipping = 0;
                foreach ($opsShippingDetail as $op) {
                    $shippingCost = CommonHelper::orderProductAmount($op, 'SHIPPING');
                    $totalShipping += $shippingCost;
                ?>
                    <tr>
                        <td>
                            <?php $this->includeTemplate('_partial/product/order-product-info-card.php', ['order' => $op, 'siteLangId' => $siteLangId, 'horizontalAlignOptions' => 'list-options--horizontal'], false); ?>
                        </td>
                        <td>
                            <?php echo CommonHelper::displayNotApplicable($siteLangId, $op["opshipping_label"]); ?>
                            <br>
                            <?php if (!empty($op["opshipping_service_code"])) { ?>
                                <strong>
                                    <?php echo Labels::getLabel('LBL_SHIPPING_SERVICES:', $siteLangId); ?>
                                </strong>
                            <?php echo CommonHelper::displayNotApplicable($siteLangId, $op["opshipping_service_code"]);
                            } ?>
                        </td>
                        <td class='text-right'>
                            <?php echo CommonHelper::displayMoneyFormat($shippingCost, true, true); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th><?php echo Labels::getLabel('LBL_TOTAL_SHIPPING', $siteLangId); ?></th>
                    <th class='text-right'><?php echo CommonHelper::displayMoneyFormat($totalShipping, true, true); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>