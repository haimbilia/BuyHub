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
?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_BADGES_SETUP', $adminLangId); ?></h4>
		<div class="section__toolbar">
			<a href="javascript:void(0);" onclick="backToListing();" title="Back" class="btn-clean btn-sm btn-icon btn-secondary "><i class="fas fa-arrow-left"></i></a>
		</div>
	</div>
	<div class="sectionbody space">
		<?php echo $frm->getFormTag();
			echo $frm->getFieldHtml('badge_id');
			echo $frm->getFieldHtml('badge_type');
			?>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="row">
						<div class="col">
							<h3 class="form__heading">
								<?php echo Labels::getLabel('LBL_GENERAL', $adminLangId); ?>
							</h3>
						</div>
						<div class="col-auto">
							<?php echo $frm->getFieldHtml('btn_submit'); ?>
						</div>
					</div>
					<div class="row">
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
					</div>
					<div class="row">
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
						<div class="col-md-6">
							<div class="field-set">
								<div class="caption-wraper">
									<label class="field_label">
										<?php
										$fld = $frm->getField('badge_active');
										echo $fld->getCaption();
										?>
										<span class="spn_must_field">*</span></label>
								</div>
								<div class="field-wraper">
									<div class="field_cover">
										<?php echo $frm->getFieldHtml('badge_active'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php if (Badge::TYPE_RIBBON == $type) { ?>
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
					} ?>
				</div>
			</div>
		</form>
		<?php echo $frm->getExternalJS(); ?>
	</div>
</section>