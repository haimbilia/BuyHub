<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form form_horizontal modalFormJs');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'updateTaxRule(this); return(false);');
$frm->setFormTagAttribute('data-onclear', "editRule(" . $taxRuleId . ")");
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Edit_tax_rule', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormTag(); ?>
        <div class="row">
            <?php
            echo $frm->getFieldHtml('taxrule_id');

            $fld = $frm->getField('trr_rate');
            ?>
            <div class="col-md-12">
                <div class="field-set">
                    <div class="caption-wraper">
                        <label class="field_label"><?php echo $fld->getCaption() ?><span class="spn_must_field">*</span></label>
                    </div>
                    <div class="field-wraper">
                        <div class="field_cover">
                            <?php echo $fld->getHTML('trr_rate'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            foreach ($combinedTaxData as $key => $tax) { ?>
                <div class="col-md-12">
                    <div class="field-set">
                        <div class="caption-wraper">
                            <label class="field_label"><?php echo $tax['taxstr_name'] ?><span class="spn_must_field">*</span></label>
                        </div>
                        <div class="field-wraper">
                            <div class="field_cover">
                                <input type="text" data-field-caption="<?php echo $tax['taxstr_name'] ?>" name="combinedTaxDetails[<?php echo $key; ?>][taxruledet_rate]" class='combinationInput--js' value="<?php echo $tax['taxruledet_rate']; ?>">
                                <input type="hidden" name="combinedTaxDetails[<?php echo $key; ?>][taxruledet_taxstr_id]" value="<?php echo $tax['taxruledet_taxstr_id']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        </form>
        <?php echo $frm->getExternalJs(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script>
    $(function() {
        var reqValidstr = $('form[name="frmTaxRule"] input[name="trr_rate"]').attr('data-fatreq');

        $('.combinationInput--js').each(function() {
            $(this).attr('data-fatreq', reqValidstr);
        })
    });
</script>