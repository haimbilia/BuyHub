<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$this->includeTemplate('_partial/affiliate/affiliateDashboardNavigation.php');
$frm->setFormTagAttribute('id', 'bankInfoFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;
$frm->setFormTagAttribute('onsubmit', 'setUpAffiliatePaymentInfo(this); return(false);');

$radioFld = $frm->getField('uextra_payment_method');
$radioFld->setWrapperAttribute('class', 'col-lg-12');
$radioFld->developerTags['col'] = 12;

$checkPayeeNameFld = $frm->getField('uextra_cheque_payee_name');
$checkPayeeNameFld->setWrapperAttribute('class', 'cheque_payment_method_fld d-none');

$bankNameFld = $frm->getField('ub_bank_name');
$bankNameFld->setWrapperAttribute('class', 'bank_payment_method_fld d-none');

$bankAccountNameFld = $frm->getField('ub_account_holder_name');
$bankAccountNameFld->setWrapperAttribute('class', 'bank_payment_method_fld d-none');

$bankAccountNumberFld = $frm->getField('ub_account_number');
$bankAccountNumberFld->setWrapperAttribute('class', 'bank_payment_method_fld d-none');

$bankSwiftCodeFld = $frm->getField('ub_ifsc_swift_code');
$bankSwiftCodeFld->setWrapperAttribute('class', 'bank_payment_method_fld d-none');

$bankSwiftCodeFld = $frm->getField('ub_bank_address');
$bankSwiftCodeFld->setWrapperAttribute('class', 'bank_payment_method_fld d-none');

$PayPalEmailIdFld = $frm->getField('uextra_paypal_email_id');
$PayPalEmailIdFld->setWrapperAttribute('class', 'paypal_payment_method_fld d-none');

$submitFld = $frm->getField('btn_submit');
$submitFld->developerTags['noCaptionTag'] = true;
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-wide');
?>
<div class="content-wrapper content-space">
    <?php
    $data = [
        'headingLabel' => Labels::getLabel('LBL_PAYMENT_INFORMATION', $siteLangId),
        'siteLangId' => $siteLangId,
    ];

    $this->includeTemplate('_partial/header/content-header.php', $data); ?>
    <div class="content-body">
        <div class="card card-tabs">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <?php echo $frm->getFormHtml(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("document").ready(function() {
        var AFFILIATE_PAYMENT_METHOD_CHEQUE = '<?php echo User::AFFILIATE_PAYMENT_METHOD_CHEQUE; ?>';
        var AFFILIATE_PAYMENT_METHOD_BANK = '<?php echo User::AFFILIATE_PAYMENT_METHOD_BANK; ?>';
        var AFFILIATE_PAYMENT_METHOD_PAYPAL = '<?php echo User::AFFILIATE_PAYMENT_METHOD_PAYPAL; ?>';

        var uextra_payment_method = '<?php echo $userExtraData['uextra_payment_method']; ?>';

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
        $(".cheque_payment_method_fld").removeClass('d-none');
        $(".paypal_payment_method_fld, .bank_payment_method_fld").addClass('d-none');
    }

    function callBankPaymentMethod() {
        $(".bank_payment_method_fld").removeClass('d-none');
        $(".paypal_payment_method_fld, .cheque_payment_method_fld").addClass('d-none');
    }

    function callPayPalPaymentMethod() {
        $(".paypal_payment_method_fld").removeClass('d-none');
        $(".bank_payment_method_fld, .cheque_payment_method_fld").addClass('d-none');
    }
</script>