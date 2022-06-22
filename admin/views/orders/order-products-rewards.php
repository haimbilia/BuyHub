<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_REWARD_POINTS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body opRewardsJs">
    <div class="table-responsive table-scrollable js-scrollable">
        <table class="table table-orders">
            <thead>
                <tr>
                    <th><?php echo Labels::getLabel('LBL_PRODUCT', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_REWARD_POINTS', $siteLangId); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalRewards = 0;
                foreach ($opsShippingDetail as $op) {
                    $rewards = CommonHelper::orderProductAmount($op, 'REWARDPOINT');
                    $totalRewards += $rewards;
                ?>
                    <tr>
                        <td>
                            <?php $this->includeTemplate('_partial/product/order-product-info-card.php', ['order' => $op, 'siteLangId' => $siteLangId, 'horizontalAlignOptions' => 'list-options--horizontal'], false); ?>
                        </td>
                        <td>
                            <?php echo CommonHelper::displayMoneyFormat($rewards, true, true); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><?php echo Labels::getLabel('LBL_TOTAL_REWARD_POINTS', $siteLangId); ?></td>
                    <td><?php echo CommonHelper::displayMoneyFormat($totalRewards, true, true); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>