<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main">
    <div class="content-wrapper content-space">
        <?php 
        $title = ($type == 1) ? Labels::getLabel('LBL_Seller_Products', $siteLangId) : Labels::getLabel('LBL_Marketplace_Products', $siteLangId);
        $data = [
            'headingLabel' => $title . '<i class="fa fa-question-circle" onClick="productInstructions(' . Extrapage::MARKETPLACE_PRODUCT_INSTRUCTIONS . ')"></i>',
            'siteLangId' => $siteLangId,
            'controllerName' => $controllerName,
            'action' => $action,
            'canEdit' => $canEdit,
            'type' => $type,
        ];
        $this->includeTemplate('_partial/header/content-header.php', $data, false); ?>

        <div class="content-body">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card card-search">
                        <div class="card-body">
                            <div class="replaced">
                                <?php
                                $frmSearchCatalogProduct->setFormTagAttribute('id', 'frmSearchCatalogProduct');
                                $frmSearchCatalogProduct->setFormTagAttribute('class', 'form');
                                $frmSearchCatalogProduct->setFormTagAttribute('onsubmit', 'searchCatalogProducts(this); return(false);');
                                $frmSearchCatalogProduct->getField('keyword')->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_by_keyword/EAN/ISBN/UPC_code', $siteLangId));
                                $frmSearchCatalogProduct->developerTags['colClassPrefix'] = 'col-md-';
                                $frmSearchCatalogProduct->developerTags['fld_default_col'] = 12;

                                $keywordFld = $frmSearchCatalogProduct->getField('keyword');
                                $keywordFld->setFieldTagAttribute('id', 'tour-step-3');                    
                                $keywordFld->developerTags['col'] = 4;
                                $keywordFld->developerTags['noCaptionTag'] = true;

                                // if (FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT')) {
                                // $dateFromFld = $frmSearchCatalogProduct->getField('type');
                                // $dateFromFld->setFieldTagAttribute('class', '');
                                // $dateFromFld->setWrapperAttribute('class', 'col-lg-2');
                                // $dateFromFld->developerTags['col'] = 2;
                                // }
                                $typeFld = $frmSearchCatalogProduct->getField('product_type');                               
                                $typeFld->developerTags['col'] = 4;
                                $typeFld->developerTags['noCaptionTag'] = true;

                                $submitFld = $frmSearchCatalogProduct->getField('btn_submit');
                                $submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
                                $submitFld->developerTags['col'] = 2;
                                $submitFld->developerTags['noCaptionTag'] = true;

                                $fldClear = $frmSearchCatalogProduct->getField('btn_clear');
                                $fldClear->setFieldTagAttribute('onclick', 'clearSearch()');
                                $fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
                                $fldClear->developerTags['col'] = 2;
                                $fldClear->developerTags['noCaptionTag'] = true;
                                /* if( User::canAddCustomProductAvailableToAllSellers() ){
                                      $submitFld = $frmSearchCatalogProduct->getField('btn_submit');
                                      $submitFld->setFieldTagAttribute('class','btn-block');
                                      $submitFld->developerTags['col'] = 4;
                                    } */
                                echo $frmSearchCatalogProduct->getFormHtml(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="listing"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        searchCatalogProducts(document.frmSearchCatalogProduct);
    });

    $(".btn-inline-js").click(function() {
        $(".box-slide-js").slideToggle();
    });

    var TYPE_BADGE = <?php echo Badge::TYPE_BADGE; ?>;
	var TYPE_RIBBON = <?php echo Badge::TYPE_RIBBON; ?>;

    var RECORD_TYPE_PRODUCT = <?php echo BadgeLinkCondition::RECORD_TYPE_PRODUCT; ?>;
</script>