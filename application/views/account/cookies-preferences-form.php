<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'setCookiesPreferences(this); return(false);');
//$frm->setFormTagAttribute('id', 'bankInfoFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;

$fld = $frm->getField('ucp_functional');
$fld->setFieldTagAttribute('disabled', "disabled");

$fld = $frm->getField('btn_submit');
$fld->developerTags['col'] = 12;
$fld->setFieldTagAttribute('class', "btn btn-brand");
?>
<div class="row">
    <div class="col-md-8">
        <?php echo $frm->getFormHtml();?>
    </div>
</div>
