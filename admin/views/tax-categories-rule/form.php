<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

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

$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0], "editRecord"); return(false);');
$fromCountryFld = $frm->getField('taxruleloc_from_country_id');
$fromCountryFld->value = $fromCountryId;
$fromCountryFld->setFieldTagAttribute('onChange', 'checkStatesDefault(this,0,\'#taxruleloc_from_state_id\')');
$fromCountryFld->addFieldTagAttribute('class', 'fromCountyElementJs');
$fromStateFld = $frm->getField('taxruleloc_from_state_id[]');
$fromStateFld->addFieldTagAttribute('multiple', 'true');
//$fromStateFld->addFieldTagAttribute('class', 'selectpicker');
$fromStateFld->addFieldTagAttribute('style', 'height:100px;');
$fromStateFld->setFieldTagAttribute("id", "taxruleloc_from_state_id");
$fromStateFld->value = $fromStateIds;

$toCountryFld = $frm->getField('taxruleloc_to_country_id');
$toCountryFld->setFieldTagAttribute("id", "taxruleloc_to_country_id");
$toCountryFld->setFieldTagAttribute('onChange', 'checkStatesDefault(this,0,\'#taxruleloc_to_state_id\')');
$toCountryFld->addFieldTagAttribute('class', 'toCountyElementJs');
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

$fld = $frm->getField('taxrule_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('trr_rate');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('taxruleloc_to_country_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('taxruleloc_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 

$formTitle = Labels::getLabel('LBL_TAX_CATEGORY_RULE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    $(function () {
        checkStatesDefault($('.fromCountyElementJs').get(0), <?php echo json_encode($fromStateIds); ?>, '#taxruleloc_from_state_id');
        checkStatesDefault($('.toCountyElementJs').get(0), <?php echo json_encode($toStateIds); ?>, '#taxruleloc_to_state_id');
        $('#taxrule_taxstr_id').trigger('change');
       
    });
</script>