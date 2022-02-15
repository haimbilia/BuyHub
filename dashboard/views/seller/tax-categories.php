<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
/* $frmSearch->setFormTagAttribute('id', 'frmSearchTaxCat');
    $frmSearch->setFormTagAttribute('onsubmit', 'searchTaxCategories(this); return(false);');

    $frmSearch->setFormTagAttribute('class', 'form');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 12;
    $frmSearch->developerTags['noCaptionTag'] = true;

    $keyFld = $frmSearch->getField('keyword');
    $keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId)); 
    $keyFld->developerTags['col'] = 8;
    $keyFld->developerTags['noCaptionTag'] = true;

    $submitBtnFld = $frmSearch->getField('btn_submit');
    $submitBtnFld->setFieldTagAttribute('class', 'btn-block');
    $submitBtnFld->developerTags['col'] = 2;
    $submitBtnFld->developerTags['noCaptionTag'] = true;

    $cancelBtnFld = $frmSearch->getField('btn_clear');
    $cancelBtnFld->setFieldTagAttribute('class', 'btn-block');  
    $cancelBtnFld->developerTags['col'] = 2;
    $cancelBtnFld->developerTags['noCaptionTag'] = true; */
?>

<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>

<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_Tax_Categories', $siteLangId),
        'siteLangId' => $siteLangId
    ];
    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
                    <div class="card-body">
                        <div id="listing"><?php echo Labels::getLabel('LBL_Loading..', $siteLangId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>