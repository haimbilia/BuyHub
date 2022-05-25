<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'updateUserPassword(this); return(false);');
$frm->setFormTagAttribute('data-onclear', "userPasswordForm(" . $userId . ")");
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->developerTags['fld_default_col'] = 12;
$newPwd = $frm->getField('new_password');
$newPwd->htmlAfterField = '<span class="form-text text-muted">' . sprintf(Labels::getLabel('LBL_EXAMPLE_PASSWORD', $siteLangId), 'User@123') . '</span>';
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>