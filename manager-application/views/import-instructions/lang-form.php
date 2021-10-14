<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$langFrm->setFormTagAttribute('id', 'editorLangFormJs');
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#editorLangFormJs")); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editLangData(" . $recordId . ", this.value);");

$fld = $langFrm->getField('epage_content');
$fld->htmlAfterField = '<a class="btn btn-outline-brand btn-sm" onClick="resetToDefaultContent();" href="javascript:void(0)">' . Labels::getLabel('LBL_RESET_EDITOR_CONTENT_TO_DEFAULT', $siteLangId) . '</a>';
?>
<!-- editor's default content[ -->

<div id="editor_default_content" style="display:none;">
    <?php echo (isset($epageData)) ? html_entity_decode($epageData['epage_default_content']) : '';?>
</div>
<!-- ] -->

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SETUP_IMPORT_INSTRUCTIONS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit"> 
    <div class="form-edit-body loaderContainerJs">
        <?php
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        if (!empty($translatorSubscriptionKey) && $lang_id != $siteDefaultLangId) { ?> 
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
</div>