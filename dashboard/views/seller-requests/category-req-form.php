<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addCategoryReqForm(" . $categoryReqId . ")");
$frm->setFormTagAttribute('onsubmit', 'setupCategoryReq(this); return(false);');
$frm->setFormTagAttribute('onsubmit', 'setupCategoryReq($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');

$fld = $frm->getField('prodcat_name');
$fld->setFieldTagAttribute('onkeyup', "getIdentifier(this)");
$fld->htmlAfterField = "<small class='form-text text-muted'>" . HtmlHelper::getIdentifierText($identifier, $siteLangId) . '</small>';


$fld = $frm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

unset($languages[CommonHelper::getDefaultFormLangId()]);

?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo (FatApp::getConfig('CONF_PRODUCT_CATEGORY_REQUEST_APPROVAL', FatUtility::VAR_INT, 0)) ? Labels::getLabel('LBL_Request_New_Category', $siteLangId) : Labels::getLabel('LBL_New_Category', $siteLangId) ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
    <?php if(0 < count($languages)){ ?>
        <nav class="nav nav-tabs navTabsJs">
            <a class="nav-link active" href="javascript:void(0);" onclick="addCategoryReqForm(<?php echo $categoryReqId; ?>);">
                <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
            </a>        
            <a class="nav-link <?php echo (0 == $categoryReqId) ? 'disabled' : ''; ?>" href="javascript:void(0);" <?php echo (0 < $categoryReqId) ? "onclick='addCategoryReqLangForm(" . $categoryReqId . "," . array_key_first($languages) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId); ?>
            </a>  
            <a class="nav-link <?php echo (0 == $categoryReqId) ? 'disabled' : ''; ?>" href="javascript:void(0);" <?php if ($categoryReqId > 0) { ?> onclick="categoryReqMediaForm(<?php echo $categoryReqId ?>);" <?php } ?>>
            <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
        </a>
        </nav>
        <?php } ?>
    </div>
    <div class="form-edit-body loaderContainerJs" id="categoryReqFormJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>