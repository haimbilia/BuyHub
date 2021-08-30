<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="col-md-12">
    <?php
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
    if (!empty($translatorSubscriptionKey) && $langId != $siteDefaultLangId) {
        ?>
        <div class="mb-4">
            <input class="btn btn-brand"
                   type="button"
                   value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>"
                   onClick="editShopCollectionLangForm(<?php echo $scollection_id; ?>, <?php echo $langId; ?>, 1)">
        </div>
        <?php
    }
    $shopColLangFrm->setFormTagAttribute('class', 'form form--horizontal layout--' . $formLayout);
    $shopColLangFrm->setFormTagAttribute('onsubmit', 'setupShopCollectionlangForm(this); return(false);');
    $shopColLangFrm->developerTags['colClassPrefix'] = 'col-md-';
    $shopColLangFrm->developerTags['fld_default_col'] = 6;

    $langFld = $shopColLangFrm->getField('lang_id');
    $langFld->setfieldTagAttribute('onChange', "editShopCollectionLangForm(" . $scollection_id . ", this.value);");
    
    $fld = $shopColLangFrm->getField('auto_update_other_langs_data');
    if($fld != null){
        $fld->developerTags['col'] = 12;
    }   

    $submitFld = $shopColLangFrm->getField('btn_submit');
    $submitFld->setFieldTagAttribute('class', "btn btn-brand btn-wide");
    echo $shopColLangFrm->getFormHtml();
    ?>
</div>
