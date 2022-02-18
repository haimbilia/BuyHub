<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($optionValueFrm, 6);
$optionValueFrm->setFormTagAttribute('class', 'form modalFormJs');
$optionValueFrm->setFormTagAttribute('onsubmit', 'setUpOptionValues(this); return(false);');
$optionValueFrm->setFormTagAttribute('data-onclear', 'optionForm(' . $option_id . ')');

$fld = $optionValueFrm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
?>

<div class="row">
    <div class="col-md-12">
        <h6>
            <?php echo isset($optionName) ? Labels::getLabel('LBL_OPTION_VALUES_FOR', $langId) . ' ' . $optionName : Labels::getLabel('LBL_CONFIGURE_OPTION_VALUES', $langId); ?>
        </h6>
    </div>
    <div class="col-md-12">
        <?php
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey)) { ?>
            <div class="row justify-content-end">
                <div class="col-auto">
                    <?php ?>
                    <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $langId); ?>" onclick="autofillLangData($(this), $('#<?php echo $optionValueFrm->getFormTagAttribute('id'); ?>'))" data-action="<?php echo UrlHelper::generateUrl('OptionValues', 'getTranslatedData'); ?>">
                </div>
            </div>
        <?php } ?>
    </div>
    <?php echo $optionValueFrm->getFormHtml(); ?>
    <div id="optionValuesListing"></div>
</div>