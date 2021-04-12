<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupRatingTypes(this); return(false);');
$frm->setFormTagAttribute('id', 'frmRatingTypes');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_RATING_TYPES_SETUP',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">
			<div class="col-sm-12">
				<div class="tabs_nav_container responsive flat">
					<ul class="tabs_nav">
						<li><a class="active" href="javascript:void(0)"
								onclick="ratingTypesForm(<?php echo $rtId ?>);"><?php echo Labels::getLabel('LBL_General', $adminLangId);?></a>
						</li>
						<li class="<?php echo (0 == $rtId) ? 'fat-inactive' : ''; ?>">
							<a href="javascript:void(0);" <?php echo (0 < $rtId) ? "onclick='ratingTypesLangForm(" . $rtId . "," . $adminLangId . ");'" : ""; ?>>
								<?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
							</a>
						</li>
					</ul>
					<div class="tabs_panel_wrap">
						<div class="tabs_panel">
							<?php echo $frm->getFormHtml(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>												
</section>