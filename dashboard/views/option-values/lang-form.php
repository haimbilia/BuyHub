<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('data-onclear', "langForm(" . $optionvalue_id . ", " . $langId . ");");
$langFrm->setFormTagAttribute('onsubmit', 'langSetup(this); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "langForm(" . $optionvalue_id . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $langId ,'langForm(' . $optionvalue_id . ', ' . $langId . ', 1)');
?>
<div class="col-md-12">
    <?php echo $langFrm->getFormHtml(); ?>
</div>