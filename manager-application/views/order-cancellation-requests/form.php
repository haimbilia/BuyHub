<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayLangTab =  false;
$formTitle =  Labels::getLabel('LBL_ORDER_CANCELLATION_REQUEST_UPDATE', $siteLangId);


$frm->getField('ocrequest_status')->setFieldTagAttribute('id','ocrequest_status');

$frm->getField('ocrequest_refund_in_wallet')->setWrapperAttribute('class','wrapper-ocrequest_refund_in_wallet hide');
$frm->getField('ocrequest_admin_comment')->setWrapperAttribute('class','wrapper-ocrequest_admin_comment hide');

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
?>
<script>

	$('[name="ocrequest_refund_in_wallet"]').change(function(){
		if($(this).val() == 1){
			$('.wrapper-ocrequest_admin_comment').removeClass('hide');
		} else{
			$('.wrapper-ocrequest_admin_comment').addClass('hide');
		}
	});
	
	$('#ocrequest_status').change(function(){
		if($(this).val() === '1'){
			$('.wrapper-ocrequest_refund_in_wallet').removeClass('hide');
			$('#ocrequest_refund_in_wallet').change();
		} else{
			$('.wrapper-ocrequest_refund_in_wallet').addClass('hide');
			$('.wrapper-ocrequest_admin_comment').addClass('hide');
		}
	});

	$('name="btn_reset_form"').hide();
</script>