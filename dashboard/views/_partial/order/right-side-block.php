<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$primaryOrder = isset($primaryOrder) ? $primaryOrder : true;
?>
<div class="col-md-8">
    <div class="table-wrap">
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
                foreach ($arr as $childOrder) { ?>
                    <tr>
                        <td>
                            <?php $this->includeTemplate('_partial/product/product-info-html.php', $this->variables + ['order' => $childOrder], false); ?>
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
            <?php $this->includeTemplate('_partial/order/timeline.php', $this->variables, false); ?>
        </div>
    <?php } ?>
</div>