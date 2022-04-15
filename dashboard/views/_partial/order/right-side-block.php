<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$primaryOrder = isset($primaryOrder) ? $primaryOrder : true;
?>
<div class="col-md-8">
    <div class="card">
        <div class="card-head">
            <h5 class="card-title">
                <div class="order-number">
                    <small class="sm-txt"><?php echo Labels::getLabel('LBL_ORDER_#', $siteLangId); ?></small>
                    <span class="numbers">
                        <?php echo (true == $primaryOrder) ? $childOrderDetail['op_invoice_number'] : $orderDetail['order_number']; ?>
                        <?php
                        if (true == $primaryOrder && FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS") == $childOrderDetail['orderstatus_id']) {
                            $statusName = isset($childOrderDetail['orderstatus_name']) ? $childOrderDetail['orderstatus_name'] : $childOrderDetail['orderstatus_identifier']; ?>
                            <span class="badge badge-danger ms-2">
                                <?php echo $statusName; ?>
                            </span>
                        <?php } ?>
                    </span>
                </div>
            </h5>
            <div class="btn-group orders-actions">
                <a href="javascript:void(0)" onclick="return addItemsToCart('<?php echo $orderDetail['order_id']; ?>');" class="btn btn-brand btn-sm"><?php echo Labels::getLabel('LBL_Buy_Again', $siteLangId); ?></a>
                <a href="<?php echo (0 < $opId) ? UrlHelper::generateUrl('Account', 'viewBuyerOrderInvoice', [$orderDetail['order_id'], $opId]) : UrlHelper::generateUrl('Account', 'viewBuyerOrderInvoice', [$orderDetail['order_id']]); ?>" class="btn btn-outline-gray btn-sm" title="<?php echo Labels::getLabel('LBL_PRINT_BUYER_INVOICE', $siteLangId); ?>"><?php echo Labels::getLabel('LBL_INVOICE', $siteLangId); ?></a>
            </div>
        </div>
        <div class="card-table">
            <div class="table-wrap">
                <table class="table table-justified table-orders">
                    <thead>
                        <tr>
                            <th><?php echo Labels::getLabel('LBL_ITEMS_SUMMARY', $siteLangId); ?></th>
                            <th><?php echo Labels::getLabel('LBL_Price', $siteLangId); ?></th>
                            <th><?php echo Labels::getLabel('LBL_ORDERED_QUANTITY', $siteLangId); ?></th>
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
                                <td><?php echo $childOrder['op_qty']; ?></td>
                                <td><?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder), true, false, true, false, true); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    if (true == $primaryOrder) { ?>
        <div class="card">
            <div class="card-head">
                <h5 class="card-title"><?php echo Labels::getLabel('MSG_ORDER_TIMELINE', $siteLangId); ?></h5>
            </div>
            <div class="card-body">
                <div class="timelines-wrap">
                    <?php $this->includeTemplate('_partial/order/timeline.php', $this->variables, false); ?>
                </div>
            </div>
        </div>
    <?php } ?>



</div>