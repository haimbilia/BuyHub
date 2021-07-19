<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('id', 'frmPlugins');
$frm->setFormTagAttribute('class', 'form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupPluginsSettings(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
?>

<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
	<h5 class="modal-title"> <?php echo $plugin_name." ". Labels::getLabel('LBL_SELLER_PLUGIN_SETTINGS',$siteLangId);?></h5>
</div>
<div class="modal-body">
  <?php echo $frm->getFormHtml(); ?>
</div>




