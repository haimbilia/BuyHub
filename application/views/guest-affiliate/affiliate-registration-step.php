<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$registerForm->setFormTagAttribute('class', 'form form--normal');
$registerForm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$registerForm->developerTags['fld_default_col'] = 12;

if (!$affiliate_register_step_number) {
    $btnSubmitFld = $registerForm->getField('btn_submit');
    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');
    $btnSubmitFld->developerTags['noCaptionTag'] = true;
}

switch ($affiliate_register_step_number) {
    case UserAuthentication::AFFILIATE_REG_STEP1:
        $registerForm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-6 col-sm-';
        $registerForm->developerTags['fld_default_col'] = 6;

        $termsFld = $registerForm->getField('agree_fld_html_div');
        if (null != $termsFld) {
            $termsFld->setWrapperAttribute('class', 'col-lg-12 col-md-12 col-sm-');
            $termsFld->developerTags['col'] = 12;
        }

        /* script to make terms&condition checkbox wrap in a particular html, so that upon validation, error must display after caption not after checkbox itself[ */
        $termsAndConditionsLink = sprintf(Labels::getLabel('LBL_I_agree_to_the_terms_conditions', $siteLangId), "<a target='_blank' href='$termsAndConditionsLinkHref'>" . Labels::getLabel('LBL_Terms_Conditions', $siteLangId) . '</a>');

        $termsFld = $registerForm->getFieldHtml('agree');

        $termsFld = str_replace("<label >", "", $termsFld);
        $termsFld = str_replace("</label>", "", $termsFld);

        if (null != $registerForm->getField('agree')) {
            $registerForm->removeField($registerForm->getField('agree'));
        }

        $termsFldHtml = '<div class="form-group"><label class="checkbox">' . $termsFld;

        $termsFldHtml .= '' . $termsAndConditionsLink . '</label></div>';

        $agree_fld_html_div = $registerForm->getField('agree_fld_html_div');
        if (null != $agree_fld_html_div) {
            $agree_fld_html_div->value = $termsFldHtml;
        }

        /* ] */

        break;

    case UserAuthentication::AFFILIATE_REG_STEP2:
        $registerForm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-6 col-sm-';
        $registerForm->developerTags['fld_default_col'] = 6;
        $stateId = isset($stateId) ? $stateId : 0;
?>
        <script>
            $(function() {
                getCountryStates($("#user_country_id").val(), '<?php echo $stateId; ?>', '#user_state_id');
            });
        </script>
    <?php
        $countryFld = $registerForm->getField('user_country_id');
        $countryFld->setFieldTagAttribute('id', 'user_country_id');
        $countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,' . $stateId . ',\'#user_state_id\')');

        $stateFld = $registerForm->getField('user_state_id');
        $stateFld->setFieldTagAttribute('id', 'user_state_id');
        break;

    case UserAuthentication::AFFILIATE_REG_STEP3:
        $fld = $registerForm->getField('uextra_payment_method');
        $fld->setOptionListTagAttribute('class', 'links-inline');
        $fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];
        $fld->developerTags['rdHtmlAfterRadio'] = '<i class="input-helper"></i>';

        $checkPayeeNameFld = $registerForm->getField('uextra_cheque_payee_name');
        $checkPayeeNameFld->setWrapperAttribute('class', 'cheque_payment_method_fld');

        $bankNameFld = $registerForm->getField('ub_bank_name');
        $bankNameFld->setWrapperAttribute('class', 'bank_payment_method_fld');

        $bankSwiftCodeFld = $registerForm->getField('ub_ifsc_swift_code');
        $bankSwiftCodeFld->setWrapperAttribute('class', 'bank_payment_method_fld');

        $bankAccountNameFld = $registerForm->getField('ub_account_holder_name');
        $bankAccountNameFld->setWrapperAttribute('class', 'bank_payment_method_fld');

        $bankAccountNumberFld = $registerForm->getField('ub_account_number');
        $bankAccountNumberFld->setWrapperAttribute('class', 'bank_payment_method_fld');

        $bankAddressFld = $registerForm->getField('ub_bank_address');
        $bankAddressFld->setWrapperAttribute('class', 'bank_payment_method_fld');

        $PayPalEmailIdFld = $registerForm->getField('uextra_paypal_email_id');
        $PayPalEmailIdFld->setWrapperAttribute('class', 'paypal_payment_method_fld');

    ?>
        <script>
            $("document").ready(function() {
                var AFFILIATE_PAYMENT_METHOD_CHEQUE = '<?php echo User::AFFILIATE_PAYMENT_METHOD_CHEQUE; ?>';
                var AFFILIATE_PAYMENT_METHOD_BANK = '<?php echo User::AFFILIATE_PAYMENT_METHOD_BANK; ?>';
                var AFFILIATE_PAYMENT_METHOD_PAYPAL = '<?php echo User::AFFILIATE_PAYMENT_METHOD_PAYPAL; ?>';

                var uextra_payment_method = '<?php echo (isset($userExtraData['uextra_payment_method']) && $userExtraData['uextra_payment_method'] > 0) ? $userExtraData['uextra_payment_method'] : User::AFFILIATE_PAYMENT_METHOD_CHEQUE; ?>';

                $("input[name='uextra_payment_method']").change(function() {
                    if ($(this).val() == AFFILIATE_PAYMENT_METHOD_CHEQUE) {
                        callChequePaymentMethod();
                    }

                    if ($(this).val() == AFFILIATE_PAYMENT_METHOD_BANK) {
                        callBankPaymentMethod();
                    }

                    if ($(this).val() == AFFILIATE_PAYMENT_METHOD_PAYPAL) {
                        callPayPalPaymentMethod();
                    }
                });


                if (uextra_payment_method == AFFILIATE_PAYMENT_METHOD_CHEQUE) {
                    callChequePaymentMethod();
                }
                if (uextra_payment_method == AFFILIATE_PAYMENT_METHOD_BANK) {
                    callBankPaymentMethod();
                }
                if (uextra_payment_method == AFFILIATE_PAYMENT_METHOD_PAYPAL) {
                    callPayPalPaymentMethod();
                }

            });

            function callChequePaymentMethod() {
                $(".cheque_payment_method_fld").show();
                $(".bank_payment_method_fld").hide();
                $(".paypal_payment_method_fld").hide();
            }

            function callBankPaymentMethod() {
                $(".cheque_payment_method_fld").hide();
                $(".bank_payment_method_fld").show();
                $(".paypal_payment_method_fld").hide();
            }

            function callPayPalPaymentMethod() {
                $(".cheque_payment_method_fld").hide();
                $(".bank_payment_method_fld").hide();
                $(".paypal_payment_method_fld").show();
            }
        </script>
<?php

        break;

    case UserAuthentication::AFFILIATE_REG_STEP4:
        $FldSuccessHtml = $registerForm->getField('affiliate_success_html');
        $FldSuccessHtml->value = '<div class="thanks-screen text-center">   <div class="success-animation">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle>
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
        </svg>
    </div>
		<h2>' . Labels::getLabel('LBL_Congratulations', $siteLangId) . '!!</h2>
		<p>' . $successMsg . ' </p>
		 </div>';
        break;
}
?>
<div class="registeration-process">
    <ul>
        <?php
        if ($registerStepsArr) {
            foreach ($registerStepsArr as $key => $val) {
                $onClickString = false;
                $cls = ($key == $affiliate_register_step_number) ? 'is--active' : '';
                if ($affiliate_register_step_number == $key && $key != UserAuthentication::AFFILIATE_REG_STEP4) {
                    $onClickString = 'onClick="callAffilitiateRegisterStep(' . $key . ')"';
                }
                echo '<li class="' . $cls . '"><a href="javascript:void(0)" ' . $onClickString . ' title="' . $val . '">' . $val . '</a></li>';
            }
        }
        ?>
    </ul>
</div>
<?php
$btnSubmitFld = $registerForm->getField('btn_submit');
if (null != $btnSubmitFld) {
    $btnSubmitFld->developerTags['noCaptionTag'] = true;
    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');
}
echo $registerForm->getFormHtml(); ?>