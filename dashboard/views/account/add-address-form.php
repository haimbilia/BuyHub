<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($addressFrm, 6);
$addressFrm->setFormTagAttribute('class', 'form modalFormJs');

if (CommonHelper::getLayoutDirection() != $formLayout) {
    $addressFrm->addFormTagAttribute('class', "layout--" . $formLayout);
    $addressFrm->setFormTagAttribute('dir', $formLayout);
}
$addressFrm->setFormTagAttribute('id', 'addressFrm');
$addressFrm->setFormTagAttribute('onsubmit', 'setupAddress(this); return(false);');
$addressFrm->setFormTagAttribute('data-onclear', "addAddressForm(" . $addr_id . ");");

$countryFld = $addressFrm->getField('addr_country_id');
$countryFld->setFieldTagAttribute('id', 'addr_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#addr_state_id\')');

$stateFld = $addressFrm->getField('addr_state_id');
$stateFld->setFieldTagAttribute('id', 'addr_state_id');

$langFld = $addressFrm->getField('lang_id');
$langFld->setFieldTagAttribute('onChange', "addAddressForm(" . $addr_id . ", this.value);");

$addrLabelFld = $addressFrm->getField('addr_title');
$addrLabelFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_E.G:_MY_HOME_ADDRESS'));
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_ADDRESS_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="row">
            <div class="col-md-12">
                <?php echo $addressFrm->getFormHtml(); ?>
            </div>
        </div>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#addr_country_id").val(), <?php echo $stateId; ?>, '#addr_state_id');
    });
</script>