<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('id', 'changePhoneForm_' . $updatePhnFrm."_".rand(0,100));
$frm->setValidatorJsObjectName($frm->getFormTagAttribute('id'));

$frm->developerTags['colClassPrefix'] = 'col-xl-12 col-lg-12 col-md-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('autocomplete', 'off');
$frm->setFormTagAttribute('onsubmit', 'getOtp(this, ' . $updatePhnFrm . '); return(false);');

$phnFld = $frm->getField('user_phone');
$label = (0 < $updatePhnFrm ? Labels::getLabel('LBL_NEW_PHONE_NUMBER', $siteLangId) : Labels::getLabel('LBL_OLD_PHONE_NUMBER', $siteLangId));
$phnFld->changeCaption($label);

$fldSubmit = $frm->getField('btn_submit');
$fldSubmit->setFieldTagAttribute('class', "btn btn-brand btn-wide");
$fldSubmit->developerTags['noCaptionTag'] = true;
$fldSubmit->htmlAfterField = '<br/><span class="form-text text-muted">' . Labels::getLabel('MSG_YOU_CANNOT_UPDATE_UNTIL_YOU_VERIFY_YOUR_PHONE_NUMBER.', $siteLangId) . '</span>';

echo $frm->getFormHtml();

if (isset($countryIso) && !empty($countryIso)) { ?>
    <script>
        langLbl.defaultCountryCode = '<?php echo $countryIso; ?>';
    </script>
<?php } ?>