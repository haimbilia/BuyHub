<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form ');

$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;
$frm->setFormTagAttribute('onSubmit', 'uploadZip(); return false;');

$fldSubmit = $frm->getField('btn_submit');
$fldSubmit->setFieldTagAttribute('class', "btn btn-brand btn-wide"); ?>

<div class="card-head">
    <?php $variables = array('siteLangId' => $siteLangId, 'action' => $action, 'canEditImportExport' => $canEditImportExport, 'canUploadBulkImages' => $canUploadBulkImages);
    $this->includeTemplate('import-export/_partial/top-navigation.php', $variables, false); ?>
</div>
<div class="card-body">
    <?php echo $frm->getFormHtml();  ?>
</div>
<div class="card-table">
    <div id="listing">
        <?php echo Labels::getLabel('LBL_Processing...', $siteLangId); ?>
    </div>
</div>