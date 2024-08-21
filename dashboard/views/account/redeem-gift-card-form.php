<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onSubmit', 'giftcardRedeem(this); return false;');
$frm->setFormTagAttribute('class', 'form form-apply');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$amountFld = $frm->getField('giftcard_code');
$amountFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_ENTER_CODE', $siteLangId));
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_REDEEM_GIFT_CARD', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php
        echo $frm->getFormTag();
        echo $frm->getFieldHtml('giftcard_code');
        echo $frm->getFieldHtml('btn_submit');
        echo '</form>';

        echo $frm->getExternalJs(); ?>
    </div>
</div>