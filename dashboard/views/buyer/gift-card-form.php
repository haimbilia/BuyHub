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
$submitField->addFieldTagAttribute('class', 'btn btn-brand btn-wide ');

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_PURCHASE_GIFTCARD', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body">
    <div class="form-edit-body">

        <div class="facebox-panel">

            <div class="facebox-panel__body padding-bottom-0">
                <div class="selection selection--checkout selection--payment">
                    <?php echo $form->getFormTag(); ?>
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xl-6">
                            <div class="field-set">
                                <label class="field_label margin-bottom-2">
                                    <?php echo $amount->getCaption(); ?>
                                    <?php if ($amount->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php  } ?>
                                </label>
                                <?php echo $amount->getHTML(); ?>
                            </div>

                            <div class="field-set">
                                <label class="field_label margin-bottom-2">
                                    <?php echo $receiverName->getCaption(); ?>
                                    <?php if ($receiverName->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php  } ?>
                                </label>
                                <?php echo $receiverName->getHTML(); ?>
                            </div>

                            <div class="field-set">
                                <label class="field_label margin-bottom-2">
                                    <?php echo $receiverEmail->getCaption(); ?>
                                    <?php if ($receiverEmail->requirement->isRequired()) { ?>
                                        <span class="spn_must_field">*</span>
                                    <?php  } ?>
                                </label>
                                <?php echo $receiverEmail->getHTML(); ?>
                            </div>

                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="selection-title">
                                <label class="field_label margin-bottom-2"><?php echo Labels::getLabel('LBL_PAYMENT_METHOD'); ?> <span class="spn_must_field">*</span></label>
                            </div>
                            <div class="step">
                                <div class="step_section">
                                    <div class="step_body">
                                        <div id="payment">
                                            <div class="payment-area">
                                                <div class="payments-nav" id="payment_methods_tab">
                                                    <?php
                                                    echo    $pmethodField->getHTML();
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <?php echo $submitField->getHTML(); ?>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $form->getExternalJS(); ?>