<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$listingLabel = Labels::getLabel('LBL_RECORDS', $siteLangId);

$headingLabel = $badgeName . ' ' . Labels::getLabel('LBL_CONDITION_SETUP_FORM', $siteLangId);
$listingLabel = $badgeName . ' ' . Labels::getLabel('LBL_LINKED_RECORDS', $siteLangId);

$otherButtons = [
    'onclick' => 'backToListing();',
    'title' => Labels::getLabel('LBL_BACK', $siteLangId),
    'label' => '<i class="fas fa-arrow-left"></i>',
];

$data = [
    'siteLangId' => $siteLangId,
    'deleteButton' => false,
    'statusButtons' => false,
];

if (!empty($frmSearch)) {
    $frmSearch->setFormTagAttribute('onSubmit', 'searchRecords(this); return(false);');
    $frmSearch->setFormTagAttribute('class', 'form form--horizontal formSearch--js');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 6;

    $fld = $frmSearch->getField('btn_submit');
    if (null != $fld) {
        $fld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
        $fld->developerTags['col'] = 3;
    }

    $fld = $frmSearch->getField('btn_clear');
    if (null != $fld) {
        $fld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
        $fld->setFieldTagAttribute('onClick', 'clearSearch()');
        $fld->developerTags['col'] = 3;
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

    var COND_TYPE_DATE = <?php echo BadgeLinkCondition::COND_TYPE_DATE; ?>;
    var COND_TYPE_AVG_RATING_SELPROD = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SELPROD; ?>;
    var COND_TYPE_AVG_RATING_SHOP = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP; ?>;
    var COND_TYPE_ORDER_COMPLETION_RATE = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE; ?>;
    var COND_TYPE_COMPLETED_ORDERS = <?php echo BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS; ?>;
    var COND_TYPE_RETURN_ACCEPTANCE = <?php echo BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE; ?>;
    var COND_TYPE_ORDER_CANCELLED = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED; ?>;

    var badgeType = "<?php echo $badgeType; ?>";
    var badgeId = "<?php echo $badgeId; ?>";
    var blinkcond_id = "<?php echo $badgeLinkCondId; ?>";
</script>