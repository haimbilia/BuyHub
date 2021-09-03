<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$listingLabel = Labels::getLabel('LBL_RECORDS', $adminLangId);

$headingLabel = $badgeName . ' ' . Labels::getLabel('LBL_CONDITION', $adminLangId);
$listingLabel = $badgeName . ' ' . Labels::getLabel('LBL_LINKED_RECORDS', $adminLangId);

$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => false,
    'statusButtons' => false,
];

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onsubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'web_form formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 6;

    $btn = $frmSearch->getField('btn_clear');
    if (null != $btn) {
        $btn->setFieldTagAttribute('onClick', 'clearSearch()');
    }
}

require_once(CONF_THEME_PATH . '_partial/index-page-common.php'); ?>

<script>
    var RIGHT = <?php echo Badge::RIBB_POS_TRIGHT; ?>;
    var LEFT = <?php echo Badge::RIBB_POS_TLEFT; ?>;

    var TYPE_BADGE = <?php echo Badge::TYPE_BADGE; ?>;
    var TYPE_RIBBON = <?php echo Badge::TYPE_RIBBON; ?>;
	
    var REC_COND_AUTO = <?php echo BadgeLinkCondition::REC_COND_AUTO; ?>;
	var REC_COND_MANUAL = <?php echo BadgeLinkCondition::REC_COND_MANUAL; ?>;

	var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
	var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
	var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;

    // var COND_TYPE_AVG_RATING_SELPROD = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SELPROD; ?>; 
    var COND_TYPE_AVG_RATING_SHOP = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP; ?>; 
    var COND_TYPE_ORDER_COMPLETION_RATE = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE; ?>; 
    var COND_TYPE_COMPLETED_ORDERS = <?php echo BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS; ?>; 
    var COND_TYPE_RETURN_ACCEPTANCE = <?php echo BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE; ?>; 
    var COND_TYPE_ORDER_CANCELLED = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED; ?>; 

    var badgeType = "<?php echo $badgeType; ?>";
    var badgeId = "<?php echo $badgeId; ?>";
    var blinkcond_id = "<?php echo $badgeLinkCondId; ?>";
</script>