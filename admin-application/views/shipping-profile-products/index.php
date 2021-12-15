<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$frm->setFormTagAttribute('class', 'web_form form_vertical');
$frm->setFormTagAttribute('onsubmit', 'setupProfileProduct(this); return(false);');
$frm->developerTags['fld_default_col'] = 6;
$proFld = $frm->getField("product_name");
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $adminLangId));
?>
<div class="card-head">
    <div class="card-head-label">
        <h3 class="card-head-title"><?php echo Labels::getLabel('LBL_Products', $adminLangId); ?></h3>
    </div>
    <div class="card-head-toolbar">
        <div class="card-head-actions"></div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-solid-brand " role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i>
                </div>
                <div class="alert-text text-xs"> <?php echo Labels::getLabel("LBL_Product_will_automatically_remove_from_other_profile", $adminLangId); ?>
                </div>
            </div>

            <?php echo $frm->getFormHtml(); ?></form>
        </div>
    </div>
    <div id="product-listing--js"></div>
</div>