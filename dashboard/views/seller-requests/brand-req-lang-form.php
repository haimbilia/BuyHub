<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($brandReqLangFrm);
$brandReqLangFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$brandReqLangFrm->setFormTagAttribute('onsubmit', 'setupBrandReqLang(this); return(false);');
$brandReqLangFrm->setFormTagAttribute('data-onclear', "addBrandReqLangForm(" . $brandReqId . ", " . $brandReqLangId . ");");

$brandFld = $brandReqLangFrm->getField('brand_name');
$brandFld->setFieldTagAttribute('onblur', 'checkUniqueBrandName(this,$("input[name=lang_id]").val(),' . $brandReqId . ')');

$langFld = $brandReqLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addBrandReqLangForm(" . $brandReqId . ", this.value);");

$fld = $brandReqLangFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $brandReqLangId != $siteDefaultLangId) { ?>
    <div class="row justify-content-end">
        <div class="col-auto">
            <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="addBrandReqLangForm(<?php echo $brandReqId; ?>, <?php echo $brandReqLangId; ?>, 1)">
        </div>
    </div>
<?php }
echo $brandReqLangFrm->getFormHtml();
