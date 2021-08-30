<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="content-header">
    <div class="content-header-title"> 
        <?php $this->includeTemplate('_partial/dashboardTop.php');
        
        if (isset($headingLabel)) { ?>
                <h2><?php echo $headingLabel; ?></h2>
        <?php } ?>
    </div>
    <?php $this->includeTemplate('_partial/header/content-header-buttons.php', $this->variables, false); ?>
</div>