<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="settings">
    <?php foreach ($options as $key => $val) { ?>
        <a class="setting" href="javascript:void()" onclick="getInstructions(<?php echo $key;?>)">
            <div class="setting__detail">
                <h6><?php echo $val; ?></h6>
                <span>Addons, Third party services</span>
            </div>
        </a>
    <?php } ?>
</div>