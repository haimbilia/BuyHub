<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute( 'class', 'form form--horizontal' );
$frm->setFormTagAttribute('onsubmit', 'setupReviewAbuse(this);return false;');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Report_Abuse', $siteLangId); ?></h5>
</div>
<div class="modal-body">
	<?php echo $frm->getFormHtml(); ?>
</div>
