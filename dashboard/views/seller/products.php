<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $title = Labels::getLabel('LBL_My_Inventory', $siteLangId);
    $data = [
        'headingLabel' => $title . '<i class="fa fa-question-circle" onclick="productInstructions(' .  Extrapage::SELLER_INVENTORY_INSTRUCTIONS . ')"></i>',
        'siteLangId' => $siteLangId,
        'controllerName' => $controllerName,
        'action' => $action,
        'canEdit' => $canEdit,
        'adminCatalogs' => $adminCatalogs,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-form">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div id="listing">
                            <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo FatUtility::createHiddenFormFromData(array('product_id' => $product_id), array('name' => 'frmSearchSellerProducts')); ?>
<script>
    jQuery(document).ready(function($) {
        $(".initTooltip").click(function() {
            $.ykmodal({
                div: '#inventoryToolTip'
            }, 'catalog-bg');
        });
    });
    var TYPE_BADGE = <?php echo Badge::TYPE_BADGE; ?>;
    var TYPE_RIBBON = <?php echo Badge::TYPE_RIBBON; ?>;

    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
</script>