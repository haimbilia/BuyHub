<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('class', 'form form--horizontal layout--' . $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'setupPromotionLang(this); return(false);');

$langFrm->developerTags['colClassPrefix'] = 'col-md-';
$langFrm->developerTags['fld_default_col'] = 6;

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "promotionLangForm(" . $promotionId . ", this.value);");

?>
<div class="col-md-12">
    <?php
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
    if (!empty($translatorSubscriptionKey) && $promotion_lang_id != $siteDefaultLangId) { ?>
        <div class="col-auto mb-4">
            <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="promotionLangForm(<?php echo $promotionId; ?>, <?php echo $promotion_lang_id; ?>, 1)">
        </div>
    <?php } ?>
    <?php echo $langFrm->getFormHtml(); ?>
</div>