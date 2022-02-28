<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($brandReqLangFrm);
$brandReqLangFrm->setFormTagAttribute('dir', $formLayout);
$brandReqLangFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$brandReqLangFrm->setFormTagAttribute('onsubmit', 'setupBrandReqLang(this); return(false);');
$brandReqLangFrm->setFormTagAttribute('data-onclear', "addBrandReqLangForm(" . $brandReqId . ", " . $brandReqLangId . ");");

$brandFld = $brandReqLangFrm->getField('brand_name');
$brandFld->setFieldTagAttribute('onblur', 'checkUniqueBrandName(this,$("input[name=lang_id]").val(),' . $brandReqId . ')');

$langFld = $brandReqLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addBrandReqLangForm(" . $brandReqId . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $brandReqLangId,'addBrandReqLangForm(' . $brandReqId . ', ' . $brandReqLangId . ', 1)');

echo $brandReqLangFrm->getFormHtml();
