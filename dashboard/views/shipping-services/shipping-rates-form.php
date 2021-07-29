<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'setUpShippingRate(this); return(false);');

$fld = $frm->getField('btn_submit');
$fld->developerTags['noCaptionTag'] = true;
$fld->setFieldTagAttribute('class', 'btn btn-brand');
?>

<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_SHIPPING_RATES', $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <?php echo $frm->getFormHtml(); ?>
</div>