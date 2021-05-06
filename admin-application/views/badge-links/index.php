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
                'onclick' => 'bulkBadgesUnlink()',
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

	var CONDITION_TYPE_DATE = <?php echo BadgeLink::CONDITION_TYPE_DATE; ?>;
</script>