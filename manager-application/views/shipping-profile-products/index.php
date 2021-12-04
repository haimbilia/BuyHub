<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$frm->setFormTagAttribute('class', 'form form-edit');
$frm->setFormTagAttribute('onsubmit', 'setupProfileProduct(this); return(false);');
$frm->developerTags['fld_default_col'] = 9;
$proFld = $frm->getField("product_name");
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId));
$btn = $frm->getField('btn_submit'); 
$btn->developerTags['colWidthValues'] = [null, '3', null, null]; 
$btn->addFieldTagAttribute('class', 'btn btn-brand');
?>

 
<div class="portlet__body" >
    <div class="row">
        <div class="col-md-12">
            <h5><?php echo Labels::getLabel("LBL_Product_will_automatically_remove_from_other_profile", $siteLangId); ?></h5>
            <?php echo $frm->getFormHtml(); ?></form>
        </div>
    </div>
    <div id="product-listing--js"></div>
</div>