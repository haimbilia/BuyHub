<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="modal-header">
	<h5 class="modal-title">
		<?php echo Labels::getLabel('LBL_DESCRIPTION', $siteLangId); ?>
	</h5>
</div>
<div class="modal-body form-edit layoutsJs">
	<div class="form-edit-body loaderContainerJs">
		<div class="row">
			<div class="col-md-12">
				<?php echo $description; ?>
			</div>
		</div>
	</div>
</div>