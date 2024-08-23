<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<section class="payment-section">
    <div class="payable-amount">

        <div class="payable-amount-head">
            <div class="payable-amount-logo">
                <?php $this->includeTemplate('_partial/paymentPageLogo.php', array('siteLangId' => $siteLangId)); ?>
            </div>
            <div class="payable-amount-total">
                <p> <span class="label"> <?php echo Labels::getLabel('LBL_Total_Payable', $siteLangId); ?>:</span>
                    <span class="value"> <?php echo CommonHelper::displayMoneyFormat($paymentAmount) ?> </span>
                </p>
                <p> <span class="label"> <?php echo Labels::getLabel('LBL_Order_Invoice', $siteLangId); ?>: </span>
                    <span class="value"><?php echo $orderInfo["invoice"]; ?></span>
                </p>
            </div>
        </div>
        <div class="payable-amount-body from-payment">
            <?php
            if (!isset($error)) :
            ?>
                <?php echo $frm->getFormTag(); ?>
                <div class="payable-form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo Labels::getLabel('MSG_CONFIRM_TO_PROCEED_FOR_PAYMENT_?', $siteLangId); ?></p>
                            <?php foreach ($frm->getAllFields() as $formField) {
                                $fldName = $formField->getName();
                                if ($formField->fldType == 'submit') {
                                    continue;
                                }
                                echo $frm->getFieldHtml($fldName);
                            }
                            ?>

                        </div>
                        <div class="gap"></div>
                    </div>
                </div>
                <div class="payable-form-footer">
                    <div class="row">
                        <div class="col-6">
                            <a href="<?php echo $cancelBtnUrl; ?>" class="btn btn-outline-gray btn-block"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>
                        </div>
                        <div class="col-6">
                            <?php
                            $btn = $frm->getField('btn_submit');
                            $btn->addFieldTagAttribute('onclick', 'razorpaySubmit(this)');
                            $btn->addFieldTagAttribute('class', 'btn btn-brand  btn-block');
                            $btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));
                            echo $frm->getFieldHtml('btn_submit');
                            ?>
                        </div>
                    </div>
                </div>
                </form>
            <?php else : ?>
                <div class="alert alert-danger"><?php echo $error ?></div>
            <?php endif; ?>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</section>
<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>