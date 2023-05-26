<?php 
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('id', 'changeEmailUsingPhoneForm');
$frm->developerTags['colClassPrefix'] = 'col-xl-12 col-lg-12 col-md-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('autocomplete', 'off');
$frm->setFormTagAttribute('onsubmit', 'getOtp(this); return(false);');

$phnFld = $frm->getField('user_phone');

$phnFld->changeCaption(Labels::getLabel('LBL_PHONE_NUMBER', $siteLangId));

$fldSubmit = $frm->getField('btn_submit');
$fldSubmit->setFieldTagAttribute('class', "btn btn-brand btn-wide");
$fldSubmit->developerTags['noCaptionTag'] = true;
$fldSubmit->htmlAfterField = '<br/><span class="form-text text-muted">' . Labels::getLabel('MSG_YOU_CANNOT_UPDATE_YOUR_EMAIL_UNTIL_YOU_VERIFY_YOUR_NUMBER.', $siteLangId) . '</span>';

echo $frm->getFormHtml();

if (isset($countryIso) && !empty($countryIso)) { ?>
    <script>
        langLbl.defaultCountryCode = '<?php echo $countryIso; ?>';
    </script>
<?php } ?>