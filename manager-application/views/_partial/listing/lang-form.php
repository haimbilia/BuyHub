<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$langFrm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData(this); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editLangData(" . $recordId . ", this.value);");

$activeLangtab = true;
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey)) { ?> 
            <div class="row justify-content-end"> 
                <div class="col-auto mb-4">
                    <input class="btn btn-outline-brand btn-sm" 
                        type="button" 
                        value="<?php echo Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId); ?>" 
                        onClick="editLangData(<?php echo $recordId; ?>, <?php echo $lang_id; ?>, 1)">
                </div>
            </div>
        <?php } ?>
        <?php echo $langFrm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
<<<<<<< HEAD
                <button type="button" class="btn btn-brand  submitBtnJs">
                    <?php echo Labels::getLabel('LBL_UPDATE', $adminLangId); ?>
=======
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php echo Labels::getLabel('LBL_UPDATE', $siteLangId); ?>
>>>>>>> dcb74d5c219c2cc219cb2515001a6e3cc7e94a8f
                </button>
            </div>
        </div>
    </div>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->