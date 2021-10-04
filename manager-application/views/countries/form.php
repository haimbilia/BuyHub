<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

$fld = $frm->getField('country_code');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('country_code_alpha3');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('country_language_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('country_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$disabled = (1 > $recordId) ? 'disabled' : ''; ?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COUNTRY_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <?php if (0 < count($languages)) { ?>
        <div class="form-edit-head">
            <nav class="nav nav-tabs">
                <a class="nav-link active" href="javascript:void(0)" onclick="editRecord(<?php echo $recordId ?>);">
                    <?php echo Labels::getLabel('LBL_GENERAL', $adminLangId); ?>
                </a>
                <a class="nav-link <?php echo $disabled; ?>" href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='editLangData(" . $recordId . "," . array_key_first($languages) . ");'" : ""; ?>>
                    <?php echo Labels::getLabel('LBL_LANGUAGE_DATA', $adminLangId); ?>
                </a>
            </nav>
        </div>
    <?php } ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php 
                        if (0 < $recordId) {
                            echo Labels::getLabel('LBL_UPDATE', $adminLangId); 
                        } else {
                            echo Labels::getLabel('LBL_SAVE', $adminLangId); 
                        }
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>