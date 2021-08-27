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
            <div class="tabs tabs-sm" >
                <ul id="shopFormChildBlockTabsJs">
                    <li class="is-active"><a href="javascript:void(0)" onClick="returnAddressForm()"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a></li>
                    <li>
                        <a href="javascript:void(0);" onclick="returnAddressLangForm(<?php echo FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1); ?>)">
                            <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                        </a>
                    </li>
                </ul>
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
    $(document).ready(function () {
        getCountryStates($("#ura_country_id").val(),<?php echo $stateId; ?>, '#ura_state_id');
    });
</script>
