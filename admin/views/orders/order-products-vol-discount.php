<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opVolDiscountJs">
    <div class="table-responsive table-scrollable js-scrollable">
        <table class="table table-orders">
            <thead>
                <tr>
                    <th><?php echo Labels::getLabel('LBL_PRODUCT', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalVolDiscount = 0;
                foreach ($opsShippingDetail as $op) {
                    $volDiscount = CommonHelper::orderProductAmount($op, 'VOLUME_DISCOUNT');
                    $totalVolDiscount += $volDiscount;
                ?>
                    <tr>
                        <td>
                            <?php $this->includeTemplate('_partial/product/order-product-info-card.php', ['order' => $op, 'siteLangId' => $siteLangId, 'horizontalAlignOptions' => 'list-options--horizontal'], false); ?>
                        </td>
                        <td>
                            <?php echo CommonHelper::displayMoneyFormat($volDiscount, true, true); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><?php echo Labels::getLabel('LBL_TOTAL_VOLUME_DISCOUNT', $siteLangId); ?></td>
                    <td><?php echo CommonHelper::displayMoneyFormat($totalVolDiscount, true, true); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>