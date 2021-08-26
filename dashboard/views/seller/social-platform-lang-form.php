<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="col-md-12">
    <?php
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
    if (!empty($translatorSubscriptionKey) && $splatform_lang_id != $siteDefaultLangId) {
        ?>
        <div class="row justify-content-end">
            <div class="col-auto mb-4">
                <input class="btn btn-brand"
                       type="button"
                       value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>"
                       onClick="addLangForm(<?php echo $splatform_id; ?>, <?php echo $splatform_lang_id; ?>, 1)">
            </div>
        </div>
    <?php } ?>
    <?php
    $langFrm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
    $langFrm->setFormTagAttribute('class', 'form form--horizontal layout--' . $formLayout);
    $langFrm->developerTags['colClassPrefix'] = 'col-md-';
    $langFrm->developerTags['fld_default_col'] = 4;
    $langFld = $langFrm->getField('lang_id');
    $langFld->setfieldTagAttribute('onChange', "addLangForm(" . $splatform_id . ", this.value);");
    $langFld->developerTags['col'] = 2;       
    
    $submitFld = $langFrm->getField('btn_submit');
    $submitFld->developerTags['col'] = 2;
    
    $submitFld->setFieldTagAttribute('class', "btn btn-brand btn-wide");
    echo $langFrm->getFormHtml();
    ?>
</div>