<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form addUpdateForm--js');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');

$fld = $frm->getField('auto_update_other_langs_data');
if (null != $fld) {
	$fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
	$fld->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
}

$fld = $frm->getField('record_condition');
if (null != $fld) {
	$fld->addFieldTagAttribute('class', 'recCond--js');
}
$badgeName = $badgeData['badge_name'];
if (Badge::TYPE_BADGE == $badgeType) {
	$icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $badgeId, 0, 0, false);
	$uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
	$imageHtml = '<img src="' . UrlHelper::getCachedUrl(UrlHelper::generateUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" title="' . $badgeName . '" alt="' . $badgeName . '">';
} else {
	$ribbRow = $badgeData;
	include CONF_THEME_PATH . '/_partial/get-ribbon.php';
	$imageHtml = '<div class="badge-wrap">' . $ribbon . '</div>';
}

?>
<section class="section">
	<div class="sectionhead">
		<h4>
			<?php 
			echo $badgeName . ' ' . Labels::getLabel('LBL_CONDITION_SETUP_FORM', $adminLangId);
			?>
		</h4>
		<div class="section__toolbar">
			<a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>
		</div>
	</div>
	<div class="sectionbody space">
		<div class="row justify-content-center">
			<div class="col-md-2 badgeImageSection--js"><?php echo $imageHtml; ?></div>
			<div class="col-md-8">
				<?php echo $frm->getFormTag(); 
					echo $frm->getFieldHtml('blinkcond_id');
					echo $frm->getFieldHtml('blinkcond_badge_id');
					echo $frm->getFieldHtml('record_ids');
					echo $frm->getFieldHtml('badge_type');
					if (Badge::TYPE_RIBBON == $badgeType) {
						echo $frm->getFieldHtml('record_condition');
					}
				?>
				<div class="row">
					<?php if (Badge::TYPE_BADGE == $badgeType) { ?>
						<div class="col-md-4">
							<div class="field-set">
									<div class="caption-wraper">
										<label class="field_label">
											<?php
											$fld = $frm->getField('record_condition');
											echo $fld->getCaption();
											?>
											<span class="spn_must_field">*</span></label>
									</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('record_condition'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } else if (Badge::TYPE_RIBBON == $badgeType) { ?>
						<div class="col-md-4 position--js">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('blinkcond_position');
										echo $fld->getCaption();
										?>
										<span class="spn_must_field">*</span></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('blinkcond_position'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<div class="col-md-4">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<?php
									$fld = $frm->getField('blinkcond_from_date');
									echo $fld->getCaption();
									?>
								</label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('blinkcond_from_date'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<?php
									$fld = $frm->getField('blinkcond_to_date');
									echo $fld->getCaption();
									?>
								</label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('blinkcond_to_date'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row linkType--js">
					<div class="col-md-3">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<?php
									$fld = $frm->getField('blinkcond_record_type');
									echo $fld->getCaption();
									?>
								</label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('blinkcond_record_type'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<?php
									$fld = $frm->getField('badgelink_record_id');
									echo $fld->getCaption();
									?>
								</label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('badgelink_record_id'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if (Badge::TYPE_BADGE == $badgeType) { ?>
					<div class="row conditionType--js">
						<div class="col-md-4">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('blinkcond_condition_type');
										echo $fld->getCaption();
										?>
										<span class="spn_must_field">*</span></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('blinkcond_condition_type'); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('blinkcond_from_value');
										echo $fld->getCaption();
										?>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('blinkcond_from_value'); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('blinkcond_to_value');
										echo $fld->getCaption();
										?>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('blinkcond_to_value'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-6">
						<div class="field-set">
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('btn_submit'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>
				<?php echo $frm->getExternalJS(); ?>
			</div>
		</div>
	</div>
</section>