<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo  Labels::getLabel('LBL_VIEW_DETAILS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <ul class="list-stats list-stats-double">
            <?php if ($details['withdrawal_payment_method'] ==  User::AFFILIATE_PAYMENT_METHOD_CHEQUE) { ?>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_CHEQUE_PAYEE_NAME', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_cheque_payee_name']; ?></span>
                </li>
            <?php } ?>
            <?php if ($details['withdrawal_payment_method'] ==  User::AFFILIATE_PAYMENT_METHOD_BANK) { ?>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_BANK_NAME', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_bank']; ?></span>
                </li>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_A/C_NAME', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_account_holder_name']; ?></span>
                </li>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_A/C_NUMBER', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_account_number']; ?></span>
                </li>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_IFSC_CODE/SWIFT_CODE', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_ifc_swift_code']; ?></span>
                </li>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_BANK_ADDRESS', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_bank_address']; ?></span>
                </li>
            <?php } ?>
            <?php if ($details['withdrawal_payment_method'] ==  User::AFFILIATE_PAYMENT_METHOD_PAYPAL) { ?>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_PAYPAL_EMAIL_ACCOUNT', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_paypal_email_id']; ?></span>
                </li>
            <?php } ?>

            <?php
            if (!empty($details['payout_detail'])) {
                foreach (explode(',', $details["payout_detail"]) as $data) {
                    $data = explode(':', $data);
                    if (!empty($data) && isset($data[1]) && !empty($data[1])) {
            ?>
                        <li class="list-stats-item">
                            <span class="label"><?php echo ucwords(str_replace('_', ' ', $data[0])) ?>: </span>
                           <span class="value"><?php echo  $data[1]; ?></span>
                        </li>
                <?php
                    }
                }
            }
            if (!empty($details["withdrawal_instructions"])) { ?>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_INSTRUCTIONS', $siteLangId); ?> </span>
                   <span class="value"><?php echo  $row['withdrawal_instructions']; ?></span>
                </li>
            <?php
            }
            ?>
            <?php if (!empty($details['withdrawal_comments'])) { ?>
                <li class="list-stats-item list-stats-item-full">
                    <span class="label"><?php echo Labels::getLabel('LBL_Comments', $siteLangId); ?> :</span>
                   <span class="value"><?php echo $details['withdrawal_comments']; ?></span>
                </li>
            <?php } ?>
        </ul>

    </div>
</div>