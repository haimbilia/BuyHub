<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form');
$frm->setFormTagAttribute('onsubmit', 'setupTaxRule(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
?>
<section class="section">
    <div class="sectionhead">
        <h4><?php echo Labels::getLabel('LBL_Tax_Structure_Setup', $adminLangId); ?></h4>
    </div>
    <div class="sectionbody space">
        <div class="tabs_nav_container responsive flat">
            <div class="tabs_panel_wrap">
                <div class="tabs_panel">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="tax-rule-form--js">
                                <div class="p-4">
                                    <div class="row mb-4">
                                        <div class="col-sm-12">                
                                        </div>
                                    </div>
                                    <div class="row">            
                                        <?php echo $frm->getFormTag(); ?>
                                        <?php
                                        echo $frm->getFieldHtml('taxrule_id');
                                        echo $frm->getFieldHtml('taxrule_taxcat_id');
                                        ?>

                                        <div class="col-md-12">
                                            <?php 
                                            

                                                $taxStrFld = $frm->getField('taxrule_taxstr_id');
                                                $taxStrFld->setFieldTagAttribute("id", "taxrule_taxstr_id");
                                                $taxStrFld->setFieldTagAttribute("onChange", "getCombinedTaxes(this, this.value)");
                                                //$taxStrFld->value = $rule['taxrule_taxstr_id'];
                                            
                                            ?>
                                            
                                            <div class="border rounded p-4  h-100">
                                                <div class="form-group">
                                                    <label for="example-text-input" class=""><?php echo $frm->getField('taxrule_name')->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxrule_name'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="example-text-input"><?php echo $frm->getField('taxrule_rate')->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxrule_rate'); ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input"><?php echo $frm->getField('taxrule_taxstr_id')->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxrule_taxstr_id'); ?>
                                                </div>                                               
                                                <?php                                       
                                                $fromCountryId = 0;
                                                $fromStateId = 0;
                                                $toCountryId = 0;
                                                $toStateIds = [];
                                                $typeId = 0;

                                                if (!empty($ruleLocations)) {
                                                    $fromCountryId = current(array_unique(array_column($ruleLocations, 'taxruleloc_from_country_id')));
                                                    $fromStateId = current(array_unique(array_column($ruleLocations, 'taxruleloc_from_state_id')));

                                                    $toCountryId = current(array_unique(array_column($ruleLocations, 'taxruleloc_to_country_id')));
                                                    $toStateIds = array_unique(array_column($ruleLocations, 'taxruleloc_to_state_id'));
                                                    $typeId = current(array_unique(array_column($ruleLocations, 'taxruleloc_type')));
                                                }

                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                            $countryFld = $frm->getField('taxruleloc_from_country_id');
                                            $countryFld->value = $fromCountryId;
                                            $countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,0,\'#taxruleloc_from_state_id\')');

                                            $stateFld = $frm->getField('taxruleloc_from_state_id');
                                            $stateFld->setFieldTagAttribute("id", "taxruleloc_from_state_id");
                                            $stateFld->value = $fromStateId;
                                            ?>

                                            <div class="border rounded p-4  h-100">
                                                <div class="form-group">
                                                    <label for="example-text-input" class=""><?php echo $countryFld->getCaption(); ?></label>
                                                    <?php echo $countryFld->getHtml('taxruleloc_from_state_id'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="example-text-input" class=""><?php echo $stateFld->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxruleloc_from_state_id'); ?>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <?php
                                            $countryFld = $frm->getField('taxruleloc_to_country_id');
                                            $countryFld->setFieldTagAttribute("id", "taxruleloc_to_country_id");
                                            $countryFld->setFieldTagAttribute('onChange', 'getCountryStatesTaxInTaxForm(this, this.value,0)');

                                            $countryFld->value = $toCountryId;

                                            $typeFld = $frm->getField('taxruleloc_type');
                                            $typeFld->value = $typeId;

                                            $stateFld = $frm->getField('taxruleloc_to_state_id[]');
                                            $stateFld->addFieldTagAttribute('multiple', 'true');
                                            $stateFld->addFieldTagAttribute('class', 'selectpicker');
                                            $stateFld->addFieldTagAttribute('data-style', 'bg-white rounded-pill px-4 py-2 shadow-sm');
                                            ?>

                                            <div class="border rounded p-4  h-100">

                                                <div class="form-group">
                                                    <label for="example-text-input" class=""><?php echo $countryFld->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxruleloc_to_country_id'); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="example-text-input" class=""><?php echo $typeFld->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxruleloc_type'); ?>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class=""><?php echo $stateFld->getCaption(); ?></label>
                                                    <?php echo $frm->getFieldHtml('taxruleloc_to_state_id[]'); ?>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="row">                                                        
                                            <div class="col-md-6 combined-tax-details--js"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class=""></label>
                                                <?php echo $frm->getFieldHtml('btn_submit'); ?>
                                            </div>                                    
                                        </div> 
                                    </div>

                                </div>
                            </div>
                            </form>
                            <?php echo $frm->getExternalJs(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(function () {
        $('.selectpicker').selectpicker();
        checkToStatesDefault(<?php echo $toCountryId; ?>, <?php echo json_encode($toStateIds); ?>);
        getCountryStates(<?php echo $fromCountryId; ?>,<?php echo $fromStateId; ?>, '#taxruleloc_from_state_id')
        $('#taxrule_taxstr_id').trigger('change');
    });

</script>
