<?php  defined('SYSTEM_INIT') or die('Invalid Usage.'); 
require_once(CONF_THEME_PATH . '_partial/listing/index.php'); ?>

<script>
    var PROMOTION_TYPE_BANNER = <?php echo Promotion::TYPE_BANNER; ?>;
    var PROMOTION_TYPE_SHOP = <?php echo Promotion::TYPE_SHOP; ?>;
    var PROMOTION_TYPE_PRODUCT = <?php echo Promotion::TYPE_PRODUCT; ?>;
    var PROMOTION_TYPE_SLIDES = <?php echo Promotion::TYPE_SLIDES; ?>;
</script>