<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm, 6);

$frm->setFormTagAttribute('id', 'returnAddressLangFrm');
$frm->setFormTagAttribute('class', 'form modalFormJs');
if (CommonHelper::getLayoutDirection() != $formLayout) {
    $frm->addFormTagAttribute('class', "layout--" . $formLayout);
    $frm->setFormTagAttribute('dir', $formLayout);
}
$frm->setFormTagAttribute('onsubmit', 'setReturnAddressLang(this); return(false);');

$address1 = $frm->getField('ura_address_line_1');
$address1->developerTags['col'] = 6;

$address2 = $frm->getField('ura_address_line_2');
$address2->developerTags['col'] = 6;

$langFld = $frm->getField('lang_id');
$langFld->setfieldTagAttribute('onChange', "returnAddressLangForm(this.value);");
HtmlHelper::attachTransalateIcon($langFld, $formLangId,'returnAddressLangForm(' . $formLangId . ', 1)');

$fld = $frm->getField('auto_update_other_langs_data');
if (null != $fld) {
    HtmlHelper::configureSwitchForCheckbox($fld);
}
unset($languages[CommonHelper::getDefaultFormLangId()]);
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_RETURN_ADDRESS_SETUP', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs">
            <?php if(0 < count($languages)){ ?>
                <a class="nav-link" href="javascript:void(0)" onclick="returnAddressForm()"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
                <a class="nav-link active" href="javascript:void(0);" onclick="returnAddressLangForm(<?php echo array_key_first($languages); ?>)">
                    <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
                </a>
            <?php } ?>
        </nav>
    </div>
    <div class="form-edit-body loaderContainerJs sectionbody space">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <?php echo $frm->getFormHtml(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>