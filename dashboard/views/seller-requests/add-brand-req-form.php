<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frmBrandReq);
$frmBrandReq->setFormTagAttribute('class', 'form modalFormJs');
$frmBrandReq->setFormTagAttribute('data-onclear', "addBrandReqForm(" . $brandReqId . ")");

$frmBrandReq->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmBrandReq->developerTags['fld_default_col'] = 12;
$frmBrandReq->setFormTagAttribute('onsubmit', 'setupBrandReq(this); return(false);');
$identifierFld = $frmBrandReq->getField(Brand::DB_TBL_PREFIX . 'id');
$identifierFld->setFieldTagAttribute('id', Brand::DB_TBL_PREFIX . 'id');

$fld = $frmBrandReq->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$fld = $frmBrandReq->getField('brand_name');
$fld->setFieldTagAttribute('onkeyup', "getIdentifier(this)");
$fld->htmlAfterField = "<small class='form-text text-muted'>" . HtmlHelper::getIdentifierText($identifier, $siteLangId) . '</small>';

unset($languages[CommonHelper::getDefaultFormLangId()]);

$generalTabActive = true;
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) ? Labels::getLabel('LBL_Request_New_Brand', $siteLangId) : Labels::getLabel('LBL_New_Brand', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <?php require_once(CONF_THEME_PATH . '/seller-requests/_partial/brand-request/top-nav.php'); ?>
    <div class="form-edit-body loaderContainerJs" id="brandReqFormJs">
        <?php echo $frmBrandReq->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>