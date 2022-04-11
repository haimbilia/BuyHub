<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($langFrm);

$langFrm->setFormTagAttribute('class', 'form modalFormJs');
if (CommonHelper::getLayoutDirection() != $formLayout) {
    $langFrm->addFormTagAttribute('class', "layout--" . $formLayout);
    $langFrm->setFormTagAttribute('dir', $formLayout);
}
$langFrm->setFormTagAttribute('data-onclear', "editRateLangForm(" . $zoneId . ", " . $rateId . ", " . $langId . ");");
$langFrm->setFormTagAttribute('onsubmit', 'setupLangRate(this); return(false);');


$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editRateLangForm(" . $zoneId . ", " . $rateId . ", this.value);");

$fld = $langFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}

echo $langFrm->getFormHtml();