<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "serviceAccountForm();");
$frm->setFormTagAttribute('id', 'pluginForm');
$frm->setFormTagAttribute('onsubmit', 'setuppluginform(this); return(false);');
$frm->setFormTagAttribute('action', UrlHelper::generateUrl($keyName, 'setup'));
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$serviceAccount = $frm->getField('service_account');
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $serviceAccount->getCaption(); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>