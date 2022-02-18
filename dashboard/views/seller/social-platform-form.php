<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('data-onclear', "addForm(" . $splatform_id . ")");

$fld = $frm->getField('splatform_active');
HtmlHelper::configureSwitchForCheckbox($fld);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_SOCIAL_PLATFORMS'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs" id="shopFormChildBlockTabsJs">
            <a class="nav-link active" href="javascript:void(0);" onclick="addForm(<?php echo $splatform_id; ?>);" title="<?php echo Labels::getLabel('LBL_General', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
            </a>
            <a class="nav-link" href="javascript:void(0);" onclick="addLangForm(<?php echo $splatform_id ?>,<?php echo $siteLangId; ?>)" title="<?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>">
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs">
        <div class="row" id="shopFormChildBlockJs">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>

    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>