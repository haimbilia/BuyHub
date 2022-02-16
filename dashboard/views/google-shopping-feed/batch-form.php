<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('id', 'adsBatchForm');
$frm->setFormTagAttribute('onsubmit', 'setupBatch(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 2;

$adsbatch_name = $frm->getField('adsbatch_name');
$adsbatch_name->developerTags['col'] = 2;
$adsbatch_name->addFieldTagAttribute('placeholder', $adsbatch_name->getCaption());
$adsbatch_name->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('adsbatch_lang_id');
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('adsbatch_target_country_id');
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('adsbatch_expired_on');
$fld->addFieldTagAttribute('class', 'field--calender');
$fld->addFieldTagAttribute('placeholder', $fld->getCaption());
$fld->developerTags['noCaptionTag'] = true;

$btnFld = $frm->getField('btn_submit');
$btnFld->developerTags['noCaptionTag'] = true;
$btnFld->addFieldTagAttribute('class', 'btn btn-block btn-brand');

$btnFld = $frm->getField('btn_clear');
$btnFld->developerTags['noCaptionTag'] = true;
$btnFld->addFieldTagAttribute('class', 'btn btn-block btn-outline-brand');

$fld = $frm->getField('adsbatch_expired_on');
$fld->addFieldTagAttribute('class', 'date_js');

echo $frm->getFormHtml();
