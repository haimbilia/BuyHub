<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

$fromCountryId = 0;
$fromStateIds = 0;
$toCountryId = 0;
$toStateIds = [];
$typeId = 0;
if (!empty($ruleLocations)) {
    $fromCountryId = current(array_column($ruleLocations, 'taxruleloc_from_country_id'));
    $fromStateIds = array_values(array_column($ruleLocations, 'taxruleloc_from_state_id'));

    $toCountryId = current(array_column($ruleLocations, 'taxruleloc_to_country_id'));
    $toStateIds = array_values(array_column($ruleLocations, 'taxruleloc_to_state_id'));
    $typeId = current(array_column($ruleLocations, 'taxruleloc_type'));
}


$fromCountryFld = $frm->getField('taxruleloc_from_country_id');
$fromCountryFld->value = $fromCountryId;
$fromCountryFld->setFieldTagAttribute('onChange', 'checkStatesDefault(this.value,0,\'#taxruleloc_from_state_id\')');
$fromStateFld = $frm->getField('taxruleloc_from_state_id[]');
$fromStateFld->addFieldTagAttribute('multiple', 'true');
//$fromStateFld->addFieldTagAttribute('class', 'selectpicker');
$fromStateFld->addFieldTagAttribute('style', 'height:100px;');
$fromStateFld->setFieldTagAttribute("id", "taxruleloc_from_state_id");
$fromStateFld->value = $fromStateIds;

$toCountryFld = $frm->getField('taxruleloc_to_country_id');
$toCountryFld->setFieldTagAttribute("id", "taxruleloc_to_country_id");
$toCountryFld->setFieldTagAttribute('onChange', 'checkStatesDefault(this.value,0,\'#taxruleloc_to_state_id\')');
$toCountryFld->value = $toCountryId;

$typeFld = $frm->getField('taxruleloc_type');
$typeFld->value = $typeId;

$toStateFld = $frm->getField('taxruleloc_to_state_id[]');
$toStateFld->addFieldTagAttribute('multiple', 'true');
//$toStateFld->addFieldTagAttribute('class', 'selectpicker');
$toStateFld->addFieldTagAttribute('style', 'height:100px;');
$toStateFld->setFieldTagAttribute("id", "taxruleloc_to_state_id");

$taxStrFld = $frm->getField('taxrule_taxstr_id');
$taxStrFld->setFieldTagAttribute("id", "taxrule_taxstr_id");
$taxStrFld->setFieldTagAttribute("onChange", "getCombinedTaxes(this.value)");

$otherButtons = [
];

$formTitle = Labels::getLabel('LBL_TAX_CATEGORIES_RULE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>


<script>
    $(function () {
        checkStatesDefault(<?php echo $fromCountryId; ?>, <?php echo json_encode($fromStateIds); ?>, '#taxruleloc_from_state_id');
        checkStatesDefault(<?php echo $toCountryId; ?>, <?php echo json_encode($toStateIds); ?>, '#taxruleloc_to_state_id');
        $('#taxrule_taxstr_id').trigger('change');
    });
</script>