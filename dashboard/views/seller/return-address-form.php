<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('id', 'returnAddressFrm');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'setReturnAddress(this); return(false);');

$countryFld = $frm->getField('ura_country_id');
$countryFld->setFieldTagAttribute('id', 'ura_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#ura_state_id\')');

$stateFld = $frm->getField('ura_state_id');
$stateFld->setFieldTagAttribute('id', 'ura_state_id');
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_RETURN_ADDRESS_SETUP'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs">
            <a class="nav-link active" href="javascript:void(0)" onclick="returnAddressForm()"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
            <a class="nav-link" href="javascript:void(0);" onclick="returnAddressLangForm(<?php echo FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1); ?>)">
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs sectionbody space">
        <div class="row">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#ura_country_id").val(), <?php echo $stateId; ?>, '#ura_state_id');
    });
</script>