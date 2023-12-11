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
$submitField->addFieldTagAttribute('class', 'btn btn--primary btn--large btn--block color-white');
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
                                    <div class="step_head">
                                        <h5 class="step_title"><?php echo Labels::getLabel('LBL_PAYMENT_SUMMARY', $siteLangId); ?></h5>
                                    </div>
                                    <div class="step_body">
                                        <div id="payment">
                                            <div class="payment-area" <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>>
                                                <?php if ($cartSummary['orderNetAmount'] <= 0) { ?>
                                                    <div class="wallet-payment confirm-payment" id="wallet">
                                                        <h4 class="h4">
                                                            <?php echo Labels::getLabel('LBL_PAYMENT_TO_BE_MADE', $siteLangId); ?>:&nbsp;
                                                            <strong><span class="currency-value" dir="ltr">
                                                                    <?php echo strip_tags(CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, true)); ?>
                                                            </strong>
                                                        </h4>
                                                        <?php
                                                        $label = Labels::getLabel('LBL_PAYMENT_TO_BE_MADE', $siteLangId) . ' ' . strip_tags(CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, true));
                                                        $btnSubmitFld = $confirmForm->getField('btn_submit');
                                                        $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand');
                                                        $btnSubmitFld->developerTags['noCaptionTag'] = true;
                                                        $confirmForm->developerTags['colClassPrefix'] = 'col-md-';
                                                        $confirmForm->developerTags['fld_default_col'] = 12;
                                                        echo $confirmForm->getFormHtml(); ?>
                                                    </div>
                                                <?php } ?>

                                                <?php if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0 && $canUseWalletForPayment) { ?>
                                                    <div class="wallet-payment">
                                                        <div>
                                                            <label class="checkbox wallet-credits">
                                                                <?php if ($canUseWalletOrRewards) { ?>
                                                                    <input onchange="walletSelection(this)" type="checkbox" <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?> name="pay_from_wallet" id="pay_from_wallet" value="1">
                                                                <?php } ?>
                                                                <?php echo Labels::getLabel('LBL_WALLET_CREDITS:', $siteLangId); ?>&nbsp;
                                                                <strong><?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, false, true, false, true); ?></strong>
                                                            </label>
                                                            <p class="wallet-payment-txt">
                                                                <?php if ($canUseWalletOrRewards) {
                                                                    echo Labels::getLabel('LBL_USE_MY_WALLET_BALANCE_TO_PAY_FOR_MY_ORDER', $siteLangId);
                                                                } else {
                                                                    echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('LBL_PAYMENT_CANNOT_BE_MADE_DUE_TO_A_LOW_BALANCE', $siteLangId));
                                                                } ?>
                                                            </p>
                                                        </div>
                                                        <?php if ($cartSummary["cartWalletSelected"] && $userWalletBalance >= $cartSummary['orderNetAmount']) {
                                                            $btnSubmitFld = $walletPaymentForm->getField('btn_submit');
                                                            $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');
                                                            $btnSubmitFld->value = Labels::getLabel('LBL_PAY', $siteLangId) . ' ' . CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, false);
                                                            $walletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                                                            $walletPaymentForm->developerTags['fld_default_col'] = 12;

                                                            echo $walletPaymentForm->getFormTag();
                                                            echo $walletPaymentForm->getFieldHTML('order_id');
                                                            echo $walletPaymentForm->getFieldHTML('btn_submit');
                                                            echo $walletPaymentForm->getExternalJS();
                                                            echo '</form>';
                                                        ?>
                                                            <script>
                                                                function confirmOrder(frm) {
                                                                    var data = fcom.frmData(frm);
                                                                    var action = $(frm).attr('action');
                                                                    $(frm.btn_submit).attr({
                                                                        'disabled': 'disabled'
                                                                    });
                                                                    fcom.updateWithAjax(fcom.makeUrl('Checkout', 'confirmOrder'), data, function(ans) {
                                                                        $(location).attr("href", action);
                                                                        fcom.removeLoader();
                                                                    });
                                                                }
                                                            </script>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>

                                                <?php if (0 < count($paymentMethods)) { ?>
                                                    <ul class="payments-nav" id="payment_methods_tab">
                                                        <?php
                                                        $showFirstElement = '';
                                                        $i = 0;
                                                        foreach ($paymentMethods as $key => $val) {
                                                            $pmethodCode = $val['plugin_code'];
                                                            if ($cartHasDigitalProduct && isset($pmethodCode) && in_array(strtolower($pmethodCode), ['cashondelivery', 'payatstore'])) {
                                                                continue;
                                                            }
                                                            $pmethodId = $val['plugin_id'];
                                                            $pmethodName = $val['plugin_name'];

                                                            if (in_array($pmethodCode, $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                                                                continue;
                                                            }

                                                            if (0 == $i && 0 < $cartSummary['orderPaymentGatewayCharges']) {
                                                                $showFirstElement = 'show';
                                                                $i++;
                                                            } ?>
                                                            <li class="payments-nav-item">
                                                                <a class="payments-nav-link" aria-selected="true" href="<?php echo UrlHelper::generateUrl('Checkout', 'PaymentTab', array($orderId, $pmethodId)); ?>" data-paymentmethod="<?php echo $pmethodCode; ?>" data-bs-toggle="collapse" data-bs-target="#<?php echo $pmethodCode; ?>-section" aria-expanded="true" aria-controls="<?php echo $pmethodCode; ?>-section">
                                                                    <?php echo $pmethodName; ?>
                                                                </a>

                                                                <?php if (0 < $cartSummary['orderPaymentGatewayCharges']) { ?>
                                                                    <div class="accordion-collapse <?php echo $showFirstElement; ?> collapse payment-block paymentBlockJs <?php echo $pmethodCode . '-js'; ?>" id="<?php echo $pmethodCode; ?>-section" aria-labelledby="headingOne" data-bs-parent="#payment_methods_tab"></div>
                                                                <?php } ?>
                                                            </li>
                                                        <?php
                                                            $showFirstElement = '';
                                                        } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <?php if ($userWalletBalance > 0 && $canUseWalletForPayment) { ?>
                                <div class="wallet-payment">
                                    <div>
                                        <label class="checkbox wallet-credits">

                                            <input onchange="walletSelection(this)" type="checkbox" name="pay_from_wallet" id="pay_from_wallet" value="1">

                                            <?php echo Labels::getLabel('LBL_WALLET_CREDITS:', $siteLangId); ?>&nbsp;
                                            <strong><?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, false, true, false, true); ?></strong>
                                        </label>

                                    </div>

                                </div>
                            <?php } ?>


                            <div class="payment-wrapper margin-bottom-4">
                                <?php foreach ($pmethodField->options as $id => $name) {
                                    if (in_array($name['plugin_code'], Plugin::PAY_LATER)) {
                                        continue;
                                    }
                                ?>

                                    <label class="selection-tabs__label payment-method-js">
                                        <input type="radio" class="selection-tabs__input" value="<?php echo $id; ?>" <?php echo ($pmethodField->value == $id) ? 'checked' : ''; ?> name="order_pmethod_id" />
                                        <div class="selection-tabs__title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <g>
                                                    <path d="M12,22A10,10,0,1,1,22,12,10,10,0,0,1,12,22Zm-1-6,7.07-7.071L16.659,7.515,11,13.172,8.174,10.343,6.76,11.757Z" transform="translate(-2 -2)" />
                                                </g>
                                            </svg>
                                            <div class="payment-type">
                                                <p><?php echo $name['plugin_code']; ?></p>
                                            </div>
                                        </div>
                                    </label>

                                <?php } ?>
                            </div>
                            <?php echo $submitField->getHTML(); ?>
                            <p class="payment-note color-secondary">
                                <?php
                                $labelstr = Labels::getLabel('LBL_*_ALL_PURCHASES_ARE_IN_{currencycode}._FOREIGN_TRANSACTION_FEES_MIGHT_APPLY,_ACCORDING_TO_YOUR_BANK_POLICIES');
                                echo str_replace("{currencycode}", $currency['currency_code'], $labelstr);
                                ?>
                            </p>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $form->getExternalJS(); ?>