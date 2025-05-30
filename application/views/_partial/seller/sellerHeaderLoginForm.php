<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php
$onSubmitFunctionName = isset($onSubmitFunctionName) ? $onSubmitFunctionName : 'defaultSetUpLogin';
$loginFrm->setFormTagAttribute('class', 'form seller-login');
$loginFrm->setValidatorJsObjectName('loginValObj');
$loginFrm->setFormTagAttribute('action', UrlHelper::generateUrl('GuestUser', 'login'));
$loginFrm->setFormTagAttribute('onsubmit', $onSubmitFunctionName . '(this, loginValObj); return(false);');
$loginFrm->developerTags['colClassPrefix'] = 'col-lg-4  col-sm-';
$loginFrm->developerTags['fld_default_col'] = 4;
$loginFrm->removeField($loginFrm->getField('remember_me'));
$loginFrm->addHtml('', 'forgotPassword', '<a class="link forgot" href="' . UrlHelper::generateUrl('GuestUser', 'forgotPasswordForm') . '">' . Labels::getLabel('LBL_Forgot_Password?', $siteLangId) . '</a>');
$fldSubmit = $loginFrm->getField('btn_submit');
$fldSubmit->setFieldTagAttribute('class', 'btn btn-brand btn-wide');
echo $loginFrm->getFormTag();
?>
<?php

$usernameFld = $loginFrm->getField('username');
$usernameFld->setFieldTagAttribute('class', 'no--focus');

$passwordFld = $loginFrm->getField('password');
$passwordFld->setFieldTagAttribute('class', 'no--focus');

?>

<div class="form-group"> <?php echo $loginFrm->getFieldHtml('username'); ?> </div>
<div class="form-group"> <?php echo $loginFrm->getFieldHtml('password') ?> </div>
<div class="form-group"> <?php echo $loginFrm->getFieldHtml('btn_submit'); ?> </div>
<div> <?php echo $loginFrm->getFieldHtml('forgotPassword'); ?> </div>
<?php echo $loginFrm->getExternalJs();  ?>
</form>