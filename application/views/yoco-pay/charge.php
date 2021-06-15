<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php foreach($externalLibraries as $url){ ?>
<script type="text/javascript" src="<?php echo $url;?>"></script>
<?php } ?>
<?php $frm->setFormTagAttribute('onsubmit', 'confirmOrder(); return(false);');
$frm->setFormTagAttribute('id', 'paymentForm');
?>
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
            <?php echo $frm->getFormTag(); ?>
            <div class="payable-form__body">
                <div class="row">
                    <div class="col-md-12" id="card_frame">
                        
                    </div>
                </div>
            </div>
            <div class="payable-form__footer mt-4">
                <div class="row">
                    <div class="col-md-6">                                    
                        <?php
                        $btn = $frm->getField('btn_submit');
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
            <?php echo $frm->getExternalJs(); ?>
            </form>
        </div>
    </div>        
</section>
<script type="text/javascript">
    var sdk = new window.YocoSDK({
        publicKey: '<?php echo $publicKey; ?>'
    });
    var inline = sdk.inline({
        layout: 'basic',
        amountInCents: <?php echo $paymentAmount; ?>,
        currency: '<?php echo $orderInfo["order_currency_code"]; ?>'
    });
    inline.mount('#card_frame');

    function confirmOrder() {
        var btnEle = $("#paymentForm input[type='submit']");
        var btnText = btnEle.val();
        btnEle.val(btnEle.data('processing-text')).attr('disabled', 'disabled');
  
        inline.createToken().then(function (result) {
            if (result.error) {           
                btnEle.val(btnText).removeAttr('disabled');
                const errorMessage = result.error.message;
                errorMessage && $.systemMessage(errorMessage, 'alert--danger', false);
            } else {
                $.mbsmessage(langLbl.processing, false, 'alert--process alert');
                fcom.updateWithAjax(fcom.makeUrl('YocoPay', 'chargeCard', ['<?php echo $orderInfo["id"]; ?>']), {token: result.id}, function (t) {
                    btnEle.val(btnText).removeAttr('disabled');
                    if (t.status == 1) {
                        window.location.href = t.redirectUrl;
                    }
                });
            }
        }).catch(function (error) {         
            $.systemMessage(error, 'alert--danger');
            btnEle.val(btnText).removeAttr('disabled');
        });

    }

</script>