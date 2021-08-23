<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="list-specification">
    <ul>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_UNIT', $siteLangId); ?></span>
            <span class="value"><?php echo $unitType; ?></span>
        </li>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_LENGTH', $siteLangId); ?></span>
            <span class="value"><?php echo $orderDetail['op_product_length']; ?></span>
        </li>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_LENGTH', $siteLangId); ?></span>
            <span class="value"><?php echo $orderDetail['op_product_width']; ?></span>
        </li>
        <li>
            <span class="label"><?php echo Labels::getLabel('LBL_LENGTH', $siteLangId); ?></span>
            <span class="value"><?php echo $orderDetail['op_product_height']; ?></span>
        </li>
    </ul>
</div>