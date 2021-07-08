<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'setUpShippingRate(this); return(false);');

$fld = $frm->getField('btn_submit');
$fld->developerTags['noCaptionTag'] = true;
$fld->setFieldTagAttribute('class', 'btn btn-brand');
?>

<div class="box__head">
    <h4>
        <?php echo Labels::getLabel('LBL_SHIPPING_RATES', $siteLangId); ?>
    </h4>
</div>
<div class="box__body">
    <?php echo $frm->getFormHtml(); ?>
</div>