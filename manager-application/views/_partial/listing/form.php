<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$recordId = $recordId ?? 0;
$colWidthValuesDefault = $colWidthValuesDefault ?? 12;
$formClassExtra = $formClassExtra ?? '';
$displayFooterButtons = $displayFooterButtons ?? true;

HtmlHelper::formatFormFields($frm, $colWidthValuesDefault);
if (!$frm->getFormTagAttribute('data-onclear')) {
    $frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
}

$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs ' . $formClassExtra);
if (!$frm->getFormTagAttribute('onsubmit')) {
    $frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');
}

$fld = $frm->getField('auto_update_other_langs_data');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}

$activeGentab = $activeGentab ?? true;
$disabled = (isset($recordId) && 1 > $recordId) ? 'disabled' : '';
require_once(CONF_THEME_PATH . '_partial/listing/form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    <?php if (true === $displayFooterButtons) {
        require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php');
    } ?>
</div> <!-- Close </div> This must be placed. Opening tag is inside form-head.php file. -->
