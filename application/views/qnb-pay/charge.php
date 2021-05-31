<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<section class="payment-section">
    <div class="payable-amount">

        <div class="payable-amount__head">
            <div class="payable-amount--header">              
                <?php $this->includeTemplate('_partial/paymentPageLogo.php', array('siteLangId' => $siteLangId)); ?>
            </div>
            <div class="payable-amount--decription">
                <h2><?php echo CommonHelper::displayMoneyFormat($paymentAmount) ?></h2>
                <p><?php echo Labels::getLabel('LBL_Total_Payable', $siteLangId); ?></p>
                <p><?php echo Labels::getLabel('LBL_Order_Invoice', $siteLangId); ?>: <?php echo $orderInfo["invoice"]; ?></p>
            </div>
        </div>
        <div class="payable-amount__body payment-from">
            <?php
            if (!isset($error)) :
                ?>
                <?php echo $frm->getFormTag(); ?>
                <div class="payable-form__body">
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo Labels::getLabel('MSG_CONFIRM_TO_PROCEED_FOR_PAYMENT_?', $siteLangId); ?></p>
                            <?php foreach($frm->getAllFields() as $formField){
                                    $fldName = $formField->getName();
                                    if($formField->fldType=='submit'){
                                        continue;                                        
                                    }
                                    echo $frm->getFieldHtml($fldName);
                            } 
                            ?>
                           
                        </div>
                        <div class="gap"></div>
                    </div>
                </div>
                <div class="payable-form__footer">
                    <div class="row">
                        <div class="col-md-6">                                    
                            <?php
                            $btn = $frm->getField('btn_submit');
                            $btn->addFieldTagAttribute('onclick', 'razorpaySubmit(this)');
                            $btn->addFieldTagAttribute('class', 'btn btn-secondary');
                            $btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));
                            echo $frm->getFieldHtml('btn_submit');
                            ?> 
                        </div>
                        <div class="col-md-6 d-md-block d-none">
                             <a href="<?php echo $cancelBtnUrl; ?>" class="btn btn-outline-gray"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>                       
                        </div>
                    </div>  
                </div>
                </form>
            <?php else : ?>
                <div class="alert alert--danger"><?php echo $error ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
