<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('data-onclear', "addLangForm(" . $splatform_id . ", " . $splatform_lang_id . ");");

$fld = $langFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
?>
<div class="col-md-12">
    <?php
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
    if (!empty($translatorSubscriptionKey) && $splatform_lang_id != $siteDefaultLangId) {
    ?>
        <div class="row justify-content-end">
            <div class="col-auto mb-4">
                <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="addLangForm(<?php echo $splatform_id; ?>, <?php echo $splatform_lang_id; ?>, 1)">
            </div>
        </div>
    <?php } ?>
    <?php
    $langFrm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
    $langFld = $langFrm->getField('lang_id');
    $langFld->setfieldTagAttribute('onChange', "addLangForm(" . $splatform_id . ", this.value);");

    echo $langFrm->getFormHtml();
    ?>
</div>