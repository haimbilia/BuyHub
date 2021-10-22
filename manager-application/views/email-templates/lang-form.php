<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);

$testEmailTemplate = $langFrm->getField('test_email');
$testEmailTemplate->setfieldTagAttribute('onClick', "sendTestEmail();");

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "editLangForm('" . $etplCode . "', this.value);");



$langFrm->setFormTagAttribute('data-onclear', "editLangForm('" . $etplCode . "', this.value);");
$langFrm->setFormTagAttribute('id', 'frmLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmLangJs")); return(false);');
$langFrm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);

$fld = $langFrm->getField('etpl_replacements');
$repVarArr = array_filter(explode("<br>", $fld->value));

$repVarHtml = '<label class="label">'.Labels::getLabel('LBL_REPLACEMENT_VARS', $siteLangId).'</label>
                <ul class="click-to-copy">';
foreach($repVarArr as $rVar){  
    $placeholder =  trim(substr($rVar,0,(strpos($rVar ,"}")+1)));
    $repVarHtml .= '<li title="'.Labels::getLabel('LBL_CLICK_TO_COPY', $siteLangId).'" onClick="copyText(this);" data-title="'.$placeholder.'">
        <div class="text">'.$rVar.'</div>
    </li>';
}
$repVarHtml .= '</ul>';
$fld->value = $repVarHtml;

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
