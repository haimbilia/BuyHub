<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('dir', $formLayout);
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'setupCategoryReqLang(this); return(false);');
$frm->setFormTagAttribute('data-onclear', "addCategoryReqLangForm(" . $categoryReqId . ", " . $langId . ");");


$langFld = $frm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addCategoryReqLangForm(" . $categoryReqId . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $langId,'addCategoryReqLangForm(' . $categoryReqId . ', ' . $langId . ', 1)');

echo $frm->getFormHtml();
