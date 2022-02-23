<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="list-stats list-stats-double">
    <li class="list-stats-item">
        <span class="lable"><?php echo Labels::getLabel('LBL_LENGTH', $siteLangId); ?></span>
        <span class="value"><?php echo $orderDetail['op_product_length'] . ' ' . $unitType; ?></span>
    </li>
    <li class="list-stats-item">
        <span class="lable"><?php echo Labels::getLabel('LBL_WIDTH', $siteLangId); ?></span>
        <span class="value"><?php echo $orderDetail['op_product_width'] . ' ' . $unitType; ?></span>
    </li>
    <li class="list-stats-item">
        <span class="lable"><?php echo Labels::getLabel('LBL_HEIGHT', $siteLangId); ?></span>
        <span class="value"><?php echo $orderDetail['op_product_height'] . ' ' . $unitType; ?></span>
    </li>
</ul>