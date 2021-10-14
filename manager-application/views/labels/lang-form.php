<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$langFrm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData(this); return(false);');

$fld = $langFrm->getField('key');
$fld->setFieldTagAttribute('disabled', 'disabled');
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_MANAGE_LABELS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languages)) { ?>
            <div class="row justify-content-end">
                <div class="col-auto mb-4">
                    <input class="btn btn-outline-brand btn-sm" type="button" value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" onClick="labelsForm(<?php echo $recordId; ?>, <?php echo $labelType; ?>, 1)">
                </div>
            </div>
        <?php } ?>
        <?php echo $langFrm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php echo Labels::getLabel('LBL_UPDATE', $siteLangId); ?>
                </button>
            </div>
        </div>
    </div>
</div>