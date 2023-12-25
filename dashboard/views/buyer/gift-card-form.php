<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$form->addFormTagAttribute('onsubmit', 'setup(this); return false;');
$form->addFormTagAttribute('class', 'form');
$pmethodField = $form->getField('order_pmethod_id');
$amount = $form->getField('order_total_amount');
$amount->addFieldTagAttribute('id', 'giftcard_price');
$receiverName = $form->getField('ogcards_receiver_name');
$receiverEmail = $form->getField('ogcards_receiver_email');
$submitField = $form->getField('submit');
$submitField->addFieldTagAttribute('class', 'btn btn-brand btn-wide');

?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PURCHASE_GIFTCARD', $siteLangId); ?>
    </h5>
</div>
<?php echo $form->getFormTag(); ?>
<div class="modal-body">
    <div class="row justify-content-between">
        <div class="col-md-12 col-xl-12">
            <div class="field-set">
                <label class="form-label">
                    <?php echo $amount->getCaption(); ?>
                    <?php if ($amount->requirement->isRequired()) { ?>
                        <span class="spn_must_field">*</span>
                    <?php  } ?>
                </label>
                <?php echo $amount->getHTML(); ?>
            </div>
            <div class="field-set">
                <label class="form-label">
                    <?php echo $receiverName->getCaption(); ?>
                    <?php if ($receiverName->requirement->isRequired()) { ?>
                        <span class="spn_must_field">*</span>
                    <?php  } ?>
                </label>
                <?php echo $receiverName->getHTML(); ?>
            </div>
            <div class="field-set">
                <label class="form-label">
                    <?php echo $receiverEmail->getCaption(); ?>
                    <?php if ($receiverEmail->requirement->isRequired()) { ?>
                        <span class="spn_must_field">*</span>
                    <?php  } ?>
                </label>
                <?php echo $receiverEmail->getHTML(); ?>
            </div>

        </div>
    </div>
    <p class="note">
        <?php
        if (!empty($paymentMethods)) {
            echo $submitField->getHTML();
        } else {
            echo Labels::getLabel('LBL_PLEASE_ENABLED_PAYMENT_METHODS_OR_ADD_MONEY_IN_WALLET');
        }
        ?>
    </p>

</div>
<div class="modal-footer">
    <?php
    echo $submitField->getHTML();
    ?>
</div>
</form>
<?php echo $form->getExternalJS(); ?>