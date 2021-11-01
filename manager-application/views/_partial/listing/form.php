<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$recordId = $recordId ?? 0;
$formClassExtra = $formClassExtra ?? '';
$formOnSubmit = $formOnSubmit ?? 'saveRecord(this); return(false);';

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs ' . $formClassExtra);
$frm->setFormTagAttribute('onsubmit', $formOnSubmit);

$activeGentab = true;
$disabled = (isset($recordId) && 1 > $recordId) ? 'disabled' : '';
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->