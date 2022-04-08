<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmRechargeWallet->setFormTagAttribute('onSubmit', 'setUpWalletRecharge(this); return false;');
$frmRechargeWallet->setFormTagAttribute('class', 'form form-apply');
$frmRechargeWallet->developerTags['colClassPrefix'] = 'col-md-';
$frmRechargeWallet->developerTags['fld_default_col'] = 12;

$amountFld = $frmRechargeWallet->getField('amount');
$amountFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_ENTER_AMOUNT', $siteLangId));
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_RECHARGE_YOUR_WALLET', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php 
            echo $frmRechargeWallet->getFormTag();
            echo $frmRechargeWallet->getFieldHtml('amount');
            echo $frmRechargeWallet->getFieldHtml('btn_submit'); 
            echo '</form>';
            
            echo $frmRechargeWallet->getExternalJs(); ?>
    </div>
</div>