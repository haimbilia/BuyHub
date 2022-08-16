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
                $frm->setFormTagAttribute('onsubmit', 'sendPayment(this); return(false);');
                $frm->getField('cc_number')->addFieldTagAttribute('class', 'p-cards');
                $frm->getField('cc_number')->addFieldTagAttribute('id', 'cc_number');
            ?>
                <?php echo $frm->getFormTag(); ?>
                <div class="payable-form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="caption-wraper">
                                    <label class="form-label"><?php echo Labels::getLabel('LBL_ENTER_CREDIT_CARD_NUMBER', $siteLangId); ?></label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $frm->getFieldHtml('cc_number'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="caption-wraper">
                                    <label class="form-label"><?php echo Labels::getLabel('LBL_CARD_HOLDER_NAME', $siteLangId); ?></label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $frm->getFieldHtml('cc_owner'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="caption-wraper">
                                    <label class="form-label"><?php echo Labels::getLabel('LBL_Expiry_Month', $siteLangId); ?></label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php
                                        $fld = $frm->getField('cc_expire_date_month');
                                        $fld->addFieldTagAttribute('id', 'cc_expire_date_month');
                                        $fld->addFieldTagAttribute('class', 'ccExpMonth  combobox required');
                                        echo $fld->getHtml();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="caption-wraper">
                                    <label class="form-label"><?php echo Labels::getLabel('LBL_Expiry_year', $siteLangId); ?></label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php
                                        $fld = $frm->getField('cc_expire_date_year');
                                        $fld->addFieldTagAttribute('id', 'cc_expire_date_year');
                                        $fld->addFieldTagAttribute('class', 'ccExpYear combobox required');
                                        echo $fld->getHtml();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="caption-wraper">
                                    <label class="form-label"><?php echo Labels::getLabel('LBL_CVV_SECURITY_CODE', $siteLangId); ?></label>
                                </div>
                                <div class="field-wraper">
                                    <div class="field_cover">
                                        <?php echo $frm->getFieldHtml('cc_cvv'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo $frm->getExternalJs(); ?>
                    <div id="ajax_message"></div>
                </div>

                <div class="payable-form-footer">
                    <div class="row">

                        <div class="col-6">
                            <?php if (FatUtility::isAjaxCall()) { ?>
                                <a href="javascript:void(0);" onclick="loadPaymentSummary()" class="btn btn-outline-brand  btn-block">
                                    <?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $cancelBtnUrl; ?>" class="btn btn-outline-gray  btn-block"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>
                            <?php } ?>
                        </div>
                        <div class="col-6">
                            <?php
                            $btn = $frm->getField('btn_submit');
                            $btn->addFieldTagAttribute('class', 'btn btn-brand  btn-block');
                            $btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));
                            echo $frm->getFieldHtml('btn_submit');
                            ?>
                        </div>
                    </div>
                </div>

                </form>
            <?php else : ?>
                <div class="alert alert--danger"><?php echo $error ?></div>
            <?php endif; ?>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</section>