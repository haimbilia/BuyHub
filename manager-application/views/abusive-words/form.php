<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', true)');
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('id', 'frmAbusiveWordJs');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "closeForm"); return(false);');

$fld = $frm->getField('abusive_lang_id');
$fld->addFieldTagAttribute('onChange', 'changeFormLayOut(this);');
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_ABUSIVE_KEYWORD_SETUP', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>