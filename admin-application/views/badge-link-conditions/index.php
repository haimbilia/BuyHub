<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$headingLabel = Labels::getLabel('LBL_MANAGE_BADGES_&_RIBBONS_LINKS', $adminLangId);
$listingLabel = Labels::getLabel('LBL_BADGES_&_RIBBONS_LINKS_LIST', $adminLangId);
$data = [
    'adminLangId' => $adminLangId,
    'deleteButton' => false,
    'statusButtons' => false,
    'otherButtons' => [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'badgeForm(0)',
                'title' => Labels::getLabel('LBL_BIND_BADGE', $adminLangId)
            ],
            'label' => '<i class="fa fa-award"></i>'
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'ribbonForm(0)',
                'title' => Labels::getLabel('LBL_BIND_RIBBON', $adminLangId)
            ],
            'label' => '<i class="fas fa-shapes"></i>'
        ],
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'bulkBadgesUnlink(this)',
                'title' => Labels::getLabel('LBL_DELETE_SELECTED', $adminLangId)
            ],
            'label' => '<i class="fas fa-trash"></i>'
        ],
    ]
];

require_once (CONF_THEME_PATH . '_partial/index-page-common.php');
?>
<script>
	var TYPE_BADGE = <?php echo Badge::TYPE_BADGE; ?>;
	var TYPE_RIBBON = <?php echo Badge::TYPE_RIBBON; ?>;
	
    var REC_COND_AUTO = <?php echo BadgeLinkCondition::REC_COND_AUTO; ?>;
	var REC_COND_MANUAL = <?php echo BadgeLinkCondition::REC_COND_MANUAL; ?>;

	var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
	var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
	var RECORD_TYPE_SHOP = <?php echo BadgeLinkCondition::RECORD_TYPE_SHOP; ?>;

    var COND_TYPE_DATE = <?php echo BadgeLinkCondition::COND_TYPE_DATE; ?>;
    var COND_TYPE_AVG_RATING_SELPROD = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SELPROD; ?> 
    var COND_TYPE_AVG_RATING_SHOP = <?php echo BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP; ?> 
    var COND_TYPE_ORDER_COMPLETION_RATE = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE; ?> 
    var COND_TYPE_COMPLETED_ORDERS = <?php echo BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS; ?> 
    var COND_TYPE_RETURN_ACCEPTANCE = <?php echo BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE; ?> 
    var COND_TYPE_ORDER_CANCELLED = <?php echo BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED; ?> 
</script>