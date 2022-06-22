<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<ul class="chips">    
    <?php if ($row['collection_for_web']) { ?>
        <li class="chip buyer">
            <?php echo $applicableTypes[Collections::FOR_WEB]; ?>
        </li>
    <?php } ?>
    
    <?php if ($row['collection_for_app']) { ?>
        <li class="chip supplier">
            <?php echo $applicableTypes[Collections::FOR_APP]; ?>
        </li>
    <?php } ?>
</ul>