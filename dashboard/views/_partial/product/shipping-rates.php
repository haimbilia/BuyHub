<ul class="list-services">
    <?php
    if (!empty($product['product_warranty'])) { ?>
        <?php $lbl = Labels::getLabel('LBL_{DAYS}_DAYS_WARRANTY', $siteLangId); ?>
        <li data-toggle="tooltip" data-placement="top" title="<?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $product['product_warranty']]); ?>">
            <i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#yearswarranty" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#yearswarranty">
                    </use>
                </svg>
            </i>
        </li>
    <?php } ?>
    <?php if ((!empty($product['shop_return_age']) || !empty($product['selprod_return_age'])) && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']) { ?>
        <?php
        $lbl = Labels::getLabel('LBL_{DAYS}_DAYS_RETURN_BACK_POLICY', $siteLangId);
        $returnAge = !empty($product['selprod_return_age']) ? $product['selprod_return_age'] : $product['shop_return_age'];
        $returnAge = !empty($returnAge) ? $returnAge : 0;
        ?>
        <li data-toggle="tooltip" data-placement="top" title="<?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $returnAge]); ?>">
            <i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#easyreturns" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#easyreturns">
                    </use>
                </svg>
            </i>
        </li>
    <?php } ?>
    <?php if ((!empty($product['shop_cancellation_age']) || !empty($product['selprod_cancellation_age'])) && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']) { ?>
        <?php
        $lbl = Labels::getLabel('LBL_{DAYS}_DAYS_CANCELLATION_POLICY', $siteLangId);
        $cancellationAge = !empty($product['selprod_cancellation_age']) ? $product['selprod_cancellation_age'] : $product['shop_cancellation_age'];
        $cancellationAge = !empty($cancellationAge) ? $cancellationAge : 0;
        ?>
        <li data-toggle="tooltip" data-placement="top" title="<?php echo CommonHelper::replaceStringData($lbl, ['{DAYS}' => $cancellationAge]); ?>">
            <i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#easyreturns" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#easyreturns">
                    </use>
                </svg>
            </i>
        </li>
    <?php } ?>
    <?php if ($codEnabled && Product::PRODUCT_TYPE_PHYSICAL == $product['product_type']) { ?>
        <?php $lbl = Labels::getLabel('LBL_Cash_on_delivery_is_available', $siteLangId); ?>
        <li data-toggle="tooltip" data-placement="top" title="<?php echo $lbl; ?>">
            <i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#safepayments" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#safepayments">
                    </use>
                </svg>
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
        <li data-toggle="tooltip" data-placement="top" title="<?php echo $lbl; ?>">
            <?php $icon = $fulfillmentType == Shipping::FULFILMENT_PICKUP ? 'item_pickup' : 'freeshipping'; ?>
            <i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#<?php echo $icon; ?>" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#<?php echo $icon; ?>">
                    </use>
                </svg>
            </i>
        </li>
    <?php } ?>
</ul>