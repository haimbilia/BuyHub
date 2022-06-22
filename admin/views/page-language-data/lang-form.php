<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('data-onclear', "editLangForm('" . $pLangKey . "', " . $lang_id . ");");

$langFrm->setFormTagAttribute('id', 'frmpageLangLangDataJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmpageLangLangDataJs")); return(false);');
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);

$fld = $langFrm->getField('lang_id');
$fld->setfieldTagAttribute('onChange', "editLangForm('" . $pLangKey . "', this.value);");

$fld = $langFrm->getField('plang_replacements');
$repVarArr = array_filter(explode("<br>", $fld->value));
if (!empty($repVarArr)) {
    $repVarHtml = '<label class="label">' . Labels::getLabel('LBL_REPLACEMENT_VARS', $siteLangId) . '</label><ul class="click-to-copy">';
    foreach ($repVarArr as $rVar) {
        $placeholder =  trim(substr($rVar, 0, (strpos($rVar, "}") + 1)));
        $repVarHtml .= '<li title="' . Labels::getLabel('LBL_CLICK_TO_COPY', $siteLangId) . '" onclick="copyText(this, true);" data-title="' . $placeholder . '" data-bs-toggle="tooltip" data-placement="top">
        <div class="text">' . $rVar . '</div>
    </li>';
    }
    $repVarHtml .= '</ul>';
    $fld->value = $repVarHtml;
} else {
    $fld->setfieldTagAttribute('class', "d-none");
}
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PAGE_LANGUAGE_DATA_UPDATE', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $langFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
