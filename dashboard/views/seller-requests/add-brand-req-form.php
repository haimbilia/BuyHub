<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frmBrandReq);
$frmBrandReq->setFormTagAttribute('class', 'form modalFormJs');
$frmBrandReq->setFormTagAttribute('data-onclear', "addBrandReqForm(" . $brandReqId . ")");

$frmBrandReq->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frmBrandReq->developerTags['fld_default_col'] = 12;
$frmBrandReq->setFormTagAttribute('onsubmit', 'setupBrandReq(this); return(false);');
$identifierFld = $frmBrandReq->getField(Brand::DB_TBL_PREFIX . 'id');
$identifierFld->setFieldTagAttribute('id', Brand::DB_TBL_PREFIX . 'id');
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo (FatApp::getConfig('CONF_BRAND_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) ? Labels::getLabel('LBL_Request_New_Brand', $siteLangId) : Labels::getLabel('LBL_New_Brand', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs">
            <a class="nav-link active" href="javascript:void(0);" onclick="addBrandReqForm(<?php echo $brandReqId; ?>);">
                <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
            </a>
            <a class="nav-link <?php echo (0 == $brandReqId) ? 'fat-inactive' : ''; ?>" href="javascript:void(0);" <?php echo (0 < $brandReqId) ? "onclick='addBrandReqLangForm(" . $brandReqId . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
            </a>
            <a class="nav-link <?php echo (0 == $brandReqId) ? 'fat-inactive' : ''; ?>" href="javascript:void(0);" <?php if ($brandReqId > 0) { ?> onclick="brandMediaForm(<?php echo $brandReqId ?>);" <?php } ?>>
                <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
            </a>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs" id="brandReqFormJs">
        <?php echo $frmBrandReq->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>