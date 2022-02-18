<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($shopColLangFrm);
$shopColLangFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$shopColLangFrm->setFormTagAttribute('data-onclear', "editShopCollectionLangForm(" . $scollection_id . ", " . $langId . ");");
$shopColLangFrm->setFormTagAttribute('onsubmit', 'setupShopCollectionlangForm(this); return(false);');

$langFld = $shopColLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editShopCollectionLangForm(" . $scollection_id . ", this.value);");

$fld = $shopColLangFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
?>

<div class="col-md-12">
    <?php
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
    if (!empty($translatorSubscriptionKey) && $langId != $siteDefaultLangId) {
    ?>
        <div class="row justify-content-end">
            <div class="col-auto">
                <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="editShopCollectionLangForm(<?php echo $scollection_id; ?>, <?php echo $langId; ?>, 1)">
            </div>
        </div>
    <?php
    }
    echo $shopColLangFrm->getFormHtml();
    ?>
</div>