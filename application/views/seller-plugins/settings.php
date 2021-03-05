<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('id', 'frmPlugins');
$frm->setFormTagAttribute('class', 'form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'setupPluginsSettings(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 6;

$btnSubmit = $frm->getField('btn_submit');
$btnSubmit->setFieldTagAttribute('class', "btn btn-brand");
?>

<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="pop-up-title">
  <?php echo Labels::getLabel('LBL_PLUGIN_SETTINGS',$siteLangId);?>
</div>

<?php echo $frm->getFormHtml(); ?>


