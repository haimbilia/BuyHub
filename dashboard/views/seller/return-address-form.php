<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'returnAddressFrm');
$frm->setFormTagAttribute('class', 'form form--horizontal');
$frm->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
$frm->developerTags['fld_default_col'] = 4;
$frm->setFormTagAttribute('onsubmit', 'setReturnAddress(this); return(false);');

$countryFld = $frm->getField('ura_country_id');
$countryFld->setFieldTagAttribute('id', 'ura_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#ura_state_id\')');

$stateFld = $frm->getField('ura_state_id');
$stateFld->setFieldTagAttribute('id', 'ura_state_id');

$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand btn-wide");
?>
<div class="card-body">
    <div class="row ">
        <div class="col-md-12">
            <nav class="nav nav-pills nav-sm mb-5" id="shopFormChildBlockTabsJs">
                <a class="nav-link active" href="javascript:void(0)" onclick="returnAddressForm()"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
                <a class="nav-link" href="javascript:void(0);" onclick="returnAddressLangForm(<?php echo FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1); ?>)">
                    <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                </a>
            </nav>
        </div>
    </div>

    <div class="row" id="shopFormChildBlockJs">
        <div class="col-md-12">
            <?php echo $frm->getFormHtml(); ?>
        </div>
    </div>
</div>
</div>
</div>


<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#ura_country_id").val(), <?php echo $stateId; ?>, '#ura_state_id');
    });
</script>