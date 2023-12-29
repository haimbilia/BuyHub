<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($addressFrm, 6);
$addressFrm->setFormTagAttribute('id', 'addressFormJs');
$addressFrm->setFormTagAttribute('class', 'form modalFormJs');
$addressFrm->setFormTagAttribute('data-onclear', 'addAddress(' . $selprodId . ')');
if ($isUserLogged) {
    $addressFrm->setFormTagAttribute('onsubmit', 'saveAddress($("#addressFormJs"), ' . $selprodId . '); return(false);');
} else {
    $addressFrm->setFormTagAttribute('onsubmit', 'saveAddress($("#addressFormJs"), ' . $selprodId . ', true); return(false);');
}
$countryFld = $addressFrm->getField('addr_country_id');
$countryFld->setFieldTagAttribute('id', 'addr_country_id');
$countryFld->setFieldTagAttribute('onchange', 'getCountryStates(this.value, 0 ,\'#addr_state_id\')');

$stateFld = $addressFrm->getField('addr_state_id');
$stateFld->setFieldTagAttribute('id', 'addr_state_id');

$fld = $addressFrm->getField('btn_submit');
$addressFrm->removeField($fld);

$fld = $addressFrm->getField('btn_cancel');
$addressFrm->removeField($fld);

$includeBackBtn = $includeBackBtn ?? true;
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_ADD_SHIPPING_ADDRESS'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $addressFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/sidebar/form-edit-foot.php'); ?>
</div>
<script>
    $(document).ready(function() {
        getCountryStates($("#addr_country_id").val(), 0, '#addr_state_id');
    });
</script>