<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setCustomRendererClass('FormRendererBS');

$langFrm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
$langFrm->developerTags['colWidthValuesDefault'] = [null, '12', null, null];
$langFrm->developerTags['fldWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$langFrm->developerTags['fldWidthValuesDefault'] = ['cover', 'cover', 'cover', 'cover'];
$langFrm->developerTags['labelWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$langFrm->developerTags['labelWidthValuesDefault'] = ['label', 'label', 'label', 'label'];
$langFrm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';

$langFrm->setFormTagAttribute('class', 'form');
$langFrm->setFormTagAttribute('onsubmit', 'setupLangRate(this); return(false);');


//$langFrm->developerTags['colClassPrefix'] = 'col-sm-4 col-md-';
//$langFrm->developerTags['fld_default_col'] = 12;
/*
$cancelFld = $langFrm->getField('btn_cancel');
$cancelFld->setFieldTagAttribute('onClick', 'clearForm(); return false;');
$cancelFld->setFieldTagAttribute('class', 'btn btn-outline-brand');
$cancelFld->developerTags['noCaptionTag'] = true;
$cancelFld->developerTags['colClassBeforeWidth'] = 'col-auto';
$cancelFld->developerTags['colWidthClasses'] = [null, null, null, null];
$cancelFld->developerTags['colWidthValues'] = [null, null, null, null];
 * 
 */

$btnSubmit = $langFrm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
$btnSubmit->developerTags['noCaptionTag'] = true;
$btnSubmit->developerTags['colClassBeforeWidth'] = 'col';
$btnSubmit->developerTags['colWidthClasses'] = [null, null, null, null];
$btnSubmit->developerTags['colWidthValues'] = [null, null, null, null];


?>

<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Manage_Rates', $siteLangId); ?></h5>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-12">
			<nav class="nav nav-tabs tabsNavJs">
				<a class="nav-link" href="javascript:void(0);" onclick="addEditShipRates(<?php echo $zoneId ?>, <?php echo $rateId ?>);">
					<?php echo Labels::getLabel('LBL_General', $siteLangId); ?>
				</a>
				<?php
				foreach ($languages as $key => $langName) {
					$class = ($langId == $key) ? 'active' : ''; ?>
					<a class="nav-link <?php echo $class; ?>" href="javascript:void(0);" <?php if ($rateId > 0) { ?> onclick="editRateLangForm(<?php echo $zoneId ?>, <?php echo $rateId ?>, <?php echo $key; ?>);" <?php } ?>>
						<?php echo $langName; ?>
					</a>
				<?php
				} ?>
			</nav>
			<div class="tabs__content" dir="<?php echo $formLayout; ?>">
				<?php echo $langFrm->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>