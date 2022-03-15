<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$langFrm->setFormTagAttribute('dir', $formLayout);
$langFrm->setFormTagAttribute('data-onclear', "langForm(" . $optionvalue_id . ", " . $langId . ");");
$langFrm->setFormTagAttribute('onsubmit', 'langSetup(this); return(false);');

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "langForm(" . $optionvalue_id . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $langId, 'langForm(' . $optionvalue_id . ', ' . $langId . ', 1)');

$langTabActive = true;
unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo isset($optionName) ? Labels::getLabel('LBL_OPTION_VALUES_FOR', $siteLangId) . ' ' . $optionName : Labels::getLabel('LBL_CONFIGURE_OPTION_VALUES_LANGUAGE_DATA', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <?php require_once(CONF_THEME_PATH . '/option-values/_partial/top-nav.php'); ?>
    <div class="form-edit-body loaderContainerJs" id="brandReqFormJs">
        <?php echo $langFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>