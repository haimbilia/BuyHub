<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_TAX_DETAIL', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opTaxChargesJs">
    <div class="table-responsive table-scrollable js-scrollable" style="max-height: 400px;">
        <table class="table table-orders">
            <thead>
                <tr>
                    <th><?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_TAX_AMOUNT', $siteLangId); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalTax = 0;
                foreach ($opsShippingDetail as $op) {
                    $taxCost = CommonHelper::orderProductAmount($op, 'TAX');
                    $totalTax += $taxCost;
                ?>
                    <tr>
                        <td>
                            <?php $this->includeTemplate('_partial/product/order-product-info-card.php', ['order' => $op, 'siteLangId' => $siteLangId, 'horizontalAlignOptions' => 'list-options--horizontal'], false); ?>
                        </td>
                        <td>
                            <?php echo CommonHelper::displayMoneyFormat($taxCost, true, true); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class='text-right'> <strong><?php echo Labels::getLabel('LBL_TOTAL_TAX', $siteLangId); ?></strong></th>
                    <th class='text-right'><strong><?php echo CommonHelper::displayMoneyFormat($totalTax, true, true); ?></strong></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>