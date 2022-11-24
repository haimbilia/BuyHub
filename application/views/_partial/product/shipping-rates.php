<ul>
    <?php
    if (!empty($product['product_warranty'])) { ?>
        <?php
        $warrantTypes = Product::getWarrantyUnits($siteLangId);        
        $lbl = Labels::getLabel('LBL_{UNIT}_{UNIT-NAME}_WARRANTY', $siteLangId);
        unset($warrantTypes[$product['product_warranty_unit']]);
        $replace = [
            '{UNIT}' => $product['product_warranty'],
            '{UNIT-NAME}' => (isset($product['product_warranty_unit']) && array_key_exists($product['product_warranty_unit'], $warrantTypes) ) ? $warrantTypes[$product['product_warranty_unit']] : ''
        ];
        ?>
        <li title="<?php echo CommonHelper::replaceStringData($lbl, $replace); ?>">
            <?php echo CommonHelper::replaceStringData($lbl, $replace); ?>
        </li>
    <?php } ?>

    <?php
    $returnAge = '' != $product['selprod_return_age'] ? $product['selprod_return_age'] : $product['shop_return_age'];
    if (!empty($product['shop_return_age']) && 0 < $returnAge) {
        $lbl = Labels::getLabel('LBL_{DAYS}_DAYS_RETURN_BACK_POLICY', $siteLangId);
    ?>
        <li title="<?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $returnAge]); ?>">
            <?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $returnAge]); ?>
        </li>
    <?php }
    $cancellationAge = '' != $product['selprod_cancellation_age'] ? $product['selprod_cancellation_age'] : $product['shop_cancellation_age'];
    if (Product::PRODUCT_TYPE_PHYSICAL == $product['product_type'] && 0 <  $cancellationAge) {
        $lbl = Labels::getLabel('LBL_{DAYS}_DAYS_CANCELLATION_POLICY', $siteLangId);
    ?>
        <li title="<?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $cancellationAge]); ?>">
            <?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $cancellationAge]); ?>
        </li>
    <?php } ?>

    <?php if ($codEnabled && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']) { ?>
        <?php $lbl = Labels::getLabel('LBL_Cash_on_delivery_is_available', $siteLangId); ?>
        <li title="<?php echo $lbl; ?>">
            <?php echo Labels::getLabel('LBL_Cash_on_delivery_is_available', $siteLangId); ?>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" data-container="body" title="<?php echo Labels::getLabel('MSG_CASH_ON_DELIVERY_AVAILABLE._CHOOSE_FROM_PAYMENT_OPTIONS', $siteLangId); ?>">
            </i>
        </li>
    <?php } ?>

    <?php if (Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']) { ?>
        <?php
        switch ($fulfillmentType) {
            case Shipping::FULFILMENT_SHIP:
                $lbl = Labels::getLabel('LBL_SHIPPED_ONLY', $siteLangId);
                break;
            case Shipping::FULFILMENT_PICKUP:
                $lbl = Labels::getLabel('LBL_PICKUP_ONLY', $siteLangId);
                break;
            default:
                $lbl = Labels::getLabel('LBL_SHIPPMENT_AND_PICKUP', $siteLangId);
                break;
        }
        ?>
        <li title="<?php echo $lbl; ?>">
            <?php $icon = $fulfillmentType == Shipping::FULFILMENT_PICKUP ? 'item_pickup' : 'freeshipping'; ?>
            <?php echo $lbl; ?>
        </li>
    <?php } ?>
</ul>