<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
    <div class="content-wrapper content-space">
        <?php 
            $data = [
                'headingLabel' =>  $pluginName,
                'siteLangId' => $siteLangId,         
            ];
            $this->includeTemplate('_partial/header/content-header.php', $data, false);
        ?>
        <div id="landingpage-js"></div>
    </div>
</main>