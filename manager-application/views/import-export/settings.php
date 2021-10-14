<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <?php
    $frm->setFormTagAttribute('class', 'form form--settings');
    /* $frm->setCustomRendererClass('FormRendererBS');
    $frm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
    $frm->developerTags['colWidthValuesDefault'] = [null, '12', null, null];
    $frm->developerTags['fldWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
    $frm->developerTags['fldWidthValuesDefault'] = ['cover', 'cover', 'cover', 'cover'];
    $frm->developerTags['labelWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
    $frm->developerTags['labelWidthValuesDefault'] = ['label', 'label', 'label', 'label'];
    $frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group'; */

    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-';
    $frm->developerTags['fld_default_col'] = 12;
    echo $frm->getFormHtml();
    ?>
</div>
<div class="card-foot">
<<<<<<< HEAD
    <button type="button" class="btn btn-brand  importExportBtnJs" onclick="updateSettings('frmImportExportSetting')">
        <?php
        echo Labels::getLabel('LBL_UPDATE', $adminLangId);
        ?>
    </button>
=======
    <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_UPDATE', $siteLangId), 'button', '', '', "updateSettings('frmImportExportSetting')"); ?>
>>>>>>> dcb74d5c219c2cc219cb2515001a6e3cc7e94a8f
</div>
<script>
    $(document).ready(function() {
        $('#frmImportExportSetting').find('label').addClass('switch switch-sm switch-icon').removeClass('checkbox');
        $('#frmImportExportSetting i').replaceWith('<span></span>');
        $('#frmImportExportSetting').find('.caption-wraper').remove();
    });
    $(document).on('keyup', '#frmImportExportSetting', function(e) {
        e.stopImmediatePropagation();
        if (e.keyCode === 13) {
            $('.submitBtnJs').click();
        }
    });
</script>