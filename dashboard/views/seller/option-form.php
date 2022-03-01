<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

HtmlHelper::formatFormFields($frm, 6);
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'submitOptionForm(this); return(false);');
$frm->setFormTagAttribute('data-onclear', "optionForm(" . $option_id . ");");

$fld = $frm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$fld = $frm->getField('option_name');
$fld->setFieldTagAttribute('onkeyup', "getIdentifier(this)");
$fld->htmlAfterField = "<small class='form-text text-muted'>" . HtmlHelper::getIdentifierText($identifier, $siteLangId) . '</small>';

unset($languages[CommonHelper::getDefaultFormLangId()]);

?>
<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_OPTION_SETUP', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
	<div class="form-edit-head">
        <nav class="nav nav-tabs navTabsJs">
        <?php if(0 < count($languages)){ ?>
            <a class="nav-link active" href="javascript:void(0)" onclick="optionForm(<?php echo $option_id;?>)"><?php echo Labels::getLabel('LBL_General', $siteLangId); ?></a>
            <a class="nav-link" href="javascript:void(0);" onclick="optionLangForm(<?php echo $option_id;?>,<?php echo array_key_first($languages); ?>)">
                <?php echo Labels::getLabel('LBL_Language_Data', $siteLangId); ?>
            </a>
            <?php } ?>
        </nav>
    </div>
	<div class="form-edit-body loaderContainerJs" id="editFormJs">
		<div class="row">
            <div class="col-md-12">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
	</div>
	<?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>