<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12; 

$fld = $frm->getField('ucp_functional');
$fld->setFieldTagAttribute('disabled', 'disabled');

$fld = $frm->getField('ucp_statistical');
$fld->setFieldTagAttribute('disabled', 'disabled');

$fld = $frm->getField('ucp_personalized');
$fld->setFieldTagAttribute('disabled', 'disabled');

?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_Cookies_Preferences',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">      
	  <div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0)" onclick="userForm(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<li><a href="javascript:void(0)" onclick="addBankInfoForm(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_Bank_Info',$adminLangId); ?></a></li>
			<li><a href="javascript:void(0)" onclick="addUserAddress(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_Addresses',$adminLangId); ?></a></li>
            <li><a class="active" href="javascript:void(0)" onclick="displayCookiesPerferences(<?php echo $user_id ?>);"><?php echo Labels::getLabel('LBL_Cookies_Preferences',$adminLangId); ?></a></li>							
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $frm->getFormHtml(); ?>
			</div>
		</div>						
	</div>
	</div>						
</section>
