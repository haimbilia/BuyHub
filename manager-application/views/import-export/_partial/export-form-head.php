<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'modal-body form form-edit');

$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

if (in_array($actionType, $actionTypeArr)) {
	$startIdFld = $frm->getField('start_id');
	$startIdFld->setWrapperAttribute('class', 'range_fld');

	$endIdFld = $frm->getField('end_id');
	$endIdFld->setWrapperAttribute('class', 'range_fld');

	$batchCountFld = $frm->getField('batch_count');
	$batchCountFld->setWrapperAttribute('class', 'batch_fld');

	$batchNumberFld = $frm->getField('batch_number');
	$batchNumberFld->setWrapperAttribute('class', 'batch_fld');

	$rangeTypeFld = $frm->getField('export_data_range');
	$rangeTypeFld->setfieldTagAttribute('onchange', "showHideExtraFld(this.value," . Importexport::BY_ID_RANGE . "," . Importexport::BY_BATCHES . ");");
}

$activeContentTab = !empty($activeContentTab) ? 'active' : '';
$activeMediaTab = !empty($activeMediaTab) ? 'active' : '';
?>
<div class="modal-header">
	<h5 class="modal-title">
		<?php echo $formTitle; ?>
	</h5>
</div>
<div class="modal-body form-edit">
    <?php if ($displayMediaTab) { ?>
        <div class="form-edit-head">
            <nav class="nav nav-tabs">
                <a class="nav-link <?php echo $activeContentTab; ?>" href="javascript:void(0)" onclick="exportForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_CONTENT', $siteLangId); ?>">
                    <?php echo Labels::getLabel('LBL_CONTENT', $siteLangId); ?>
                </a>

                <a class="nav-link <?php echo $activeMediaTab; ?>" href="javascript:void(0)" onclick="exportMediaForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>">
                    <?php echo Labels::getLabel('LBL_MEDIA', $siteLangId); ?>
                </a>
            </nav>
        </div>
    <?php } ?>
	<div class="form-edit-body loaderContainerJs">
		<?php echo $frm->getFormHtml(); ?>
	</div>

	<div class="form-edit-foot">
		<div class="row">
			<div class="col-auto">
				<button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
					<?php
					echo Labels::getLabel('LBL_EXPORT', $siteLangId);
					?>
				</button>
			</div>
		</div>
	</div>
</div>