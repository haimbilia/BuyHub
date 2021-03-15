<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if($user_id > 0){
	$fld_credential_username = $frmUser->getField('credential_username');
	$fld_credential_username->setFieldTagAttribute('disabled','disabled');

	$user_email = $frmUser->getField('credential_email');
	$user_email->setFieldTagAttribute('disabled','disabled');	
    $user_email->setFieldTagAttribute('id', 'user-email');
    $user_email->setFieldTagAttribute('data-value', $data['credential_email']);
    $user_email->setFieldTagAttribute('data-encrypted-value', CommonHelper::displayEncryptedEmail($data['credential_email']));
    $user_email->htmlAfterField = '<span toggle="#user-email" onClick ="toggleEncryptedFields(this)" class="fa js-toggle-data fa-eye"></span>';
}

$frmUser->developerTags['colClassPrefix'] = 'col-md-';
$frmUser->developerTags['fld_default_col'] = 12;	

$frmUser->setFormTagAttribute('class', 'web_form form_horizontal');
$frmUser->setFormTagAttribute('onsubmit', 'setupUsers(this); return(false);');


$dobFld = $frmUser->getField('user_dob');
$dobFld->setFieldTagAttribute('class','user_dob_js');
if(!empty($data['user_dob']) && $data['user_dob'] != '0000-00-00'){
    $dobFld->setFieldTagAttribute('id', 'user-dob');
    $dobFld->setFieldTagAttribute('data-value', $data['user_dob']);
    $dobFld->setFieldTagAttribute('data-encrypted-value', CommonHelper::displayEncryptedDob($data['user_dob']));
    $dobFld->htmlAfterField = '<span toggle="#user-dob" onClick ="toggleEncryptedFields(this,1)" class="fa js-toggle-data fa-eye"></span>';
}

if(!empty($data['user_phone'])){
    $phoneFld = $frmUser->getField('user_phone');
    $phoneFld->setFieldTagAttribute('id', 'user-phone');
    $phoneFld->setFieldTagAttribute('data-value', $data['user_phone']);
    $phoneFld->setFieldTagAttribute('data-encrypted-value', CommonHelper::displayEncryptedFieldData($data['user_phone']));
    $phoneFld->htmlAfterField = '<span toggle="#user-phone" onClick ="toggleEncryptedFields(this, 1, 1)" class="fa js-toggle-data fa-eye"></span>';
}

$countryFld = $frmUser->getField('user_country_id');
$countryFld->setFieldTagAttribute('id','user_country_id');
$countryFld->setFieldTagAttribute('onChange','getCountryStates(this.value,'.$stateId.',\'#user_state_id\')');

$stateFld = $frmUser->getField('user_state_id');
$stateFld->setFieldTagAttribute('id','user_state_id');

?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_User_Setup',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">      
		<div class="tabs_nav_container responsive flat">
			<ul class="tabs_nav">
				<li><a class="active" href="javascript:void(0)" onclick="userForm(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
				<?php if($userParent == 0) { ?>
					<li><a href="javascript:void(0)" onclick="addBankInfoForm(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_Bank_Info',$adminLangId); ?></a></li>
					<li><a href="javascript:void(0)" onclick="addUserAddress(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_Addresses',$adminLangId); ?></a></li>
				<?php }?>
                <li><a href="javascript:void(0)" onclick="displayCookiesPerferences(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_Cookies_Preferences',$adminLangId); ?></a></li>	
			</ul>
			<div class="tabs_panel_wrap">
				<div class="tabs_panel">
					<?php echo $frmUser->getFormHtml(); ?>
				</div>
			</div>						
		</div>
	</div>						
</section>	
<script language="javascript">
	$(document).ready(function(){
		getCountryStates($( "#user_country_id" ).val(),<?php echo $stateId ;?>,'#user_state_id');
		$('.user_dob_js').datepicker('option', {maxDate: new Date()});
        
        toggleEncryptedFields = function(element, handleDisabled = 0, handleValidations = 0){
            $(element).toggleClass("fa-eye fa-eye-slash");
            var input = $($(element).attr("toggle"));            
            if ($(element).hasClass('fa-eye')) {
                input.val(input.attr('data-value'));
                if(handleDisabled == 1){
                    input.removeAttr('disabled');                    
                }
                if(handleValidations == 1){
                    input.attr('data-fatreq', input.attr('data-validations'));
                }
            } else {
                input.val(input.attr('data-encrypted-value'));
                if(handleDisabled == 1){
                    input.attr('disabled', 'disabled');                    
                }
                if(handleValidations == 1){
                    var validations = input.attr('data-fatreq');
                    input.attr('data-validations', validations);
                    input.attr('data-fatreq', '');
                }
            }
        }
        
        $('.js-toggle-data').trigger('click');
        
	});	
</script>