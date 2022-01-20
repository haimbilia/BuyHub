<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('onsubmit', 'setupProfileProduct(this); return(false);');
$proFld = $frm->getField("product_name");
$proFld->developerTags['colWidthValues'] = [null, '9', null, null];
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId));
$btn = $frm->getField('btn_submit');
$btn->developerTags['colWidthValues'] = [null, '3', null, null];
$btn->addFieldTagAttribute('class', 'btn btn-brand');
?>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-solid-brand " role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i>
            </div>
            <div class="alert-text text-xs"> <?php echo Labels::getLabel("LBL_Product_will_automatically_remove_from_other_profile", $siteLangId); ?>
            </div>
        </div>
        <?php echo $frm->getFormHtml(); ?></form>
    </div>
</div>
<div id="product-listing--js"></div>