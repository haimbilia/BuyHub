<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$fld = $frm->getField('auto_update_other_langs_data');
if (null != $fld) {
	$fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
	$fld->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
}
$fld = $frm->getField('badge_display_inside');
if (null != $fld) {
	$fld->developerTags['cbLabelAttributes'] = array('class' => 'checkbox');
	$fld->developerTags['cbHtmlAfterCheckbox'] = '<i class="input-helper"></i>';
}

$iconLangFld = $frm->getField('icon_lang_id');
if (null != $iconLangFld) {
	$iconLangFld->addFieldTagAttribute('class', 'icon-language-js');
}

$iconFld = $frm->getField('badge_icon');
if (null != $iconFld) {
	$iconFld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
	$iconFld->addFieldTagAttribute('onChange', 'iconPopupImage(this)');
	$iconFld->htmlAfterField = '<small class="text--small">' . sprintf(Labels::getLabel('LBL_This_will_be_displayed_in_%s_on_your_store', $adminLangId), '60*60') . '</small>';
}

?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo (Badge::TYPE_RIBBON == $type) ? Labels::getLabel('LBL_RIBBON_SETUP', $adminLangId) : Labels::getLabel('LBL_BADGE_SETUP', $adminLangId); ?></h4>
		<div class="section__toolbar">
			<a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>
		</div>
	</div>
	<div class="sectionbody space">
		<?php echo $frm->getFormTag();
		echo $frm->getFieldHtml('badge_id');
		echo $frm->getFieldHtml('badge_type');
		if ((Badge::TYPE_BADGE == $type)) {
			echo $frm->getFieldHtml('logo_min_width');
			echo $frm->getFieldHtml('logo_min_height');
			echo $frm->getFieldHtml('attachment_ids');
		}
		?>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="row">
					<?php if (Badge::TYPE_RIBBON == $type) { ?>
						<div class="col-md-6">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('badge_shape_type');
										echo $fld->getCaption();
										?>
										<span class="spn_must_field">*</span></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('badge_shape_type'); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('badge_color');
										echo $fld->getCaption();
										?>
										<span class="spn_must_field">*</span></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('badge_color'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<?php
									$fld = $frm->getField('badge_name[' . $siteDefaultLangId . ']');
									echo $fld->getCaption();
									?>
									<span class="spn_must_field">*</span></label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('badge_name[' . $siteDefaultLangId . ']'); ?>
								</div>
							</div>
						</div>
					</div>
					<?php if (Badge::TYPE_BADGE == $type) { ?>
						<div class="col-md-6">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('badge_required_approval');
										echo $fld->getCaption();
										?>
										<span class="spn_must_field">*</span></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('badge_required_approval'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } else if (Badge::TYPE_RIBBON == $type) { ?>
						<div class="col-md-6">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label"></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('badge_display_inside'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="field-set">
							<div class="caption-wraper">
								<label class="field_label">
									<?php
									$fld = $frm->getField('badge_active');
									echo $fld->getCaption();
									?>
									<span class="spn_must_field">*</span>
								</label>
							</div>
							<div class="field-wraper">
								<div class="field_cover">
									<?php echo $frm->getFieldHtml('badge_active'); ?>
								</div>
							</div>
						</div>
					</div>
					<?php $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
					if (!empty($translatorSubscriptionKey) && count($otherLangData) > 0) { ?>
						<div class="col-md-6">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label"></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('auto_update_other_langs_data'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php if (!empty($otherLangData)) {
					foreach ($otherLangData as $langId => $data) { ?>
						<div class="accordians_container accordians_container-categories" defaultLang="<?php echo $siteDefaultLangId; ?>" language="<?php echo $langId; ?>" id="accordion-language_<?php echo $langId; ?>" onClick="translateData(this)">
							<div class="accordian_panel">
								<span class="accordian_title accordianhead accordian_title mt-4 mb-0" id="collapse_<?php echo $langId; ?>">
									<?php echo $data . " ";
									echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
								</span>
								<div class="accordian_body accordiancontent" style="display: none;">
									<div class="row">
										<div class="col-md-6">
											<div class="field-set">
												<div class="caption-wraper">
													<label class="field_label">
														<?php $fld = $frm->getField('badge_name[' . $langId . ']');
														echo $fld->getCaption(); ?>
													</label>
												</div>
												<div class="field-wraper">
													<div class="field_cover">
														<?php echo $frm->getFieldHtml('badge_name[' . $langId . ']'); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				<?php }
				} 
				
				if (Badge::TYPE_BADGE == $type) { ?>
					<div class="accordians_container accordians_container-categories">
						<div class="accordian_panel">
							<span class="accordian_title accordianhead accordian_title mt-4 mb-0">
								<?php echo Labels::getLabel('LBL_MEDIA', $adminLangId); ?>
							</span>
							<div class="accordian_body accordiancontent" style="display: none;">
								<div class="row">
									<div class="col-md-4">
										<div class="field-set">
											<div class="caption-wraper">
												<label class="field_label">
													<?php $fld = $frm->getField('icon_lang_id');
													echo $fld->getCaption();
													?>
												</label>
											</div>
											<div class="field-wraper">
												<div class="field_cover">
													<?php echo $frm->getFieldHtml('icon_lang_id'); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-8">
										<div class="field-set">
											<div class="caption-wraper">
												<label class="field_label"></label>
											</div>
											<div class="field-wraper">
												<div class="field_cover d-flex">
													<?php echo $frm->getFieldHtml('icon_file_type');
													echo $frm->getFieldHtml('badge_icon'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="uploaded-img ml-2 uploadedImage--js"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }  ?>
				<div class="row mt-5">
					<div class="col-auto">
						<?php echo $frm->getFieldHtml('btn_submit'); ?>
					</div>
				</div>
			</div>
		</div>
		</form>
		<?php echo $frm->getExternalJS(); ?>
	</div>
</section>