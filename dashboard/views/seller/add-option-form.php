<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frmOptions, 6);
$frmOptions->setFormTagAttribute('class', 'form modalFormJs');
$frmOptions->setFormTagAttribute('onsubmit', 'submitOptionForm(this); return(false);');
$frmOptions->setFormTagAttribute('data-onclear', "optionForm(" . $option_id . ");");

$fld = $frmOptions->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
} ?>

<div class="col-md-12">
    <?php $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    if (!empty($translatorSubscriptionKey)) { ?>
        <div class="row justify-content-end mb-2">
            <div class="col-auto">
                <input class="btn btn-outline-gray btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onclick="autofillLangData($(this), $('form#frmOptions'))" data-action="<?php echo UrlHelper::generateUrl('Seller', 'getTranslatedOptionData'); ?>">
            </div>
        </div>
    <?php } ?>
    <?php echo $frmOptions->getFormHtml(); ?>
</div>