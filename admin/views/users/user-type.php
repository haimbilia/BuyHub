<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="chips">    
    <?php if ($row['user_is_buyer']) { ?>
        <li class="chip buyer">
            <?php echo Labels::getLabel('LBL_BUYER', $siteLangId); ?>
        </li>
    <?php } ?>
    
    <?php if ($row['user_is_supplier']) { ?>
        <li class="chip supplier">
            <?php echo Labels::getLabel('LBL_SUPPLIER', $siteLangId); ?>
        </li>
    <?php } ?>
    
    <?php if ($row['user_is_advertiser']) { ?>
        <li class="chip advertiser">
            <?php echo Labels::getLabel('LBL_ADVERTISER', $siteLangId); ?>
        </li>
    <?php } ?>
    
    <?php if ($row['user_is_affiliate']) { ?>
        <li class="chip affiliate">
            <?php echo Labels::getLabel('LBL_AFFILIATE', $siteLangId); ?>
        </li>
    <?php } ?>
</ul>