<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
if (!$langFrm->getFormTagAttribute('id')) {
    $langFrm->setFormTagAttribute('id', 'frmLangJs');
}

if (!$langFrm->getFormTagAttribute('data-onclear')) {
    $langFrm->setFormTagAttribute('data-onclear', 'editLangData(' . $recordId . ',' . $lang_id . ')');
}
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
if (!$langFrm->getFormTagAttribute('onsubmit')) {
    $langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmLangJs")); return(false);');
}

$langFld = $langFrm->getField('lang_id');
if (!$langFld->getfieldTagAttribute('onChange')) {
    $langFld->setfieldTagAttribute('onChange', "editLangData(" . $recordId . ", this.value);");
}
$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $lang_id != $siteDefaultLangId) {
    $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
    $langFld->htmlAfterField = '<a href="javascript:void(0);" onclick="editLangData(' . $recordId . ', ' . $lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('BTN_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                    </use>
                                </svg>
                            </a>';
}

$activeLangtab = true;
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
<div class="form-edit-body loaderContainerJs">
    <?php echo $langFrm->getFormHtml(); ?>
</div>
<?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->