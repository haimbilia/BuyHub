<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_OPTION_SETUP', $langId); ?></h5>
</div>
<div class="modal-body form-edit">
	<div class="form-edit-body loaderContainerJs">
		<div id="loadForm"><?php echo Labels::getLabel('LBL_LOADING', $langId); ?></div>
		<?php if ($option_id > 0) { ?>
			<hr class="dotted">
			<div class="row">
				<div class="col-md-12" id="showHideContainer">
					<section>
						<div class="section-head">
							<div class="section__heading">
								<h6>
									<?php echo Labels::getLabel('LBL_OPTIONS_LISTING', $langId); ?>
								</h6>
							</div>
							<div class="section__action">
								<a href="javascript:void(0)" class="btn btn-outline-brand btn-sm" onclick="optionValueForm(<?php echo $option_id; ?>,0)" ;>
									<?php echo Labels::getLabel('LBL_ADD_NEW', $langId); ?>
								</a>
							</div>
						</div>
						<div class="tablewrap">
							<div id="optionValueListing"></div>
						</div>
					</section>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>