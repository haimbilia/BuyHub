<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('data-onclear', 'editMetaTagLangForm(' . $metaId . ',' . array_key_first($languages) . ', "' . $metaType . '", ' . $metaTagRecordId . ')');
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('onsubmit', 'setupLangMetaTag(this, "' . $metaType . '"); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editMetaTagLangForm(" . $metaId . ", this.value, '" . $metaType . "', " . $metaTagRecordId . ");");
$translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
$siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
if (!empty($translatorSubscriptionKey) && $lang_id != $siteDefaultLangId) {
    $langFld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
    $onclick = "editMetaTagLangForm(" . $metaId . ", " . $lang_id . ", '" . $metaType . "', " . $metaTagRecordId . ", 1)";
    $langFld->htmlAfterField = '<a href="javascript:void(0);" onclick="'. $onclick .'" class="btn" title="' .  Labels::getLabel('BTN_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                    </use>
                                </svg>
                            </a>';
}

$activeLangtab = true;
$formTitle = Labels::getLabel('LBL_META_TAG_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . 'meta-tags/_partials/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $langFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->