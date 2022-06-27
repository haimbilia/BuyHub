<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frmSearch->getField('abandonedcart_user_id');
$fld->setfieldTagAttribute('id', 'searchFrmUserIdJs');

$fld = $frmSearch->getField('abandonedcart_selprod_id');
$fld->setfieldTagAttribute('id', 'searchFrmSellerProductJs');

include(CONF_THEME_PATH . '_partial/listing/index.php'); ?>

<script type="text/javascript">
    var DISCOUNT_IN_PERCENTAGE = '<?php echo applicationConstants::PERCENTAGE; ?>';
    var DISCOUNT_IN_FLAT = '<?php echo applicationConstants::FLAT; ?>';
    var PRODUCT_DISCOUNT = '<?php echo DiscountCoupons::TYPE_DISCOUNT; ?>';
    
</script>