<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$frm->setFormTagAttribute('class', 'web_form form_horizontal');
$frm->setFormTagAttribute('onsubmit', 'setup(this); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
?>

<div class="tabs_panel_wrap tabs_panel--js" style="min-height: inherit;">
	<div class="tabs_panel">
		<?php echo $frm->getFormHtml(); ?>
	</div>
</div>