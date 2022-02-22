<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$langFrm->setFormTagAttribute('data-onclear', "editSettingsForm('" .$siteLangId . ");");
$langFrm->setFormTagAttribute('id', 'frmLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmLangJs")); return(false);');
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);

$fld = $langFrm->getField('lang_id');
$fld->setfieldTagAttribute('onChange', "editLangForm('" . $etplCode . "', this.value);");
if (!isset($fld->htmlAfterField) || empty($fld->htmlAfterField)) {
    $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
    if (!empty($translatorSubscriptionKey) && $lang_id != CommonHelper::getDefaultFormLangId()) {
        $fld->developerTags['fldWidthValues'] = ['d-flex', '', '', ''];
        $fld->htmlAfterField = '<a href="javascript:void(0);" onclick="editLangForm(\'' . $etplCode . '\', ' . $lang_id . ', 1)" class="btn" title="' .  Labels::getLabel('BTN_AUTOFILL_LANGUAGE_DATA', $siteLangId) . '">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-translate">
                                </use>
                            </svg>
                        </a>';
    }
}

$fld = $langFrm->getField('test_email');
$fld->value = '<button type="button" class="btn btn-outline-brand btn-test" onclick="sendTestEmail()">
<svg class="svg btn-icon-start" width="18" height="18">
    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#send-email"> 
</use>
</svg>' . Labels::getLabel('LBL_SEND_TEST_EMAIL', $siteLangId) . '</button>';

$fld = $langFrm->getField('etpl_replacements');
$repVarArr = array_filter(explode("<br>", $fld->value));
$repVarArr = is_array($repVarArr) ? $repVarArr : [];

$repVarHtml = '<ul class="click-to-copy">';
foreach ($repVarArr as $rVar) {
    $placeholder =  trim(substr($rVar, 0, (strpos($rVar, "}") + 1)));
    $repVarHtml .= '<li title="' . Labels::getLabel('LBL_CLICK_TO_COPY', $siteLangId) . '" onclick="copyText(this, true);" data-title="' . $placeholder . '" data-bs-toggle="tooltip" data-placement="top">
        <div class="text">' . $rVar . '</div>
    </li>';
}
$repVarHtml .= '</ul>';
$fld->value = $repVarHtml;

$fld = $langFrm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_EMAIL_TEMPLATE_SETUP', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $langFrm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>