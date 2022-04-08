<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$langFrm->setFormTagAttribute('class', 'form modalFormJs');

if (CommonHelper::getLayoutDirection() != $formLayout) {
    $langFrm->addFormTagAttribute('class', "layout--" . $formLayout);
    $langFrm->setFormTagAttribute('dir', $formLayout);
}
$langFrm->setFormTagAttribute('onsubmit', 'setupLang(this); return(false);');
$langFrm->setFormTagAttribute('data-onclear', "addLangForm(" . $splatform_id . ", " . $langId . ");");

$langFld = $langFrm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "addLangForm(" . $splatform_id . ", this.value);");

HtmlHelper::attachTransalateIcon($langFld,$langId,'addLangForm(' . $splatform_id . ', ' . $langId . ', 1)');

?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SOCIAL_PLATFORMS'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs" id="shopFormChildBlockTabsJs">
            <?php if(0 < count($languages)){ ?>
            <a class="nav-link" href="javascript:void(0);" onclick="addForm(<?php echo $splatform_id; ?>);" title="<?php echo Labels::getLabel('LBL_General', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
            </a>           
            <a class="nav-link active" href="javascript:void(0);" onclick="addLangForm(<?php echo $splatform_id ?>,<?php echo array_key_first($languages); ?>)" title="<?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
            <?php } ?>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <div class="row" id="shopFormChildBlockJs">
            <div class="col-md-12">
                <?php echo $langFrm->getFormHtml(); ?>
            </div>
        </div>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>