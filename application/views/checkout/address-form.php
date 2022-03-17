<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$addressFrm->setFormTagAttribute('class', 'form');
$addressFrm->setFormTagAttribute('onsubmit', 'setUpAddress(this, ' . $addressType . '); return(false);');

$countryFld = $addressFrm->getField('addr_country_id');
$countryFld->setFieldTagAttribute('id', 'addr_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value, 0 ,\'#addr_state_id\')');

$stateFld = $addressFrm->getField('addr_state_id');
$stateFld->setFieldTagAttribute('id', 'addr_state_id');

$submitFld = $addressFrm->getField('btn_submit');
$submitFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');

$cancelFld = $addressFrm->getField('btn_cancel');
$cancelFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-wide');
$cancelFld->setFieldTagAttribute('onclick', 'resetAddress(' . $addressType . ')');
?>

<div class="step">
    <div class="step_section">
        <div class="step_head">
            <h5 class="step_title"><?php echo Labels::getLabel('LBL_ADDRESS_DETAILS', $siteLangId); ?></h5>
        </div>
        <div class="step_body">
            <?php echo $addressFrm->getFormHtml(); ?>
        </div>
    </div>
</div>
<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#addr_country_id").val(), <?php echo $stateId; ?>, '#addr_state_id');
    });
</script>