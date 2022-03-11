<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($brandReqLangFrm);
$brandReqLangFrm->setFormTagAttribute('dir', $formLayout);
$brandReqLangFrm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$brandReqLangFrm->setFormTagAttribute('onsubmit', 'setupBrandReqLang(this); return(false);');
$brandReqLangFrm->setFormTagAttribute('data-onclear', "addBrandReqLangForm(" . $brandReqId . ", " . $brandReqLangId . ");");

$langFld = $brandReqLangFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addBrandReqLangForm(" . $brandReqId . ", this.value);");
HtmlHelper::attachTransalateIcon($langFld, $brandReqLangId,'addBrandReqLangForm(' . $brandReqId . ', ' . $brandReqLangId . ', 1)');
$langTabActive = true;
unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) ? Labels::getLabel('LBL_Request_New_Brand', $siteLangId) : Labels::getLabel('LBL_New_Brand', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <?php require_once(CONF_THEME_PATH . '/seller-requests/_partial/brand-request/top-nav.php'); ?>
    <div class="form-edit-body loaderContainerJs" id="brandReqFormJs">
        <?php echo $brandReqLangFrm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>
