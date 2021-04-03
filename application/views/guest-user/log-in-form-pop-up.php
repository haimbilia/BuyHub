<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="popup__body">
    <?php 
    $data['formClass'] = 'loginpopup--js';
    $this->includeTemplate('guest-user/loginFormTemplate.php', $data, false); ?>
</div>