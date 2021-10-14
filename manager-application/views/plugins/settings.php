<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'setupPluginsSettings(this); return(false);');
$formTitle = CommonHelper::replaceStringData(Labels::getLabel('LBL_{PLUGIN-NAME}_PLUGIN_SETUP', $siteLangId), ['{PLUGIN-NAME}' => $identifier]);
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

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
<<<<<<< HEAD
                <button type="button" class="btn btn-brand  submitBtnJs">
                    <?php  echo Labels::getLabel('LBL_SAVE', $adminLangId); ?>
=======
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php  echo Labels::getLabel('LBL_SAVE', $siteLangId); ?>
>>>>>>> dcb74d5c219c2cc219cb2515001a6e3cc7e94a8f
                </button>
            </div>
        </div>
    </div>
</div>