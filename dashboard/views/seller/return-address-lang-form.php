<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'returnAddressLangFrm');
$frm->setFormTagAttribute('class', 'form form--horizontal layout--' . $formLayout);
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;
$frm->setFormTagAttribute('onsubmit', 'setReturnAddressLang(this); return(false);');

$address1 = $frm->getField('ura_address_line_1');
$address1->developerTags['col'] = 6;

$address2 = $frm->getField('ura_address_line_2');
$address2->developerTags['col'] = 6;

$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand btn-wide");

$langFld = $frm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "returnAddressLangForm(this.value);");
?>

<div class="col-md-12">
<?php
$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $formLangId != $siteDefaultLangId) {
    ?>
    <div class="row justify-content-end">
        <div class="col-auto mb-4">
            <input class="btn btn-brand"
                   type="button"
                   value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>"
                   onClick="returnAddressLangForm(<?php echo $formLangId; ?>, 1)">
        </div>
    </div>
<?php } ?>
<?php echo $frm->getFormHtml(); ?>
</div>


