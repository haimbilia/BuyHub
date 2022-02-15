<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'prodBrand');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupProductUrl(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-lg-';
$frm->developerTags['fld_default_col'] = 12;
$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
?>
<div id="dvForm">
    <div class="card-head">
        <h5 class="card-title mb-2"><?php echo SellerProduct::getProductDisplayTitle($selprodId, $siteLangId, false); ?></h5>
    </div>
    <div class="card-body">
        <?php echo $frm->getFormHtml(); ?>
    </div>
</div>