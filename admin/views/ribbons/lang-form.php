<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $langFrm->getField('badge_name');
$fld->addFieldTagAttribute('maxlength', Badge::RIBB_TEXT_MAX_LEN);

require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');