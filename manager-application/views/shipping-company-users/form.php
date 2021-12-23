<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

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

$fld = $frm->getField('credential_username');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('user_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('user_dob');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('user_phone');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('credential_email');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('user_country_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('user_state_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('user_city');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $frm->getField('user_order_tracking_url');
$fld->developerTags['colWidthValues'] = [null, '12', null, null]; 

$formTitle = Labels::getLabel('LBL_SHIPPING_COMPANY_USER_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<script language="javascript">
    $(document).ready(function () {
        getCountryStates($("#user_country_id").val(),<?php echo $stateId; ?>, '#user_state_id');
        $('.user_dob_js').datepicker('option', {maxDate: new Date()});
    });
</script>