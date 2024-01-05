<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SHIPPING_CHARGES', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body p-4">
    <ul class="list-stats list-shipping">
        <?php
        if (!empty($options)) {
            foreach ($options as $id => $value) { ?>
                <li class="list-stats-item">
                    <span class="label"><?php echo $value['title'] ?></span>
                    <span class="value"><?php echo $value['price']; ?></span>
                </li>
        <?php }
        } else {
            echo Labels::getLabel('LBL_SHIPPING_CHARGED_WERE_NOT_DECLARED.');
        } ?>
    </ul>
</div>