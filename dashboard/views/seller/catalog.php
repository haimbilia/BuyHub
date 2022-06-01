<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/dashboardNavigation.php'); 
$frmSearch->setFormTagAttribute('onsubmit', 'searchCatalogProducts(this); return(false);');
$keywordPlaceholder = Labels::getLabel('LBL_Search_by_keyword/EAN/ISBN/UPC_code', $siteLangId)
?>

<div class="content-wrapper content-space">
    <?php
    $title = ($type == 1) ? Labels::getLabel('LBL_Seller_Products', $siteLangId) : Labels::getLabel('LBL_Marketplace_Products', $siteLangId);
    $data = [
        'headingLabel' => $title . '<i class="fa fa-question-circle" onclick="productInstructions(' . Extrapage::MARKETPLACE_PRODUCT_INSTRUCTIONS . ')"></i>',
        'siteLangId' => $siteLangId,
        'controllerName' => $controllerName,
        'action' => $action,
        'canEdit' => $canEdit,
        'type' => $type,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
 
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-table" id="listing">
                        <div class="container m-2"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        searchCatalogProducts(document.frmRecordSearch);
    });

    $(".btn-inline-js").click(function() {
        $(".box-slide-js").slideToggle();
    });

    var TYPE_BADGE = <?php echo Badge::TYPE_BADGE; ?>;
    var TYPE_RIBBON = <?php echo Badge::TYPE_RIBBON; ?>;

    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
</script>