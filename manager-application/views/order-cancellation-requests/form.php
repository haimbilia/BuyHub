<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayLangTab =  false;
$includeTabs =  false;
$formTitle =  Labels::getLabel('LBL_ORDER_CANCELLATION_REQUEST_UPDATE', $siteLangId);

$frm->getField('ocrequest_status')->setFieldTagAttribute('id','ocrequest_status');

$ocrequestRefundInWallet = $frm->getField('ocrequest_refund_in_wallet');
$ocrequestRefundInWallet->setFieldTagAttribute('id','ocrequest_refund_in_wallet');
$ocrequestRefundInWallet->setFieldTagAttribute('disabled',true);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<script>
	$('#ocrequest_status').change(function(){
		if('1' === $(this).val()){
			$('[name="ocrequest_refund_in_wallet"]').attr('disabled', false);
		} else {
			$('[name="ocrequest_refund_in_wallet"]').attr('disabled', true).val(0);
		}
	});
</script>