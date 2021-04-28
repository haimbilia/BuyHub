<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="popup__body">
    <?php 
    $data['popup'] = true;
    $this->includeTemplate('guest-user/loginPageTemplate.php', $data, false); ?>
</div>