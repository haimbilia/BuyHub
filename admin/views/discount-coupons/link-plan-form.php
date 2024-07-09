<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('plan_name');
$fld->addFieldTagAttribute('class', 'tagifyJs');
$fld->addFieldTagAttribute('data-record-id', $recordId);
$frm->addHtml('','','<a href="'.UrlHelper::generateUrl('DiscountCoupons', 'links', [$recordId]).'">'.Labels::getlabel('LBL_CLICK_TO_LINK_SELLERS').'</a>');
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    $(document).ready(function() {
        bindTagify();
    });
</script>