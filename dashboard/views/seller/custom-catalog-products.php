<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearchCustomCatalogProducts->setFormTagAttribute('onSubmit', 'searchCustomCatalogProducts(this); return(false);');

$frmSearchCustomCatalogProducts->setFormTagAttribute('class', 'form');
$frmSearchCustomCatalogProducts->developerTags['colClassPrefix'] = 'col-md-';
$frmSearchCustomCatalogProducts->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearchCustomCatalogProducts->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class', 'col-lg-6');
$keyFld->developerTags['col'] = 6;
$keyFld->developerTags['noCaptionTag'] = true;

$submitBtnFld = $frmSearchCustomCatalogProducts->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn-block');
$submitBtnFld->setWrapperAttribute('class', 'col-lg-3');
$submitBtnFld->developerTags['col'] = 3;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmSearchCustomCatalogProducts->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn-block');
$cancelBtnFld->setWrapperAttribute('class', 'col-lg-3');
$cancelBtnFld->developerTags['col'] = 3;
$cancelBtnFld->developerTags['noCaptionTag'] = true;
?>
<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $title = Labels::getLabel('LBL_Products_Request', $siteLangId);
    $data = [
        'headingLabel' => $title . '<i class="fa fa-question-circle" onclick="productInstructions(' .  Extrapage::PRODUCT_REQUEST_INSTRUCTIONS . ')"></i>',
        'siteLangId' => $siteLangId,
        'controllerName' => $controllerName,
        'action' => $action,
        'canEdit' => $canEdit,
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>
    <div class="content-body">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $submitFld = $frmSearchCustomCatalogProducts->getField('btn_submit');
                                $submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');

                                $fldClear = $frmSearchCustomCatalogProducts->getField('btn_clear');
                                $fldClear->setFieldTagAttribute('class', 'btn btn-outline-gray btn-block');

                                echo $frmSearchCustomCatalogProducts->getFormHtml();
                                ?>
                                <?php echo $frmSearchCustomCatalogProducts->getExternalJS(); ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
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

<script>
    jQuery(document).ready(function($) {
        $(".initTooltip").click(function() {
            $.ykmodal({
                div: '#requestedProductsToolTip'
            }, 'catalog-bg');
        });
    });
</script>