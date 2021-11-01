<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <?php
    HtmlHelper::formatFormFields($frm, 6);
    $frm->setFormTagAttribute('class', 'form form--settings');
    $frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
    echo $frm->getFormHtml();
    ?>
</div>
<div class="card-foot">
    <button type="button" class="btn btn-brand  importExportBtnJs" onclick="updateSettings('frmImportExportSetting')">
        <?php echo Labels::getLabel('LBL_UPDATE', $siteLangId); ?>
    </button>
</div>
<script>
    $(document).on('keyup', '#frmImportExportSetting', function(e) {
        e.stopImmediatePropagation();
        if (e.keyCode === 13) {
            $('.submitBtnJs').click();
        }
    });
</script>