<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

$fld = $frm->getField('afcommsetting_user_id');
$fld->setfieldTagAttribute('id', "afcommsetting_user_id");

$fld = $frm->getField('afcommsetting_prodcat_id');
$fld->setfieldTagAttribute('id', "afcommsetting_prodcat_id");


?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMISSION_SETUP', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script type="text/javascript">
$("document").ready(function(){
	select2('afcommsetting_user_id',fcom.makeUrl('Users', 'autoCompleteJson'),{
		user_is_affiliate: 1, credential_active: 1, credential_verified: 1
	});
	select2('afcommsetting_prodcat_id',fcom.makeUrl('productCategories', 'links_autocomplete'),{fIsAjax:1});
});
</script>