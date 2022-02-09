<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->setFormTagAttribute('onsubmit', 'searchSeoProducts(this); return(false);');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 4;

$keywordFld = $frmSearch->getField('keyword');
$keywordFld->setWrapperAttribute('class', 'col-lg-4');
$keywordFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product', $siteLangId));
$keywordFld->developerTags['col'] = 4;
$keywordFld->developerTags['noCaptionTag'] = true;

$this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Meta_Tags', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data, false);
    ?>
    <div class="content-body">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card card-search">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card" id="listing">
                    <?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div id="dvForm"></div>
                        <div class="alert-aligned" id="dvAlert">
                            <div class="cards-message">
                                <div class="cards-message-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="cards-message-text"><?php echo Labels::getLabel('LBL_Select_a_product_to_add_/_edit_meta_tags_data', $siteLangId); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>