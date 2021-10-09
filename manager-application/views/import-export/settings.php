<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body">
    <?php    
    $frm->setFormTagAttribute('onsubmit', 'updateSettings(this); return(false);');
    // $frm->setFormTagAttribute('class', 'web_form');

    $frm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
    $frm->developerTags['colWidthValuesDefault'] = [null, '12', null, null];
    $frm->developerTags['fldWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
    $frm->developerTags['fldWidthValuesDefault'] = ['cover', 'cover', 'cover', 'cover'];
    $frm->developerTags['labelWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
    $frm->developerTags['labelWidthValuesDefault'] = ['label', 'label', 'label', 'label'];
    $frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';

    $frm->developerTags['colClassPrefix'] = 'col-lg-6 col-md-';
    $frm->developerTags['fld_default_col'] = 6;
    echo $frm->getFormHtml(); ?>
</div>
<div class="card-foot">
    <button type="button" class="btn btn-brand gb-btn gb-btn-primary importExportBtnJs" onclick="updateSettings('frmImportExportSetting')">
        <?php
        echo Labels::getLabel('LBL_UPDATE', $adminLangId);
        ?>
    </button>
</div>