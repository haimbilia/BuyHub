<div class="modal-header">
	<h5 class="modal-title"><?php echo $data['scatrequest_title']; ?></h5>
</div>
<div class="modal-body form-edit">
	<div class="form-edit-body loaderContainerJs">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="field-set">
						<div class="caption-wraper">
							<label class="field_label">
								<h5><?php echo Labels::getLabel('LBL_Content', $siteLangId); ?></h5>
							</label>
						</div>
						<div class="field-wraper">
							<div class="field_cover">
								<p><?php echo html_entity_decode($data['scatrequest_content'], ENT_QUOTES, 'utf-8'); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if (isset($data['scatrequest_comments']) && $data['scatrequest_comments'] != '') { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<h5><?php echo Labels::getLabel('LBL_Comment', $siteLangId); ?></h5>
								</label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<p><?php echo nl2br($data['scatrequest_comments']); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>