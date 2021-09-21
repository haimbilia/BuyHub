<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

$disabled = (0 == $recordId) ? 'disabled' : '';
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COUNTRY_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-head">
        <nav class="nav nav-tabs">
            <a class="nav-link active" href="javascript:void(0)" onclick="editRecord(<?php echo $recordId ?>);">
                <?php echo Labels::getLabel('LBL_General', $adminLangId); ?>
            </a>
            <a class="nav-link <?php echo $disabled; ?>" href="javascript:void(0);" <?php echo (0 < $recordId) ? "onclick='editLangData(" . $recordId . "," . FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1) . ");'" : ""; ?>>
                <?php echo Labels::getLabel('LBL_Language_Data', $adminLangId); ?>
            </a>
        </nav>
    </div>

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