<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editMetaTagForm(' . $metaId . ', "' . $metaType . '", ' . $metaTagRecordId . ')');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'setupMetaTag(this); return(false);');

$fld = $frm->getField('url');
$fld->addFieldTagAttribute('class', 'metaUrlJs');

$fld = $frm->getField('meta_controller');
$fld->addFieldTagAttribute('class', 'metaControllerJs');

$fld = $frm->getField('meta_action');
$fld->addFieldTagAttribute('class', 'metaActionJs');

$fld = $frm->getField('meta_record_id');
$fld->addFieldTagAttribute('class', 'metaRecordIdJs');

$fld = $frm->getField('meta_subrecord_id');
$fld->addFieldTagAttribute('class', 'metaSubRecordIdJs');

$activeGentab = true;
$disabled = (isset($metaId) && 1 > $metaId) ? 'disabled' : '';
$formTitle = Labels::getLabel('LBL_META_TAG_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . 'meta-tags/_partials/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->