<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

if ($recordId > 0) {
    $fld_credential_username = $frm->getField('credential_username');
    $fld_credential_username->setFieldTagAttribute('disabled', 'disabled'); 
    $user_email = $frm->getField('credential_email');
    $user_email->setFieldTagAttribute('disabled', 'disabled');
}

$dobFld = $frm->getField('user_dob');
$dobFld->setFieldTagAttribute('class', 'user_dob_js'); 
$countryFld = $frm->getField('user_country_id');
$countryFld->setFieldTagAttribute('id', 'user_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#user_state_id\')');
$stateFld = $frm->getField('user_state_id');
$stateFld->setFieldTagAttribute('id','user_state_id');
$otherButtons = [];
$formTitle = Labels::getLabel('LBL_SHIPPING_COMPANY_USER_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<script language="javascript">
    $(document).ready(function () {
        getCountryStates($("#user_country_id").val(),<?php echo $stateId; ?>, '#user_state_id');
        $('.user_dob_js').datepicker('option', {maxDate: new Date()});
    });
</script>