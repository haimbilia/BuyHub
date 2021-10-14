<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <div class="settings">
        <?php foreach ($options as $key => $val) { ?>
            <a class="setting" href="javascript:void(0)" onclick="getImportInstructions(<?php echo $key; ?>); return false;">
                <div class="setting__detail">
                    <h6><?php echo $val; ?></h6>
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
                </div>
            </a>
        <?php } ?>
    </div>
</div>