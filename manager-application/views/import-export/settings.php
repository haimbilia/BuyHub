<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <?php
    $frm->setFormTagAttribute('class', 'form form--settings');

    $frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-';
    $frm->developerTags['fld_default_col'] = 12;
    echo $frm->getFormHtml();
    ?>
</div>
<div class="card-foot">
    <button type="button" class="btn btn-brand  importExportBtnJs" onclick="updateSettings('frmImportExportSetting')">
        <?php echo Labels::getLabel('LBL_UPDATE', $siteLangId); ?>
    </button>
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