<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onSubmit', 'sellerProducts(0,1); return(false);');

$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 4;

$keyFld = $frmSearch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->developerTags['col'] = 8;
$keyFld->developerTags['noCaptionTag'] = true;


$submitBtnFld = $frmSearch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
$submitBtnFld->developerTags['col'] = 2;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmSearch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$cancelBtnFld->developerTags['col'] = 2;
$cancelBtnFld->developerTags['noCaptionTag'] = true;
$frmSearch->getField('keyword')->developerTags['noCaptionTag'] = true;

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>


<div class="content-wrapper content-space">
    <?php
    $title = Labels::getLabel('LBL_My_Inventory', $siteLangId);
    $data = [
        'headingLabel' => $title . '<i class="fa fa-question-circle" onClick="productInstructions(' .  Extrapage::SELLER_INVENTORY_INSTRUCTIONS . ')"></i>',
        'siteLangId' => $siteLangId,
        'controllerName' => $controllerName,
        'action' => $action,
        'canEdit' => $canEdit,
        'adminCatalogs' => $adminCatalogs,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-form">
                    <div class="card-head">
                        <div class="card-head-label">
                            <?php echo $frmSearch->getFormHtml(); ?>
                        </div>
                        <div class="card-toolbar">
                            <ul>
                                <li>
                                    <a class="btn btn-icon formActionBtn-js disabled" title="<?php echo Labels::getLabel('LBL_Activate', $siteLangId); ?>" onclick="toggleBulkStatues(1)" href="javascript:void(0)">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#active">
                                            </use>
                                        </svg>

                                    </a>
                                </li>
                                <li>
                                    <a class="btn btn-icon formActionBtn-js disabled" title="<?php echo Labels::getLabel('LBL_Deactivate', $siteLangId); ?>" onclick="toggleBulkStatues(0)" href="javascript:void(0)">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#in-active">
                                            </use>
                                        </svg>

                                    </a>
                                </li>
                                <li>
                                    <a class="btn btn-icon formActionBtn-js disabled" title="<?php echo Labels::getLabel('LBL_Delete', $siteLangId); ?>" onclick="deleteBulkSellerProducts()" href="javascript:void(0)">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#delete">
                                            </use>
                                        </svg>

                                    </a>
                                </li>
                            </ul>
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