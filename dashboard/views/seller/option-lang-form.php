<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('data-onclear', "optionLangForm(" . $option_id . ", " . $langId . ");");
$langFrm->setFormTagAttribute('onsubmit', 'optionLangSetup(this); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "optionLangForm(" . $option_id . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $langId, 'optionLangForm(' . $option_id . ', ' . $langId . ', 1)');

$langTabActive = true;
unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_OPTION_SETUP', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <?php require_once(CONF_THEME_PATH . '/seller/_partial/seller-options/top-nav.php'); ?>
    <div class="form-edit-body loaderContainerJs" id="brandReqFormJs">
        <?php echo $langFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>