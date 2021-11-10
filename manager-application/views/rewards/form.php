<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'addNewRecord(' . $userId . ')');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>