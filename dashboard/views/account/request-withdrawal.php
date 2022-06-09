<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$col = 6;
if (User::isAffiliate()) {
    $col = 12;
}
HtmlHelper::formatFormFields($frm, $col);
$frm->setFormTagAttribute('data-onclear', 'withdrawalOptionsForm();');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'setupWithdrawalReq(this); return(false);');

$fld = $frm->getField('payout');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
    $fld->addFieldTagAttribute('onchange', 'withdrawalOptionsForm(this.value)');
}

$fld = $frm->getField('withdrawal_amount');
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

$ifscFld = $frm->getField('ub_ifsc_swift_code');
$ifscFld->setWrapperAttribute('class', 'col-sm-12');
$ifscFld->developerTags['col'] = 12;

if (User::isAffiliate()) {
    $paymentMethodFld = $frm->getField('uextra_payment_method');
    $paymentMethodFld->setOptionListTagAttribute('class', 'radio');
    $paymentMethodFld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];
    $paymentMethodFld->setWrapperAttribute('class', 'col-lg-12');
    $paymentMethodFld->developerTags['col'] = 12;

    $checkPayeeNameFld = $frm->getField('uextra_cheque_payee_name');
    $checkPayeeNameFld->setWrapperAttribute('class', 'cheque_payment_method_fld');

    $bankNameFld = $frm->getField('ub_bank_name');
    $bankNameFld->setWrapperAttribute('class', 'bank_payment_method_fld');

    $bankAccountNameFld = $frm->getField('ub_account_holder_name');
    $bankAccountNameFld->setWrapperAttribute('class', 'bank_payment_method_fld');

    $bankAccountNumberFld = $frm->getField('ub_account_number');
    $bankAccountNumberFld->setWrapperAttribute('class', 'bank_payment_method_fld');

    $bankSwiftCodeFld = $frm->getField('ub_ifsc_swift_code');
    $bankSwiftCodeFld->setWrapperAttribute('class', 'bank_payment_method_fld');

    $bankAddressFld = $frm->getField('ub_bank_address');
    $bankAddressFld->setWrapperAttribute('class', 'bank_payment_method_fld');

    $PayPalEmailIdFld = $frm->getField('uextra_paypal_email_id');
    $PayPalEmailIdFld->setWrapperAttribute('class', 'paypal_payment_method_fld');
}

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_REQUEST_WITHDRAWAL', $siteLangId); ?>
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
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<?php if (User::isAffiliate()) { ?>
    <script type="text/javascript">
        $("document").ready(function() {
            var AFFILIATE_PAYMENT_METHOD_CHEQUE = '<?php echo User::AFFILIATE_PAYMENT_METHOD_CHEQUE; ?>';
            var AFFILIATE_PAYMENT_METHOD_BANK = '<?php echo User::AFFILIATE_PAYMENT_METHOD_BANK; ?>';
            var AFFILIATE_PAYMENT_METHOD_PAYPAL = '<?php echo User::AFFILIATE_PAYMENT_METHOD_PAYPAL; ?>';
            var uextra_payment_method = '<?php echo $uextra_payment_method ?>';
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
<?php } ?>