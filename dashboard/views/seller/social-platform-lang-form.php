<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
$langFrm->setFormTagAttribute('data-onclear', "addLangForm(" . $splatform_id . ", " . $langId . ");");

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addLangForm(" . $splatform_id . ", this.value);");

HtmlHelper::attachTransalateIcon($langFld,$langId,'addLangForm(' . $splatform_id . ', ' . $langId . ', 1)');

?>
<div class="col-md-12">
    <?php echo $langFrm->getFormHtml(); ?>
</div>