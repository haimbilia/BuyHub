<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0], "closeForm"); return(false);');
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ',true)');
$frm->getField('ocrequest_status')->setFieldTagAttribute('id', 'ocrequest_status');

$fld = $frm->getField('ocrequest_refund_in_wallet');
$fld->setFieldTagAttribute('id', 'ocrequest_refund_in_wallet');
$fld->setFieldTagAttribute('disabled', true);

$fld = $frm->getField('ocrequest_refund_in_wallet');
$fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
