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

$fld = $frm->getField('badge_name');
if (null != $fld && !empty($rowData)) {
    $fld->setFieldTagAttribute('data-val', $rowData['badgelink_badge_id']);
    $fld->setFieldTagAttribute('data-text', $rowData['badge_name']);
}

$fld = $frm->getField('record_name');
if (null != $fld && !empty($rowData)) {
	$recordName = $rowData['record_name'];
	if (BadgeLink::RECORD_TYPE_SELLER_PRODUCT == $recordType && !empty($rowData['option_names'])) {
		foreach (explode(',', $rowData['option_names']) as $index => $optionName) {
			$optionValues = explode(',', $rowData['option_value_names']);
			$recordName .= ' | ' . $optionName . ' : ' . $optionValues[$index];
		}
		$recordName .= ' | ' . $rowData['seller'];
	}
	
    $fld->setFieldTagAttribute('data-val', $rowData['badgelink_record_id']);
    $fld->setFieldTagAttribute('data-text', $recordName);
}
?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_BADGE_LINKS_SETUP', $adminLangId); ?></h4>
		<div class="section__toolbar">
			<a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>
		</div>
	</div>
	<div class="sectionbody space">
		<div class="row justify-content-center">
			<div class="col-md-8"><?php echo $frm->getFormHtml();?></div>
		</div>
	</div>
</section>

<script>
	var RECORD_TYPE_PRODUCT = <?php echo BadgeLink::RECORD_TYPE_PRODUCT; ?>;
	var RECORD_TYPE_SELLER_PRODUCT = <?php echo BadgeLink::RECORD_TYPE_SELLER_PRODUCT; ?>;
	var RECORD_TYPE_SHOP = <?php echo BadgeLink::RECORD_TYPE_SHOP; ?>;

	var CONDITION_TYPE_DATE = <?php echo BadgeLink::CONDITION_TYPE_DATE; ?>;
</script>