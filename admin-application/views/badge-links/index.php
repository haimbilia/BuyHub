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
                'onclick' => 'form(0)',
                'title' => Labels::getLabel('LBL_BIND_BADGE_OR_RIBBON', $adminLangId)
            ],
            'label' => '<i class="fas fa-plus"></i>'
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
	var RECORD_TYPE_PRODUCT = <?php echo BadgeLink::RECORD_TYPE_PRODUCT; ?>;
	var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLink::RECORD_TYPE_SELLER_PRODUCT; ?>;
	var RECORD_TYPE_SHOP = <?php echo BadgeLink::RECORD_TYPE_SHOP; ?>;

    var COND_TYPE_DATE = <?php echo BadgeLink::COND_TYPE_DATE; ?>;
    var COND_TYPE_AVG_RATING = <?php echo BadgeLink::COND_TYPE_AVG_RATING; ?> 
    var COND_TYPE_ORDER_COMPLETION_RATE = <?php echo BadgeLink::COND_TYPE_ORDER_COMPLETION_RATE; ?> 
    var COND_TYPE_COMPLETED_ORDERS = <?php echo BadgeLink::COND_TYPE_COMPLETED_ORDERS; ?> 
    var COND_TYPE_RETURN_ACCEPTANCE = <?php echo BadgeLink::COND_TYPE_RETURN_ACCEPTANCE; ?> 
    var COND_TYPE_ORDER_CANCELLED = <?php echo BadgeLink::COND_TYPE_ORDER_CANCELLED; ?> 
</script>