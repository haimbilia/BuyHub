<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm, 4);
$frm->setFormTagAttribute('class', 'form form--settings'); ?>

<div class="card-head">
    <?php $variables = array('siteLangId' => $siteLangId, 'action' => $action, 'canEditImportExport' => $canEditImportExport, 'canUploadBulkImages' => $canUploadBulkImages);
    $this->includeTemplate('import-export/_partial/top-navigation.php', $variables, false); ?>
</div>
<div class="card-body">
    <div class="tabs__content">
        <div class="row">
            <div class="col-md-12" id="settingFormBlock">
                <?php echo $frm->getFormHtml(); ?>
            </div>
        </div>
    </div>
</div>
<div class="card-foot">
    <button type="button" class="btn btn-brand  importExportBtnJs" onclick="updateSettings('frmImportExportSetting')">
        <?php echo Labels::getLabel('LBL_UPDATE', $siteLangId); ?>
    </button>
</div>