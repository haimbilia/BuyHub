<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'return validateOtp(this);');
include(CONF_THEME_PATH . 'guest-user/otp-form.php');