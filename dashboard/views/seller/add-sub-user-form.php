<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;
$phoneFld = $frm->getField('user_phone');
$phoneFld->setFieldTagAttribute('class', 'phone-js ltr-right');
$phoneFld->setFieldTagAttribute('placeholder', ValidateElement::PHONE_NO_FORMAT);
$phoneFld->setFieldTagAttribute('maxlength', ValidateElement::PHONE_NO_LENGTH);
$countryFld = $frm->getField('user_country_id');
$countryFld->setFieldTagAttribute('id', 'user_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#user_state_id\')');
$stateFld = $frm->getField('user_state_id');
$stateFld->setFieldTagAttribute('id', 'user_state_id');
if ($userId > 0) {
    $usernameFld = $frm->getField('user_username');
    $usernameFld->setFieldTagAttribute('disabled', 'disabled');
}
$submitFld = $frm->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', "btn btn-brand"); ?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SUB_USER_SETUP', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body">
    <?php echo $frm->getFormHtml(); ?>
</div>

<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#user_country_id").val(), <?php echo $stateId; ?>, '#user_state_id');
    });
</script>