<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form addUpdateForm--js');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');

$fld = $frm->getField('btn_clear');
$fld->addFieldTagAttribute('onclick', 'clearForm();');

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
	$icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $badgeId, 0, $adminLangId);
	$uploadedTime = AttachedFile::setTimeParam($icon['afile_updated_at']);
	$imageHtml = '<img src="' . UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'badgeIcon', array($icon['afile_record_id'], $icon['afile_lang_id'], "THUMB", $icon['afile_screen']), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . '" title="' . $badgeName . '" alt="' . $badgeName . '">';
} else {
    $ribbon = $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $badgeData], false, true);
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
					echo $frm->getFieldHtml('record_condition');

					if (0 < $blinkcond_id) {
						echo $frm->getFieldHtml('blinkcond_record_type');
					}
					
					$sellerFld = $frm->getField('seller');

					$firstRowCol = (Badge::TYPE_RIBBON == $badgeType && 1 > $sellerId) ? '3' : '4';
				?>
				<div class="row">
					<?php if (null != $sellerFld) { 
						echo $frm->getFieldHtml('blinkcond_user_id');
						if (1 > $sellerId) {?>
						<div class="col-md-<?php echo $firstRowCol; ?>">
							<div class="field-set">
									<div class="caption-wraper">
										<label class="field_label">
											<?php
											$fld = $frm->getField('seller');
											echo $fld->getCaption();
											?>
											<span class="spn_must_field">*</span></label>
									</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('seller'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php }
					} ?>
					<?php if (Badge::TYPE_RIBBON == $badgeType) { ?>
						<div class="col-md-<?php echo (1 > $blinkcond_id) ? '3' : '4'; ?> position--js">
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
					<div class="col-md-<?php echo $firstRowCol; ?>">
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
					<div class="col-md-<?php echo $firstRowCol; ?>">
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
					<?php if (1 > $blinkcond_id) { ?>
						<div class="col-md-4">
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
					<?php } ?>
                    <?php if (BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType || 1 > $recordType) { ?>
                        <div class="col-md-<?php echo (1 > $blinkcond_id) ? '8' : '12'; ?>">
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
                    <?php } ?>
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
										$fld = $frm->getField('blinkcond_condition_from');
										echo $fld->getCaption();
										?>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('blinkcond_condition_from'); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('blinkcond_condition_to');
										echo $fld->getCaption();
										?>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('blinkcond_condition_to'); ?>
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