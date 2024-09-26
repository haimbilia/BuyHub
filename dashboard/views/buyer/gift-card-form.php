<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm, 12);

$frm->addFormTagAttribute('onsubmit', 'setup(this); return false;');
$frm->addFormTagAttribute('class', 'form');
$pmethodField = $frm->getField('order_pmethod_id');
$amount = $frm->getField('order_total_amount');
$amount->addFieldTagAttribute('id', 'giftcard_price');
$receiverName = $frm->getField('ogcards_receiver_name');
$receiverEmail = $frm->getField('ogcards_receiver_email');

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PURCHASE_GIFT_CARD'); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="row">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?php 
        HtmlHelper::addSearchButton($frm, Labels::getLabel('LBL_PURCHASE_GIFT_CARD'));
        echo $frm->getField('btn_submit')->getHTML(); 
        ?>
    </div>
</div>