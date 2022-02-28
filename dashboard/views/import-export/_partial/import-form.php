<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form modalFormJs');

require_once(CONF_THEME_PATH . 'import-export/_partial/import-form-head.php'); ?>
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
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
</div> <!-- Close </div> This must be placed. Opening tag is inside import-form-head.php file. -->