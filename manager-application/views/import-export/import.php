<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <div class="settings">
        <?php foreach ($options as $key => $val) { ?>
        <a class="setting" href="javascript:void(0)"
            onclick="getImportInstructions(<?php echo $key; ?>); return false;">
            <div class="setting__icon">
                <span class="icon">
                    <svg class="icon" width="40" height="40">
                        <use
                            xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-settings.svg#general-settings">
                        </use>
                    </svg>
                </span>
            </div>
            <div class="setting__detail">
                <h6><?php echo $val; ?></h6>
                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            </div>
        </a>
        <?php } ?>
    </div>
</div>