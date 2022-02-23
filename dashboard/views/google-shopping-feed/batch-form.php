<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('id', 'adsBatchForm');
$frm->setFormTagAttribute('onsubmit', 'setupBatch(this); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('dir', $formLayout);
$frm->setFormTagAttribute('data-onclear', "batchForm(" . $adsBatchId . ")");

$adsbatch_name = $frm->getField('adsbatch_name');
$adsbatch_name->addFieldTagAttribute('placeholder', $adsbatch_name->getCaption());

$fld = $frm->getField('adsbatch_expired_on');
$fld->addFieldTagAttribute('class', 'field--calender date_js');
$fld->addFieldTagAttribute('placeholder', $fld->getCaption()); 

$langFld = $frm->getField('adsbatch_lang_id');
$langFld->setFieldTagAttribute('onChange', "batchForm(" . $adsBatchId . ", this.value);");
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_BATCH_SETUP', $langId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>