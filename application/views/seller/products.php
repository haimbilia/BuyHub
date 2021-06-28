<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$frmSearch->setFormTagAttribute('onSubmit', 'sellerProducts(0,1); return(false);');

$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 4;

$keyFld = $frmSearch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));

$submitBtnFld = $frmSearch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
$submitBtnFld->developerTags['col'] = 2;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmSearch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$cancelBtnFld->developerTags['col'] = 2;
$cancelBtnFld->developerTags['noCaptionTag'] = true;

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<main id="main-area" class="main"   >
    <div class="content-wrapper content-space">
        <div class="content-header row justify-content-between mb-3">
            <div class="col-md-auto">
                <h2 class="content-header-title"><?php echo Labels::getLabel('LBL_My_Inventory', $siteLangId); ?><i class="fa fa-question-circle" onClick="productInstructions(<?php echo Extrapage::SELLER_INVENTORY_INSTRUCTIONS; ?>)"></i></h2>
            </div>
            <?php $this->includeTemplate('_partial/productPagesTabs.php', array('siteLangId' => $siteLangId, 'controllerName' => $controllerName, 'action' => $action, 'canEdit' => $canEdit, 'adminCatalogs' => $adminCatalogs), false); ?>
        </div>
        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="replaced">
                                <?php echo $frmSearch->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"></div>
                            <div class="btn-group">
                                <a class="btn btn-outline-brand btn-sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Activate', $siteLangId); ?>" onclick="toggleBulkStatues(1)" href="javascript:void(0)">
                                    <?php echo Labels::getLabel('LBL_Activate', $siteLangId); ?>
                                </a>
                                <a class="btn btn-outline-brand btn-sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Deactivate', $siteLangId); ?>" onclick="toggleBulkStatues(0)" href="javascript:void(0)">
                                    <?php echo Labels::getLabel('LBL_Deactivate', $siteLangId); ?>
                                </a>
                                <a class="btn btn-outline-brand btn-sm formActionBtn-js formActions-css" title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>" onclick="deleteBulkSellerProducts()" href="javascript:void(0)">
                                    <?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>
                                </a>
                            </div>
                        </div>
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
</main>
<?php echo FatUtility::createHiddenFormFromData(array('product_id' => $product_id), array('name' => 'frmSearchSellerProducts')); ?>
<script>
    jQuery(document).ready(function($) {
        $(".initTooltip").click(function() {
            $.facebox({
                div: '#inventoryToolTip'
            }, 'catalog-bg');
        });
    });
    var TYPE_BADGE = <?php echo Badge::TYPE_BADGE; ?>;
	var TYPE_RIBBON = <?php echo Badge::TYPE_RIBBON; ?>;

    var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT; ?>;
</script>