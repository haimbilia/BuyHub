<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
//$addressFrm->setCustomRendererClass('FormRendererBS');
//$addressFrm->developerTags['rowClassNameDefault'] = 'rowClassName';
//$addressFrm->developerTags['colClassBeforeWidthDefault'] = 'colClassBeforeWidth';
//$addressFrm->developerTags['colClassAfterWidthDefault'] = 'colClassAfterWidth';
$addressFrm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
$addressFrm->developerTags['colWidthValuesDefault'] = [null, '6', null, null];
$addressFrm->developerTags['fldWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$addressFrm->developerTags['fldWidthValuesDefault'] = ['cover', 'cover', 'cover', 'cover'];
$addressFrm->developerTags['labelWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$addressFrm->developerTags['labelWidthValuesDefault'] = ['label', 'label', 'label', 'label'];
$addressFrm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';

$addressFrm->setFormTagAttribute('class', 'form');
$addressFrm->setFormTagAttribute('onsubmit', 'setUpAddress(this, ' . $addressType . '); return(false);');

$phoneFld = $addressFrm->getField('addr_address1');
$phoneFld->developerTags['colWidthClasses'] = [null, 'col-md-', null, null];
$phoneFld->developerTags['colWidthValues'] = [null, '12', null, null];

$phoneFld = $addressFrm->getField('addr_address2');
$phoneFld->developerTags['colWidthClasses'] = [null, 'col-md-', null, null];
$phoneFld->developerTags['colWidthValues'] = [null, '12', null, null];

$phoneFld = $addressFrm->getField('addr_city');
$phoneFld->developerTags['colWidthClasses'] = [null, 'col-md-', null, null];
$phoneFld->developerTags['colWidthValues'] = [null, '12', null, null];

$countryFld = $addressFrm->getField('addr_country_id');
$countryFld->setFieldTagAttribute('id', 'addr_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value, 0 ,\'#addr_state_id\')');

$stateFld = $addressFrm->getField('addr_state_id');
$stateFld->setFieldTagAttribute('id', 'addr_state_id');

$submitFld = $addressFrm->getField('btn_submit');
$submitFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');
$submitFld->developerTags['colClassBeforeWidth'] = 'col-auto';
$submitFld->developerTags['colWidthClasses'] = [null, null, null, null];
$submitFld->developerTags['colWidthValues'] = [null, null, null, null];
//$submitFld->developerTags['fieldWrapperRowExtraClass'] = 'form-group-btn';
$cancelFld = $addressFrm->getField('btn_cancel');
$cancelFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-wide');
$cancelFld->developerTags['colClassBeforeWidth'] = 'col';
$cancelFld->developerTags['colWidthClasses'] = [null, null, null, null];
$cancelFld->developerTags['colWidthValues'] = [null, null, null, null];
$cancelFld->setFieldTagAttribute('onclick', 'resetAddress(' . $addressType . ')');
//$cancelFld->developerTags['fieldWrapperRowExtraClass'] = 'form-group-btn'; */
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