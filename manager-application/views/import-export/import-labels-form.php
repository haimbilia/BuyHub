<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute( 'onSubmit', 'uploadLabelsImportFile(this); return false;' );
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_Import_Labels',$siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>

		<div id="fileupload_div"></div>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php
                    echo Labels::getLabel('LBL_IMPORT', $siteLangId);
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>