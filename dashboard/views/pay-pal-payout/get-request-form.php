<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'withdrawalOptionsForm("PayPalPayout");');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('id', 'frmPlugins');
$frm->setFormTagAttribute('onsubmit', 'setupPluginForm(this); return(false);');

$fld = $frm->getField('btn_submit');
if (null != $fld) {
    $frm->removeField($fld);
}

$fld = $frm->getField('payout');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
    $fld->addFieldTagAttribute('onchange', 'withdrawalOptionsForm(this.value)');
}

$amountFld = $frm->getField('amount');
$amountFld->htmlAfterField = '<span class="form-text">' . Labels::getLabel("FRM_CURRENT_WALLET_BALANCE", $siteLangId) . ' ' . CommonHelper::displayMoneyFormat($walletBalance, true, true) . '</span>';
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PAYPAL_PAYOUT_FORM', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs sectionbody space">
        <div class="row">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
    <div class="form-edit-foot">
        <div class="row">
            <div class="col">
                <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_RESET', $siteLangId), 'button', 'btn_reset_form', 'btn btn-outline-gray btn-wide  resetModalFormJs'); ?>
            </div>
            <div class="col-auto">
                <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_SAVE', $siteLangId), 'button', 'btn_save', 'btn btn-brand btn-wide submitBtnJs'); ?>
            </div>
        </div>
    </div>
</div>