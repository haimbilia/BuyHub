<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->getField('ocrequest_status')->setFieldTagAttribute('id','ocrequest_status');

$fld = $frm->getField('ocrequest_refund_in_wallet');
$fld->setFieldTagAttribute('id','ocrequest_refund_in_wallet');
$fld->setFieldTagAttribute('disabled',true);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');