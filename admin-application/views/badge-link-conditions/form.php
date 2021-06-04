<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form addUpdateForm--js');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;

$fld = $frm->getField('auto_update_other_langs_data');
if (null != $fld) {
	$fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
	$fld->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
}

$fld = $frm->getField('blinkcond_condition_from');
if (null != $fld) {
	$fld->developerTags['colClassPrefix'] = 'col-md-';
	$fld->developerTags['col'] = 3;
}

$fld = $frm->getField('blinkcond_condition_to');
if (null != $fld) {
	$fld->developerTags['colClassPrefix'] = 'col-md-';
	$fld->developerTags['col'] = 3;
}

$fld = $frm->getField('blinkcond_position');
if (null != $fld) {
	$fld->developerTags['colClassPrefix'] = 'col-md-';
	$fld->developerTags['col'] = 3;
	$fld->setWrapperAttribute( 'class' , 'position--js');
}

$fld = $frm->getField('badgelink_record_id');
if (null != $fld) {
	$fld->developerTags['colClassPrefix'] = 'col-md-';
	$fld->developerTags['col'] = 9;
	$fld->htmlAfterField = '<div class="recordsContainer--js p-0 box--scroller"></div>';
}

$fld = $frm->getField('blinkcond_condition_type');
if (null != $fld) {
 	$fld->setWrapperAttribute( 'class' , 'conditionType--js');
}
$fld = $frm->getField('blinkcond_record_type');
if (null != $fld) {
 	$fld->setWrapperAttribute( 'class' , 'linkType--js');	
}
?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_BADGES_&_RIBBONS_LINKS_SETUP', $adminLangId); ?></h4>
		<div class="section__toolbar">
			<a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>
		</div>
	</div>
	<div class="sectionbody space">
		<div class="row justify-content-center">
			<div class="col-md-8"><?php echo $frm->getFormHtml(); ?></div>
		</div>
	</div>
	<div class="foo"></div>
</section>