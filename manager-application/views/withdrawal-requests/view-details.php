<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo  Labels::getLabel('LBL_VIEW_DETAILS', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body">
        <table class="table">
            <?php if($details['withdrawal_payment_method'] ==  User::AFFILIATE_PAYMENT_METHOD_CHEQUE) { ?>
                <div class='row border-bottom py-2 border-light'>
                    <div class='col-md-5'><?php echo Labels::getLabel('LBL_CHEQUE_PAYEE_NAME', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_cheque_payee_name'] ;?></div>
                </div>
            <?php } ?>
            <?php if($details['withdrawal_payment_method'] ==  User::AFFILIATE_PAYMENT_METHOD_BANK) { ?>
                <div class='row border-bottom py-2 border-light'>
                <div class='col-md-5'><?php echo Labels::getLabel('LBL_BANK_NAME', $siteLangId);?> :</div>
                <div class='col-md-7'><?php echo $details['withdrawal_bank'] ;?></div>
                </div>
                <div class='row border-bottom py-2 border-light'>
                <div class='col-md-5'><?php echo Labels::getLabel('LBL_A/C_NAME', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_account_holder_name'] ;?></div>
                </div>
                <div class='row border-bottom py-2 border-light'>
                <div class='col-md-5'><?php echo Labels::getLabel('LBL_A/C_NUMBER', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_account_number'] ;?></div>
                </div>
                <div class='row border-bottom py-2 border-light'>
                <div class='col-md-5'><?php echo Labels::getLabel('LBL_IFSC_CODE/SWIFT_CODE', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_ifc_swift_code'] ;?></div>
                </div>
                <div class='row border-bottom py-2 border-light'>
                <div class='col-md-5'><?php echo Labels::getLabel('LBL_BANK_ADDRESS', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_bank_address'] ;?></div>
                </div>
            <?php } ?>
            <?php if($details['withdrawal_payment_method'] ==  User::AFFILIATE_PAYMENT_METHOD_PAYPAL) { ?>
                <div class='row border-bottom py-2 border-light'>
                <div class='col-md-5'><?php echo Labels::getLabel('LBL_PAYPAL_EMAIL_ACCOUNT', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_paypal_email_id'] ;?></div>
                </div>
            <?php } ?>
           
            <?php
                if (!empty($details['payout_detail'])) {
                    foreach (explode(',', $details["payout_detail"]) as $data) {
                        $data = explode(':', $data);
						if (!empty($data) && isset($data[1]) && !empty($data[1])) {
                        ?>
							<div class='row border-bottom py-2 border-light'>
                                <div class='col-md-5'><?php echo ucwords(str_replace('_', ' ', $data[0])) ?>: </div>
                                <div class='col-md-7'><?php echo  $data[1] ;?></div>
                            </div>
                        <?php
						}
                    }
                }
                if (!empty($details["withdrawal_instructions"])) { ?>
                    <div class='row border-bottom py-2 border-light'>
                        <div class='col-md-5'><?php echo Labels::getLabel('LBL_INSTRUCTIONS', $siteLangId) ;?> </div>
                        <div class='col-md-7'><?php echo  $row['withdrawal_instructions'];?></div>
                    </div>
                <?php
                }
            ?>
            <?php if(!empty($details['withdrawal_comments'])) { ?>
                <div class='row'>
                    <div class='col-md-5'><?php echo Labels::getLabel('LBL_Comments', $siteLangId);?> :</div>
                    <div class='col-md-7'><?php echo $details['withdrawal_comments'] ;?></div>
                </div>
            <?php } ?>
        </table>

    </div>
</div>