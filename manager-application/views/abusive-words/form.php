<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('id', 'frmAbusiveWord');
$frm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
	
$fld = $frm->getField('abusive_lang_id');
$fld->addFieldTagAttribute( 'onChange', 'changeFormLayOut(this);' );
?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_ABUSIVE_KEYWORD_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
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