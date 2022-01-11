<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', 'editSettingForm("' . $keyName . '")');
$frm->setFormTagAttribute('onsubmit', 'setupPluginsSettings($("#'.$frm->getFormTagAttribute('id').'")[0]); return(false);');
$formTitle = CommonHelper::replaceStringData(Labels::getLabel('LBL_{PLUGIN-NAME}_PLUGIN_SETUP', $siteLangId), ['{PLUGIN-NAME}' => $identifier]);
$formSubTitle = !empty($formSubTitle) ? $formSubTitle : '';
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $formTitle; ?>
        <?php if (!empty($formSubTitle)) { ?>
            <span class="text-muted"><?php echo $formSubTitle; ?></span>
        <?php } ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>