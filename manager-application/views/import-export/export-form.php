<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onSubmit', 'exportData(this,' . $actionType . '); return false;');
<<<<<<< HEAD

$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$actionTypeArr = array(Importexport::TYPE_PRODUCTS, Importexport::TYPE_SELLER_PRODUCTS, Importexport::TYPE_INVENTORIES, Importexport::TYPE_USERS);
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
?>
<div class="modal-header">
	<h5 class="modal-title">
		<?php echo $formTitle; ?>
	</h5>
</div>
<div class="modal-body form-edit">
	<!-- Closing tag must be added inside the files who include this file. -->
	<div class="form-edit-head">
		<nav class="nav nav-tabs">
			<a class="nav-link active" href="javascript:void(0)" onclick="exportForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_CONTENT', $adminLangId); ?>">
				<?php echo Labels::getLabel('LBL_CONTENT', $adminLangId); ?>
			</a>
			<?php if ($displayMediaTab) { ?>
				<a class="nav-link" href="javascript:void(0)" onclick="exportMediaForm('<?php echo $actionType; ?>');" title="<?php echo Labels::getLabel('LBL_MEDIA', $adminLangId); ?>">
					<?php echo Labels::getLabel('LBL_MEDIA', $adminLangId); ?>
				</a>
			<?php } ?>
		</nav>
	</div>
	<div class="form-edit-body loaderContainerJs">
		<?php echo $frm->getFormHtml(); ?>
	</div>

	<div class="form-edit-foot">
		<div class="row">
			<div class="col-auto">
				<button type="button" class="btn btn-brand  submitBtnJs">
					<?php
					echo Labels::getLabel('LBL_EXPORT', $adminLangId);
					?>
				</button>
			</div>
		</div>
	</div>
</div>
=======
$actionTypeArr = [
    Importexport::TYPE_PRODUCTS,
    Importexport::TYPE_SELLER_PRODUCTS,
    Importexport::TYPE_INVENTORIES,
    Importexport::TYPE_USERS
];
$activeContentTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/export-form-head.php');
>>>>>>> dcb74d5c219c2cc219cb2515001a6e3cc7e94a8f
