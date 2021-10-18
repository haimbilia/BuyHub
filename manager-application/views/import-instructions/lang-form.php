<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$langFrm->setFormTagAttribute('id', 'editorLangFormJs');
$langFrm->setFormTagAttribute('data-onclear', 'editLangData(' . $recordId . ', ' . $siteLangId . ')');
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#editorLangFormJs")); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editLangData(" . $recordId . ", this.value);");
$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $lang_id != $siteDefaultLangId) {
    $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
    $langFld->htmlAfterField = '<a href="javascript:void(0);" onclick="editLangData(' . $recordId . ', ' . $lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('LBL_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                            </use>
                                        </svg>
                                    </a>';
} 

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
        <?php echo $langFrm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>